<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\TaxCalculator;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as MoneyPhp;

final class Money
{
    private $money;

    public function __construct(
        $amount,
        private readonly string $currency,
        private string $language,
    ) {
        $this->money = new MoneyPhp($amount, new Currency($currency));
    }

    public function __call(string $method, array $arguments)
    {
        return \call_user_func_array([$this->money, $method], $arguments);
    }

    public function decimal(): float
    {
        return (float) (new DecimalMoneyFormatter(new ISOCurrencies()))->format($this->money);
    }

    public function format(): string
    {
        $numberFormatter = new \NumberFormatter($this->language, \NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        return $moneyFormatter->format($this->money);
    }
}
