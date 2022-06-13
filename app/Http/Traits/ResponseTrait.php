<?php

namespace App\Http\Traits;
use Request;

trait ResponseTrait
{
    /**
     * @param $msg
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function respErrorResponse($msg, $code = 400)
    {
        return response()->json([
            'url' => Request::route()->uri,
            'type' => Request::method(),
            'query' => !empty($attribute['query'])?$attribute['query']:[],
            'response' => [
                'code'      => $code,
                'message'   => $msg,
                'status'    => 'error'
            ]
        ], $code);
    }

    /**
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function respSuccessResponse($attribute, $code = 200)
    {
        return response()->json([
            'url' => Request::route()->uri,
            'type' => Request::method(),
            'query' => !empty($attribute['query'])?$attribute['query']:[],
            'response' => [
                'code'  => $code,
                'data'  => array(
                    'items' => $attribute['data'],
                    'totalCount' => $attribute['totalCount'],
                ),
                'status' => 'success'
            ]
        ], $code);

    }

   /**
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonResponse($data, $code = 200)
    {
        return response()->json([
            'code'  => $code,
            'data'  => $data,
            'status' => $code < 400 ? 'success':'error'
        ], $code);

    }

    /**
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginResponse($data, $code = 200)
    {
        return response()->json([
            'code'  => $code,
            'data'  => $data,
            'status' => $code==200?'success':'error'
        ], $code);
    }
}
