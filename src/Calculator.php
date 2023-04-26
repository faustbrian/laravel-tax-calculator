<?php

declare(strict_types=1);

namespace BombenProdukt\TaxCalculator;

final class Calculator
{
    private float $amount;

    private string $currency;

    private string $locale;

    private float $taxRate;

    private float $discount = 0;

    public function __construct(string $currency, string $locale, float $taxRate)
    {
        $this->setCurrency($currency);
        $this->setLocale($locale);
        $this->setTaxRate($taxRate);
    }

    public function setAmount(int $value): self
    {
        $this->amount = $value;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setTaxRate(float $value): self
    {
        $this->taxRate = $value;

        return $this;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    public function setCurrency(string $value): self
    {
        $this->currency = $value;

        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setLocale(string $value): self
    {
        $this->locale = $value;

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setDiscount(float $value): self
    {
        $this->discount = $value / 100;

        return $this;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }

    public function subtotal(): Money
    {
        return $this->toMoney($this->amount);
    }

    public function discount(): Money
    {
        $amount = $this->subtotal()->getAmount() * $this->discount;

        return $this->toMoney($amount);
    }

    public function taxRate(): float
    {
        return $this->taxRate;
    }

    public function taxValue(): Money
    {
        $amount = ($this->subtotal()->getAmount() - $this->discount()->getAmount()) * $this->taxRate();

        return $this->toMoney($amount);
    }

    public function total(): Money
    {
        $amount = ($this->subtotal()->getAmount() - $this->discount()->getAmount()) + $this->taxvalue()->getAmount();

        return $this->toMoney($amount);
    }

    private function toMoney(float $amount): Money
    {
        return new Money($amount, $this->currency, $this->locale);
    }
}
