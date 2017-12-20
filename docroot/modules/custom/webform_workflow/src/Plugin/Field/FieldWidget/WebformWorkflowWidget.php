<?php

namespace Drupal\webform_workflow\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'webform_workflow_widget' widget.
 *
 * @FieldWidget(
 *   id = "webform_workflow_widget",
 *   label = @Translation("Webform Workflow"),
 *   field_types = {
 *     "webform_workflow_widget"
 *   }
 * )
 */
class WebformWorkflowWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'maxlength' => 32,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['webform_id'] = $element + [
      '#type' => 'textfield',
      '#default_value' => isset($items[$delta]->webform_id) ? $items[$delta]->webform_id : NULL,
      '#maxlength' => $this->getSetting('maxlength'),
      '#attributes' => ['class' => ['webform-workflow-webform-id']],
    ];

    $element['value'] = [
      '#type' => 'hidden',
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : NULL,
      '#attributes' => ['class' => ['webform-workflow-webform-code']],
    ];
    return $element;
  }

}
