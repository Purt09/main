<?php

namespace App\Shared\Infrastructure\Controller;

use App\Core\Exception\AuthException;
use App\Core\Exception\LogicException;
use App\Core\Exception\NotAccessException;
use App\Core\Exception\NotFoundException;
use App\Core\Exception\ValidatorException;
use App\Shared\Application\Helper\ApiHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController
{
    #[Route('/not-access', methods: ['GET'])]
    public function notAccess(): Response
    {
        try {
            throw new NotAccessException('not access');
        } catch (LogicException $e) {
            return new JsonResponse(ApiHelper::error($e), $e->getCode());
        }
    }

    #[Route('/not-allowed', methods: ['POST'])]
    public function notAllowed(): Response
    {
        return new JsonResponse(ApiHelper::success('ok'));
    }

    #[Route('/not-auth', methods: ['GET'])]
    public function notAuth(): Response
    {
        try {
            throw new AuthException('not auth');
        } catch (LogicException $e) {
            return new JsonResponse(ApiHelper::error($e), $e->getCode());
        }
    }

    #[Route('/not-found', methods: ['GET'])]
    public function notFound(): Response
    {
        try {
            throw new NotFoundException('not found');
        } catch (LogicException $e) {
            return new JsonResponse(ApiHelper::error($e), $e->getCode());
        }
    }

    #[Route('/not-params', methods: ['GET'])]
    public function notParams(Request $request): Response
    {
        try {
            $test = $request->get('test');
            if (is_null($test)) {
                throw new ValidatorException('not found test');
            }

            return new JsonResponse(ApiHelper::success($test));
        } catch (LogicException $e) {
            return new JsonResponse(ApiHelper::error($e), $e->getCode());
        }
    }
}
