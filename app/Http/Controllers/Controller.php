<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function returnForbidden($msg) : Response {
        return response(['message' => $msg], Response::HTTP_FORBIDDEN);
    }

    /**
     * @param $data
     * @param $total
     * @param $perPage
     * @return Response
     */
    public function paginatedResult($data, $total, $perPage) : Response {
        return response([
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage
        ]);
    }
}
