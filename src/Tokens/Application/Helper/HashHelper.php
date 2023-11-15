<?php

namespace App\Tokens\Application\Helper;

use App\Core\Exception\NotAccessException;
use App\Core\Exception\NotFoundException;

class HashHelper
{
    /**
     * Генерирует хеш для проверки данных.
     */
    public static function generateHash(array $auth_data, string $token): string
    {
        $data_check_arr = [];
        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = $key.'='.$value;
        }
        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);
        $secret_key = hash('sha256', $token, true);

        return hash_hmac('sha256', $data_check_string, $secret_key);
    }

    /**
     * Проверяет хеш для.
     *
     * @return int - id пользователя
     */
    public static function checkHash(array $auth_data, string $token): int
    {
        if (array_key_exists('query_id', $auth_data)) {
            $data_check_arr = [];
            foreach ($auth_data as $key => $auth_datum) {
                array_push($data_check_arr, $key.'='.$auth_datum);
            }
            $needle = 'hash=';
            $check_hash = false;
            foreach ($data_check_arr as &$val) {
                if (substr($val, 0, strlen($needle)) === $needle) {
                    $check_hash = substr_replace($val, '', 0, strlen($needle));
                    $val = null;
                }
            }

            if (false === $check_hash) {
                throw new NotFoundException('hash not found');
            }

            $data_check_arr = array_filter($data_check_arr);
            sort($data_check_arr);

            $data_check_string = implode("\n", $data_check_arr);
            $secret_key = hash_hmac('sha256', $token, 'WebAppData', true);
            $hash = bin2hex(hash_hmac('sha256', $data_check_string, $secret_key, true));
            if (0 === strcmp($hash, $check_hash)) {
                $user = json_decode($auth_data['user']);

                return intval($user->id);
            } else {
                throw new NotAccessException('hash not valid');
            }
        } else {
            $data = $auth_data;
            $check_hash = $data['hash'];

            unset($data['hash']);
            if (array_key_exists('bot_id', $data)) {
                unset($data['bot_id']);
            }
            if (array_key_exists('public_key', $data)) {
                unset($data['public_key']);
            }
            $hash = HashHelper::generateHash($data, $token);
            if (0 !== strcmp($hash, $check_hash)) {
                throw new NotAccessException('hash not valid');
            }
            if ((time() - $auth_data['auth_date']) > 3600) {
                throw new NotAccessException('time over, send "/start" in bot');
            }

            return intval($auth_data['id']);
        }
    }
}
