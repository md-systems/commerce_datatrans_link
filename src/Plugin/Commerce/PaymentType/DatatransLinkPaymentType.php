<?php

namespace Drupal\commerce_datatrans_link\Plugin\Commerce\PaymentType;

use Drupal\commerce_payment\Plugin\Commerce\PaymentType\PaymentTypeBase;
use Drupal\entity\BundleFieldDefinition;
use Drupal\link\LinkItemInterface;
use const DRUPAL_DISABLED;

/**
 * Provides the datatrans link payment type.
 *
 * @CommercePaymentType(
 *   id = "commerce_datatrans_link",
 *   label = @Translation("Datatrans link"),
 *   workflow = "payment_manual",
 * )
 */
class DatatransLinkPaymentType extends PaymentTypeBase {

  /**
   * {@inheritdoc}
   */
  public function buildFieldDefinitions() {
    $fields = [];

    $fields['datatrans_link'] = BundleFieldDefinition::create('link')
      ->setLabel(t('Payment Link'))
      ->setSettings([
        'link_type' => LinkItemInterface::LINK_EXTERNAL,
        'title' => DRUPAL_DISABLED,
      ])
      ->setDisplayOptions('view', [
        'type' => 'link',
        'weight' => 2,
      ]);

    return $fields;
  }

}
