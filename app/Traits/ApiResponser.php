<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponser
{
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data = null, ?string $message = null, int $code = 200)
    {
        return response()->json(
            ['status' => $code]
                + (!empty($message) ? ['message' => $message] : [])
                + (!empty($data) ?    ['data'    => $data]    : []),
            $code
        );
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(?string $message = null, $data = null, int $code = 400)
    {

        return response()->json(
            ['status' => $code]
                + (!empty($message) ? ['message' => $message] : []),
            $code
        );
    }

    /**
     * Return an validation errors JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function validationError(?string $message = null, $errors = null, int $code = 422)
    {
        $error_list = collect($errors->toArray())->mapWithKeys(function ($messages, $field) {
            return [$field => $messages[0]];
        });

        return response()->json(
            ['status' => $code]
                + (!empty($message) ? ['message' => $message] : [])
                + (!empty($error_list) ? ['errors'    => $error_list]    : []),
            $code
        );
    }
}
