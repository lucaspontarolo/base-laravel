<?php

namespace App\Helpers;

use Psr\Log\InvalidArgumentException;

class MoneyHelper
{
    public static function money($value, $moneyFormat)
    {
        if (self::isMaskedNumber($value)) {
            $value = self::removeMaskMoney($value);
        }
        $value = floatval($value);

        switch ($moneyFormat) {
            case 'BRL':
                $formatted = number_format($value, 2, ',', '.');
                return "R$ {$formatted}";

            default:
                throw new InvalidArgumentException(
                    sprintf('Invalid moneyFormat"%s"', $moneyFormat)
                );
        }
    }

    public static function moneyPrefix($value, $prefix = 'R$')
    {
        return "{$prefix} {$value}";
    }

    public static function removeMaskMoney($value, $fromMoneyFormat = 'BRL')
    {
        switch ($fromMoneyFormat) {
            case 'BRL':
                $value = preg_replace('/[^0-9,]/', '', $value);
                return str_replace([','], ['.'], $value);

            default:
                throw new InvalidArgumentException(
                    sprintf('Invalid $fromMoneyFormat"%s"', $fromMoneyFormat)
                );
        }
    }

    private static function isMaskedNumber($value)
    {
        return gettype($value === 'string') && preg_match('/\d+,\d{1,2}$/', $value) > 0;
    }
}
