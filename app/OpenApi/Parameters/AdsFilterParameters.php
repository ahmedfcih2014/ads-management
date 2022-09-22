<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class AdsFilterParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [
            Parameter::query()
                ->name('tag_id')
                ->description('tag_id for searching in ads by it')
                ->required(false)
                ->schema(Schema::integer()),
            Parameter::query()
                ->name('category_id')
                ->description('category_id for searching in ads by it')
                ->required(false)
                ->schema(Schema::integer()),
        ];
    }
}
