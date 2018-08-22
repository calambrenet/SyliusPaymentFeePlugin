To use:
=======
- Add `$bundles[] = new \MangoSylius\PaymentFeePlugin\MangoSyliusPaymentFeePlugin();` to AppKernel.php
- In AppBundle create `PaymentMethod` class that implements `\MangoSylius\PaymentFeePlugin\Model\PaymentMethodWithFeeInterface`
and use Trait `MangoSylius\PaymentFeePlugin\Model\PaymentMethodWithFeeTrait`.
- Do database migration dou to new fields. 

### Admin
- Add 
```twig
<div class="ui segment">
	<h4 class="ui dividing header">{{ 'sylius.ui.payment_charges'|trans }}</h4>
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
			<strong>{{ 'mango.ui.paymentFee_total'|trans }}</strong>:
			{{ money.format(order.getAdjustmentsTotal(paymentFeeAdjustment) ,order.currencyCode) }}
		</td>
	</tr>
{% endif %}
```
