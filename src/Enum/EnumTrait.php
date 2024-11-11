<?php
declare(strict_types=1);
namespace App\Enum;

trait EnumTrait
{
    /**
     * @return array
     */
    public static function getValues(): array
    {
        $cases = static::cases();
        return array_map(fn($case) => $case->value, $cases);
    }
}
