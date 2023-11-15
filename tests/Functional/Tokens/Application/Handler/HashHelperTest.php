<?php

namespace App\Tests\Functional\Tokens\Application\Handler;

use App\Core\Exception\NotAccessException;
use App\Core\Exception\NotFoundException;
use App\Tokens\Application\Helper\HashHelper;
use PHPUnit\Framework\TestCase;

class HashHelperTest extends TestCase
{
    public function testAuthBotUserNotFound(): void
    {
        $request = 'query_id=AAGeW2guAAAAAJ5baC7XbeZg=&user=%7B%22id%22%3A778591134%2C%22first_name%22%3A%22%D0%90%D0%BB%D0%B5%D0%BA%D1%81%D0%B0%D0%BD%D0%B4%D1%80%22%2C%22last_name%22%3A%22%D0%9F%D1%83%D1%80%D1%82%D0%BE%D0%B2%22%2C%22username%22%3A%22APURTIK%22%2C%22language_code%22%3A%22ru%22%2C%22allows_write_to_pm%22%3Atrue%7D&auth_date=1696243471';
        parse_str($request, $data);

        try {
            HashHelper::checkHash($data, 'token');
            self::assertEquals(1, '2');
        } catch (NotFoundException $e) {
            self::assertEquals($e->getMessage(), 'hash not found');
        }
    }

    public function testAuthBotUserNotAccess(): void
    {
        $request = 'query_id=AAGeW2guAAAAAJ5baC7XbeZg=&user=%7B%22id%22%3A778591134%2C%22first_name%22%3A%22%D0%90%D0%BB%D0%B5%D0%BA%D1%81%D0%B0%D0%BD%D0%B4%D1%80%22%2C%22last_name%22%3A%22%D0%9F%D1%83%D1%80%D1%82%D0%BE%D0%B2%22%2C%22username%22%3A%22APURTIK%22%2C%22language_code%22%3A%22ru%22%2C%22allows_write_to_pm%22%3Atrue%7D&auth_date=1696243471&hash=asdsafasfqw123';
        parse_str($request, $data);

        try {
            HashHelper::checkHash($data, 'token');
            self::assertEquals(1, '2');
        } catch (NotAccessException $e) {
            self::assertEquals($e->getMessage(), 'hash not valid');
        }
    }

    public function testAuthBotUserSuccess(): void
    {
        $request = 'query_id=AAGeW2guAAAAAJ5baC4Clsfo&user=%7B%22id%22%3A778591134%2C%22first_name%22%3A%22%D0%90%D0%BB%D0%B5%D0%BA%D1%81%D0%B0%D0%BD%D0%B4%D1%80%22%2C%22last_name%22%3A%22%D0%9F%D1%83%D1%80%D1%82%D0%BE%D0%B2%22%2C%22username%22%3A%22APURTIK%22%2C%22language_code%22%3A%22ru%22%2C%22allows_write_to_pm%22%3Atrue%7D&auth_date=1696503642&hash=6eb6296ea8245136d4fb03c3751fdb46c1ebf290b2da54a7b3514b8ec9edccf5';
        parse_str($request, $data);

        $id = HashHelper::checkHash($data, '1172473489:AAFoRo3JvyXS5c1l5aW5qvOtDzZEQVJvf0w');

        self::assertEquals($id, '778591134');
    }

    public function testAuthBotUserSuccessGet(): void
    {
        $request = 'bot_id=12845&public_key=86f83f18be0d5fab812553f30b6b744d&id=778591134&first_name=%D0%90%D0%BB%D0%B5%D0%BA%D1%81%D0%B0%D0%BD%D0%B4%D1%80&auth_date=1698145564&hash=971a9de26591c479a7f1c5b3124cc07cd9ce718be521f9666a4146cdff50b3d6';
        parse_str($request, $data);

        $id = HashHelper::checkHash($data, '2109328710:AAGFynAUSvPhYwDCXkmp14HUsmC8h1ap3FI');

        self::assertEquals($id, '778591134');
    }
}
