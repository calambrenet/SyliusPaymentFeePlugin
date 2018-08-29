To use:
=======
- Add `\MangoSylius\PaymentFeePlugin\MangoSyliusPaymentFeePlugin()` to AppKernel.php
- Your Entity `PaymentMethod` has to implement `\MangoSylius\PaymentFeePlugin\Model\PaymentMethodWithFeeInterface`. You can use Trait `MangoSylius\PaymentFeePlugin\Model\PaymentMethodWithFeeTrait`. 
- For guide to use your own entity see [Sylius docs - Customizing Models](https://docs.sylius.com/en/1.2/customization/model.html) 

### Admin
- Add 
```twig
<div class="ui segment">
	<h4 class="ui dividing header">{{ 'mango-sylius.ui.payment_charges'|trans }}</h4>
	{{ form_row(form.calculator) }}
	{% for name, calculatorConfigurationPrototype in form.vars.prototypes %}
		<div id="{{ form.calculator.vars.id }}_{{ name }}" data-container=".calculatorConfiguration"
			 data-prototype="{{ form_widget(calculatorConfigurationPrototype)|e }}">
		</div>
	{% endfor %}
	<div class="ui segment calculatorConfiguration">
		{% if form.calculatorConfiguration is defined %}
			{% for field in form.calculatorConfiguration %}
				{{ form_row(field) }}
			{% endfor %}
		{% endif %}
	</div>
</div>
```

to `@SyliusAdmin/PaymentMethod/_form.html.twig` template.

To do this, copy `vendor/sylius/sylius/src/Sylius/Bundle/AdminBundle/Resources/views/PaymentMethod/_form.html.twig` 
to `app/Resources/SyliusAdminBundle/views/PaymentMethod/_form.html.twig` and append that code to the end.


Add this to `AdminBundle/Resources/views/Order/Show/Summary/_totals.html.twig`.
(Copy it to `app/Resources/SyliusAdminBundle/views/Order/Show/Summary/_totals.html.twig`)

```twig

{% set paymentFeeAdjustment = constant('MangoSylius\\PaymentFeePlugin\\Model\\AdjustmentInterface::PAYMENT_ADJUSTMENT') %}

{% set paymentFeeAdjustments = order.getAdjustmentsRecursively(paymentFeeAdjustment) %}
{% if paymentFeeAdjustments is not empty %}
	<tr>
		<td colspan="4" id="payment-fee">

			<div class="ui relaxed divided list">
				{% for paymentFeeLabel, paymentFeeAmount in sylius_aggregate_adjustments(paymentFeeAdjustments) %}
					<div class="item">
						<div class="content">
							<span class="header">{{ paymentFeeLabel }}</span>
							<div class="description">
								{{ money.format(paymentFeeAmount, order.currencyCode) }}
							</div>
						</div>
					</div>
				{% endfor %}
			</div>

		</td>
		<td colspan="4" id="paymentFee-total" class="right aligned">
			<strong>{{ 'mango-sylius.ui.paymentFee_total'|trans }}</strong>:
			{{ money.format(order.getAdjustmentsTotal(paymentFeeAdjustment) ,order.currencyCode) }}
		</td>
	</tr>
{% endif %}
```

### Development

#### Usage (docker-only)

- Create symlink from .env.dist to .env or create your own .env file
- Use php and composer from bin-docker (You can use [direnv](https://direnv.net) to add it into path)
- Run `bin-docker/composer install`, (or just composer, if you are using direnv)
- Develop you plugin in `/src`
- See [.gitlab-ci.yml](.gitlab-ci.yml) and [docker-compose.yaml](docker-compose.yaml) for more info about testing
- See `bin/` for useful commands

