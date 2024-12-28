<?php

if (!function_exists('customDatatableResponse')) {
    function customDatatableResponse($query, $request)
    {
        $totalRecords = $query->count();
        $query->skip($request->input('start'))->take($request->input('length'));
        $filteredRecords = $query->orderBy('id', 'desc')->get();

        return response()->json([
            'draw'            => $request->input('draw'),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data'            => $filteredRecords,
        ]);
    }
}