<?php
namespace App\Services;
class PaginationService
{
    public static function forAngular($query, $request)
    {
        $page = (int) $request->get('page', 1);
        $size = (int) $request->get('size', 10);

        $result = $query->paginate($size, ['*'], 'page', $page);


        return response()
            ->json($result)
            ->header('X-Total-Count', $result->total())
            ->header('Access-Control-Expose-Headers', 'X-Total-Count');
    }
}
