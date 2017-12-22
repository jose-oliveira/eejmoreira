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
   * Required components by lender.
   *
   * @var array
   */
  protected $requiredComponentsByLender = [
    'demo' => [
      'name' => [
        '#type' => 'textfield',
        '#title' => 'Name',
      ],
    ],
    'others' => [
      'name' => [
        '#type' => 'textfield',
        '#title' => 'Name',
      ],
      'last' => [
        '#type' => 'textfield',
        '#title' => 'Last name',
      ],
      'check' => [
        '#type' => 'checkbox',
        '#title' => 'Check this field',
      ],
    ],
  ];

  /**
   * {@inheritdoc}
   */
  public function getDefaultProperties() {
    return [
      // Lenders settings.
      'lender' => 'demo',
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
    $form['lender_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Lender settings'),
    ];
    $form['lender_settings']['lender'] = [
      '#type' => 'select',
      '#title' => $this->t('Lenders'),
      '#options' => [
        'demo' => $this->t('Demo'),
        'others' => $this->t('Others'),
      ],
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    // @TODO REALLY Refactor that once we have real code.
    $lenderID = $form_state->getValue('lender');
    $lenderRequiredComponents = $this->requiredComponentsByLender[$lenderID];

    /** @var \Drupal\webform\WebformInterface $webform */
    $webform = $form_state->getFormObject()->getWebform();

    foreach ($lenderRequiredComponents as $componentID => $component) {
      if (!$webform->getElement($componentID)) {
        $webform->setElementProperties($componentID, $component);
      }
    }
  }

}
