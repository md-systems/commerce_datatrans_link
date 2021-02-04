<?php

namespace Drupal\commerce_datatrans_link\Plugin\Commerce\PaymentGateway;

use Drupal\commerce_datatrans\Plugin\Commerce\PaymentGateway\DatatransBase;
use Drupal\commerce_payment\Entity\PaymentInterface;
use Drupal\Core\Url;

/**
 * Provides the Datatrans payment gateway.
 *
 * @CommercePaymentGateway(
 *   id = "datatrans_link",
 *   label = "Datatrans Link",
 *   display_label = "Datatrans Link",
 *   forms = {
 *     "add-payment" = "Drupal\commerce_payment\PluginForm\ManualPaymentAddForm",
 *   },
 *   payment_type = "commerce_datatrans_link",
 *   requires_billing_information = FALSE,
 * )
 */
class DatatransLink extends DatatransBase {

  /**
   * {@inheritdoc}
   */
  public function createPayment(PaymentInterface $payment, $received = FALSE) {
    $this->assertPaymentState($payment, ['new']);

    if (!$received) {
      $response = $this->initializePayment($payment, [
        'redirect' => [
          // @todo: Make this configurable?
          'successUrl' => Url::fromRoute('<front>')->setAbsolute()->toString(),
          'cancelUrl' => Url::fromRoute('<front>')->setAbsolute()->toString(),
          'errorUrl' => Url::fromRoute('<front>')->setAbsolute()->toString(),
        ]
      ]);
      $payment->set('datatrans_link', $response->getLocation());
      $payment->setRemoteId($response->getTransactionId());
      $this->messenger()->addStatus($this->t('Payment link to pay for this payment: @payment_url', ['@payment_url' => $response->getLocation()]));
    }

    $payment->state = $received ? 'completed' : 'pending';
    $payment->save();
  }

}
