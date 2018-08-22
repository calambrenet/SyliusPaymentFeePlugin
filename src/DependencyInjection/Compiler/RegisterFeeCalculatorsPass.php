<?php

declare(strict_types=1);

namespace MangoSylius\PaymentFeePlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterFeeCalculatorsPass implements CompilerPassInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function process(ContainerBuilder $container): void
	{
		if (!$container->hasDefinition('mango-sylius.registry.payment_calculator') || !$container->hasDefinition('mango-sylius.form_registry.payment_calculator')) {
			return;
		}

		$registry = $container->getDefinition('mango-sylius.registry.payment_calculator');
		$formTypeRegistry = $container->getDefinition('mango-sylius.form_registry.payment_calculator');
		$calculators = [];

		foreach ($container->findTaggedServiceIds('mango-sylius.payment_fee_calculator') as $id => $attributes) {
			if (!isset($attributes[0]['calculator'], $attributes[0]['label'])) {
				throw new \InvalidArgumentException('Tagged payment fee calculators needs to have `calculator` and `label` attributes.');
			}

			$name = $attributes[0]['calculator'];
			$calculators[$name] = $attributes[0]['label'];

			$registry->addMethodCall('register', [$name, new Reference($id)]);

			if (isset($attributes[0]['form_type'])) {
				$formTypeRegistry->addMethodCall('add', [$name, 'default', $attributes[0]['form_type']]);
			}
		}

		$container->setParameter('mango-sylius.payment_fee_calculators', $calculators);
	}
}
