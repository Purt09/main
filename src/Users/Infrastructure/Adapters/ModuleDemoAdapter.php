<?php

namespace App\Users\Infrastructure\Adapters;

use App\ModuleDemo\Infrastructure\API\API;

/**
 * Пример взаимодействия между модулями
 */
class ModuleDemoAdapter
{
    public function __construct(private readonly API $moduleDemoApi)
    {
    }

    public function getSomeData(): array
    {
        $result = $this->moduleDemoApi->getSomeData();
        // mapping

        return [];
    }
}