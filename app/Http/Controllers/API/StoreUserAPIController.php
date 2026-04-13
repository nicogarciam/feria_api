<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\Account;
use App\Models\Store;
use App\Models\User;
use App\Mail\StoreInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Response;
use Facades\App\Services\DataAccessValidation;

class StoreUserAPIController extends AppBaseController
{
    /**
     * Display a listing of the users for a specified store.
     */
    public function index($storeId)
    {
        if (!DataAccessValidation::validateStore($storeId)) {
            return $this->sendError('Unauthorized', 403);
        }

        $store = Store::find($storeId);
        if (!$store) {
            return $this->sendError('Store not found');
        }

        $users = $store->users()->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage (Add/Invite user).
     */
    public function store($storeId, Request $request)
    {
        if (!DataAccessValidation::validateStore($storeId)) {
            return $this->sendError('Unauthorized', 403);
        }

        $request->validate([
            'email' => 'required|email',
            'role' => 'required|string'
        ]);

        $email = $request->input('email');
        $role = $request->input('role');
        $store = Store::find($storeId);

        $user = User::where('email', $email)->first();
        $tempPassword = null;

        if (!$user) {
            // Create New User
            $tempPassword = Str::random(10);
            $user = User::create([
                'name' => explode('@', $email)[0],
                'email' => $email,
                'password' => Hash::make($tempPassword),
                'logins' => 0
            ]);

            // Create Account for the new user
            Account::create([
                'user_id' => $user->id,
                'email' => $email,
                'first_name' => $user->name,
                'activated' => false
            ]);
        }

        // Check if already linked
        if ($store->users()->where('user_id', $user->id)->exists()) {
            return $this->sendError('El usuario ya tiene acceso a esta tienda', 422);
        }

        // Link User to Store
        $store->users()->attach($user->id, [
            'role' => $role,
            'active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Send Invitation Email
        try {
            Mail::to($email)->send(new StoreInvitation($user, $store, $tempPassword));
        } catch (\Exception $e) {
            // Log error but continue
            \Log::error('Error sending store invitation: ' . $e->getMessage());
        }

        return $this->sendResponse($user, 'Usuario invitado correctamente');
    }

    /**
     * Remove the specified resource from storage (Remove user from store).
     */
    public function destroy($storeId, $userId)
    {
        if (!DataAccessValidation::validateStore($storeId)) {
            return $this->sendError('Unauthorized', 403);
        }

        $store = Store::find($storeId);
        if (!$store) {
            return $this->sendError('Store not found');
        }

        // Prevent owner from being removed if necessary (optional)
        if ($store->owner_id == $userId) {
            return $this->sendError('No se puede eliminar al dueño de la tienda', 422);
        }

        $store->users()->detach($userId);

        return $this->sendSuccess('Usuario removido de la tienda');
    }

    /**
     * Update the specified resource in storage (Change role or active status).
     */
    public function update($storeId, $userId, Request $request)
    {
        if (!DataAccessValidation::validateStore($storeId)) {
            return $this->sendError('Unauthorized', 403);
        }

        $store = Store::find($storeId);
        if (!$store) {
            return $this->sendError('Store not found');
        }

        $attributes = [];
        if ($request->has('role')) {
            $attributes['role'] = $request->input('role');
        }
        if ($request->has('active')) {
            $attributes['active'] = $request->input('active') ? 1 : 0;
        }

        if (empty($attributes)) {
            return $this->sendError('No attributes to update', 400);
        }

        $store->users()->updateExistingPivot($userId, $attributes);

        return $this->sendSuccess('Usuario actualizado correctamente');
    }
}
