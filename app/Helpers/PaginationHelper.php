<?php

if (!function_exists('paginateForAngular')) {

    function paginateForAngular($query, $request)
    {
        $page = (int) $request->get('page', 1);
        $size = (int) $request->get('size', 10);

        // Sorting
        if ($request->has('sort')) {
            foreach ($request->get('sort') as $sort) {
                [$field, $direction] = explode(',', $sort);
                $query->orderBy($field, $direction);
            }
        }

        $result = $query->paginate($size, ['*'], 'page', $page);

        return response()
            ->json($result->items())
            ->header('X-Total-Count', $result->total())
            ->header('Access-Control-Expose-Headers', 'X-Total-Count');
    }
}
