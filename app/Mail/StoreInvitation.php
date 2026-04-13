<?php

namespace App\Mail;

use App\Models\Store;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StoreInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $store;
    public $tempPassword;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param Store $store
     * @param string|null $tempPassword
     */
    public function __construct(User $user, Store $store, $tempPassword = null)
    {
        $this->user = $user;
        $this->store = $store;
        $this->tempPassword = $tempPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitación a colaborar en ' . $this->store->name)
                    ->view('emails.store_invitation');
    }
}
