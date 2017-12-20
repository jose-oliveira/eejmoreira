<?php

namespace Drupal\webform_waterfall\Element;

use Drupal\Core\Render\Element\Button;

/**
 * Provides a 'waterfall_submit_button'.
 *
 * @FormElement("waterfall_submit_button")
 */
class WaterfallSubmitButton extends Button {

  /**
   * {@inheritdoc}
   *
   * Changing type to 'button' so no information is submitted to Drupal.
   */
  public static function preRenderButton($element) {
    $element = parent::preRenderButton($element);

    $element['#attributes']['type'] = 'button';
    $element['#attributes']['class'][] = 'waterfall_submit_button';

    return $element;
  }

}
