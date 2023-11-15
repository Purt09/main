<?php

namespace App\Shared\Infrastructure\Controller;

use App\Shared\Application\Helper\ApiHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ping', methods: ['GET'])]
class PingAction
{
    public function __invoke(): Response
    {
        return new JsonResponse(ApiHelper::success('ok'));
    }
}
