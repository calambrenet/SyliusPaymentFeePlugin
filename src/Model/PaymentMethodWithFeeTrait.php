<?php

declare(strict_types=1);

namespace MangoSylius\PaymentFeePlugin\Model;

use Doctrine\ORM\Mapping as ORM;

trait PaymentMethodWithFeeTrait
{
	/**
	 * @var string|null
	 * @ORM\Column(name="calculator", type="text", nullable=true)
	 */
	protected $calculator;

	/**
	 * @var array
	 * @ORM\Column(name="calculator_configuration", type="json", nullable=true)
	 */
	protected $calculatorConfiguration = [];

	public function getCalculator(): ?string
	{
		return $this->calculator;
	}

	public function setCalculator(?string $calculator)
	{
		$this->calculator = $calculator;
	}

	public function getCalculatorConfiguration(): array
	{
		return $this->calculatorConfiguration ?? [];
	}

	public function setCalculatorConfiguration(array $calculatorConfiguration)
	{
		$this->calculatorConfiguration = $calculatorConfiguration;
	}
}
