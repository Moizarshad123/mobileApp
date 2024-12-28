<?php

namespace App\Traits;

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponserTrait
{
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, $message = '', $code = 200, $errors=[])
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'errors' => (object)$errors
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message = '', $code = 200, $data = [], $errors=[])
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data,
            'errors' => $errors
        ], $code);
    }

}
