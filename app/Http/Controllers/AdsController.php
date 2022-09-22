<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdResource;
use App\Models\Ad;
use App\OpenApi\Parameters\AdsFilterParameters;
use App\OpenApi\Responses\AdsFilterResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class AdsController extends Controller
{
    /**
     * @return Response
     */
    #[OpenApi\Operation(tags: ['ads'], method: 'GET')]
    #[OpenApi\Parameters(factory: AdsFilterParameters::class)]
    #[OpenApi\Response(factory: AdsFilterResponse::class, statusCode: 200)]
    public function filter() : Response {
        $adsQuery = Ad::with(['tags', 'category', 'advertiser']);
        $limit = request()->get("limit") ?? 10;
        return $this->adsResponse(Ad::filters(collect(Ad::getFilters()), $adsQuery), $limit);
    }

    public function adsByAdvertiser($advertiserId) : Response {
        $adsQuery = Ad::with(['tags', 'category', 'advertiser']);
        $limit = request()->get("limit") ?? 10;
        return $this->adsResponse($adsQuery->where('advertiser_id', $advertiserId), $limit);
    }

    private function adsResponse(Builder $query, $limit) : Response {
        $data = $query->paginate($limit);
        return $this->paginatedResult(
            AdResource::collection($data->items()),
            $data->total(),
            $limit
        );
    }
}
