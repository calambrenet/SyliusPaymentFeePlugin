<?php declare(strict_types = 1);

namespace MangoSylius\PaymentFeePlugin\Model;

trait PaymentMethodWithFeeTrait
{
	/**
	 * @var string|null
	 */
	protected $calculator;

	/**
	 * @var array
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
		return $this->calculatorConfiguration;
	}


	public function setCalculatorConfiguration(array $calculatorConfiguration)
	{
		$this->calculatorConfiguration = $calculatorConfiguration;
	}
}
