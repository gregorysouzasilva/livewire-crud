<?php

/**
 * Format an amount to the given currency
 *
 * @return response()
 */

if (! function_exists('money_format')) {
    function formatCurrency($amount, $currency)
    {
        $fmt = new NumberFormatter( app()->getLocale(), NumberFormatter::CURRENCY );
        return $fmt->formatCurrency($amount, $currency);
    }
}