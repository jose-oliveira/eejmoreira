<?php

namespace Drupal\webform_waterfall\Plugin\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformElementBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Provides a 'Waterfall submit' element.
 *
 * @WebformElement(
 *   id = "waterfall_submit_button",
 *   label = @Translation("Waterfall submit"),
 *   description = @Translation("Provides a form element for waterfall submit."),
 * )
 */
class WaterfallSubmitButton extends WebformElementBase {

  /**
   * {@inheritdoc}
   */
  public function getDefaultProperties() {
    return [
      // Lenders settings.
      'lenders' => 'demo',
    ] + parent::getDefaultProperties();
  }

  /**
   * {@inheritdoc}
   */
  public function prepare(array &$element, WebformSubmissionInterface $webform_submission = NULL) {
    parent::prepare($element, $webform_submission);
    $element['#default_value'] = $element['#title'];
    // $element['#attached']['library'][] = 'webform/webform.element.color';.
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    // Change the title field label to "Label".
    $form['element']['title']['#title'] = t('Label');

    // Adds lenders settings.
    $form['lenders_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Lender settings'),
    ];
    $form['lenders_settings']['lenders'] = [
      '#type' => 'select',
      '#title' => $this->t('Lenders'),
      '#options' => [
        'demo' => $this->t('Demo'),
        'others' => $this->t('Others'),
      ],
      '#required' => TRUE,
      '#multiple' => TRUE,
    ];

    return $form;
  }

}
