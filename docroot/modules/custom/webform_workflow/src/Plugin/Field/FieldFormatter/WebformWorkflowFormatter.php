<?php

namespace Drupal\webform_workflow\Plugin\Field\FieldFormatter;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\webform\Entity\Webform;

/**
 * Plugin implementation of the 'webform_workflow_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "webform_workflow_formatter",
 *   label = @Translation("Rendered Webform"),
 *   field_types = {
 *     "webform_workflow",
 *   }
 * )
 */
class WebformWorkflowFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $encoded_webform = $item->get('value')->getValue();
      $webform_data = Json::decode($encoded_webform);
      // This is necessary to make sure the Webform's settings stick.
      $webform_data['settingsOriginal'] = $webform_data['settings'];

      $webform = Webform::create($webform_data);

      $elements[$delta] = [
        '#type' => 'webform',
        '#webform' => $webform,
      ];
    }

    return $elements;
  }

}
