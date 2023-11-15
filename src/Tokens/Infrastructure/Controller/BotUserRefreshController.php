<?php

namespace App\Tokens\Infrastructure\Controller;

use App\Core\Exception\LogicException;
use App\Core\Exception\NotFoundException;
use App\Core\Exception\ValidatorException;
use App\Shared\Application\Command\CommandBusInterface;
use App\Shared\Application\Helper\ApiHelper;
use App\Tokens\Application\Command\AuthBotUser\AuthBotUserCommand;
use App\Tokens\Application\Command\RefreshToken\RefreshTokenCommand;
use App\Tokens\Application\DTO\AuthTokenDto;
use App\Tokens\Application\Helper\HashHelper;
use App\Tokens\Infrastructure\Requests\BotUserRequest;
use OpenApi\Attributes\MediaType;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use OpenApi\Attributes\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class BotUserRefreshController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $bus,
    ) {
    }

    #[Route('/api/v1/auth-user-work', methods: ['POST'], name: 'Auth User Work')]
    public function authWork(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (!array_key_exists('bot_id', $data)) {
                throw new NotFoundException('bot_id not found');
            }
            if (!array_key_exists('data', $data)) {
                throw new NotFoundException('data not found');
            }
            if ('test' == $_ENV['APP_ENV']) {
                $token = $_ENV['TOKEN_SHOP'];
            } else {
                // Отправляю по api запрос на получение токена с сервера и роли пользователя
            }
            // Данные авторизации
            parse_str($data['data'], $auth_data);
            $user_id = HashHelper::checkHash($auth_data, $token);

            $userAgent = $request->headers->get('User-Agent');
            if (is_null($userAgent)) {
                $userAgent = '';
            }

            $commandAuth = new AuthBotUserCommand(
                $user_id,
                $request->getClientIp(),
                $userAgent,
                $data['bot_id']
            );
            $dto = $this->bus->execute($commandAuth);

            return new JsonResponse(ApiHelper::success($dto));
        } catch (LogicException $e) {
            return new JsonResponse(ApiHelper::error($e), $e->getCode());
        } catch (Throwable $e) {
            return new JsonResponse(ApiHelper::errorServer($e));
        }
    }

    #[Route('/api/v1/refresh', methods: ['POST'], name: 'Refresh token')]
    public function refresh(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (!array_key_exists('token', $data)) {
                throw new NotFoundException('token not found');
            }
            $token = $data['token'];

            $userAgent = $request->headers->get('User-Agent');
            if (is_null($userAgent)) {
                $userAgent = '';
            }

            $commandAuth = new RefreshTokenCommand(
                $token,
                $request->getClientIp(),
                $userAgent,
            );

            $dto = $this->bus->execute($commandAuth);

            return new JsonResponse(ApiHelper::success($dto));
        } catch (LogicException $e) {
            return new JsonResponse(ApiHelper::error($e), $e->getCode());
        } catch (Throwable $e) {
            return new JsonResponse(ApiHelper::errorServer($e));
        }
    }

    #[Route('/api/v1/auth-user', methods: ['POST'], name: 'Auth User')]
    #[Response(
        response: 400,
        description: 'Неверные данные запроса',
        content: new MediaType(
            mediaType: 'application/json',
        )
    )]
    #[Parameter(
        name: 'data',
        description: 'Строка с данными для авторизации',
        in: 'query',
        required: true,
        schema: new Schema(type: 'string', maxLength: 1000, minLength: 100),
        example: 'query_id=AAGeW2guAAAAAJ5baC6TsfAM&user=%7B%22id%22%3A778591134%2C%22first_name%22%3A%22%D0%90%D0%BB%D0%B5%D0%BA%D1%81%D0%B0%D0%BD%D0%B4%D1%80%22%2C%22last_name%22%3A%22%D0%9F%D1%83%D1%80%D1%82%D0%BE%D0%B2%22%2C%22username%22%3A%22APURTIK%22%2C%22language_code%22%3A%22ru%22%2C%22allows_write_to_pm%22%3Atrue%7D&auth_date=1697914788&hash=6f1bb0be6c33ca2a36a4b33e8f88e609aa0c2644e536b5ca00aeb4ff2756d027'
    )]
    public function auth(#[RequestBody] BotUserRequest $request): JsonResponse
    {
        try {
            return new JsonResponse(ApiHelper::success(1));
            $errors = $this->validator->validate($request);

            if (!array_key_exists('bot_id', $data)) {
                throw new NotFoundException('bot_id not found');
            }
            if (!array_key_exists('data', $data)) {
                throw new NotFoundException('data not found');
            }
            if (is_null($data)) {
                throw new ValidatorException('not found data');
            }

            $auth = new AuthTokenDto();
            $command = new AuthBotUserCommand();
            $auth->token = $this->bus->execute($command);

            return new JsonResponse(ApiHelper::success($auth));
        } catch (LogicException $e) {
            return new JsonResponse(ApiHelper::error($e), $e->getCode());
        } catch (Throwable $e) {
            return new JsonResponse(ApiHelper::errorServer($e));
        }
//        $user_id = HashHelper::checkHash($authBotUserCommand->data, $authBotUserCommand->token);
//        $command = new AuthBotUserCommand(
//            $user_id,
//            $data,
//            885,
//        );
//        $test = $this->bus->execute($command);
//        return new JsonResponse([
//            'ulid' => 1,
//            'email' => 2,
//            'text' => $test,
//        ]);
    }

    //    public function refresh()
    //    {
    //        if(is_null($token))
    //            throw new NotFoundException('token not found');
    //        if(!is_null($token->getRefreshAt()))
    //            throw new LogicException('token already refresh');
    //        if($token->getIp() != $refreshTokenCommand->ip)
    //            throw new LogicException('token ip not valid');
    //        if($token->getCreatedAt() <= time() - 60 * 60 * )
    //            throw new LogicException('token time is up');
    //    }
}
