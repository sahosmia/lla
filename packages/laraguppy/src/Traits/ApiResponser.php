<?php

namespace Amentotech\LaraGuppy\Traits;


/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponser {
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, string $message = null, int $code = 200) {
        return response()->json([
            'type'      => 'success',
            'message'   => $message,
            'data'      => $data
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
    protected function error(string $message = null, $data = null, int $code = 400) {
        return response()->json([
            'type' => 'error',
            'message' => $message,
            'errors' => $data
        ], $code);
    }
}
