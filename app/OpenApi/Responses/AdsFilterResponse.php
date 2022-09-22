<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\AdSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class AdsFilterResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::object()
        ->properties(
            Schema::integer("total")->description("total number of ads in db")->example("100"),
            Schema::integer("per_page")->description("total number of ads returned in each page")->example("10"),
            Schema::array('data')->description("list of ads object")
            ->items(
                Schema::ref(AdSchema::class)
            )
        );

        return Response::create('AdsList')
            ->description('list of ads')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}
