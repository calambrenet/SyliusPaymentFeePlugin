<?php declare(strict_types = 1);

namespace MangoSylius\PaymentFeePlugin\Model;

use Sylius\Component\Payment\Model\PaymentMethodInterface;


interface PaymentMethodWithFeeInterface extends PaymentMethodInterface
{
	public function getCalculator(): ?string;

	public function getCalculatorConfiguration(): array;
}
