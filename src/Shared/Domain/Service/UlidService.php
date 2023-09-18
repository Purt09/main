<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service;


use Ulid\Ulid;

/**
 * Universally Unique Lexicographically Sortable Identifier.
 *
 * @see https://github.com/ulid/spec
 */
class UlidService
{
    public static function generate(): string
    {
        return (string) Ulid::generate(true);
    }
}