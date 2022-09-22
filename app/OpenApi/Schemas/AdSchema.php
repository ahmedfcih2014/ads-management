<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class AdSchema extends SchemaFactory
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Ad')
            ->properties(
                Schema::integer("id")->example(1)->description("ad id"),
                Schema::string("type")->example("free")->description("ad type")->enum(["free", "paid"]),
                Schema::string("title")->example("Ad Title")->description("ad title"),
                Schema::string("description")->example("Ad Description")->description("ad description"),
                Schema::string("start_date")->example("2022-09-30")->description("ad start date"),
                Schema::ref(AdvertiserSchema::class),
                Schema::ref(CategorySchema::class),
                Schema::array("tags")->description("list of tags related to ad")
                ->items(Schema::ref(TagSchema::class))
            );
    }
}
