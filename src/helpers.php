<?php

/**
 * Format an amount to the given currency
 *
 * @return response()
 */

if (! function_exists('money_format')) {
    function money_format($amount)
    {
        $fmt = new NumberFormatter( app()->getLocale(), NumberFormatter::CURRENCY );
        $fmt->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
        return $fmt->formatCurrency($amount, '');
    }
}