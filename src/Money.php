<?php

declare(strict_types=1);

namespace PreemStudio\TaxCalculator;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as MoneyPhp;
use NumberFormatter;

final class Money
{
    private $money;

    private $currency;

    private $language;

    public function __construct($amount, string $currency, string $language)
    {
        $this->money = new MoneyPhp($amount, new Currency($currency));
        $this->currency = $currency;
        $this->language = $language;
    }

    public function decimal(): float
    {
        return (float) (new DecimalMoneyFormatter(new ISOCurrencies))->format($this->money);
    }

    public function format(): string
    {
        $numberFormatter = new NumberFormatter($this->language, NumberFormatter::CURRENCY);
        $moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies);

        return $moneyFormatter->format($this->money);
    }

    public function __call(string $method, array $arguments)
    {
        return call_user_func_array([$this->money, $method], $arguments);
    }
}
