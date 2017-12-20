<?php

namespace Drupal\webform_workflow\Plugin\Field\FieldType;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\TypedData\DataDefinitionInterface;
use Drupal\Core\TypedData\TypedDataInterface;

/**
 * Plugin implementation of the 'webform_workflow' field type.
 *
 * @FieldType(
 *   id = "webform_workflow",
 *   label = @Translation("Webform Workflow"),
 *   description = @Translation("References a Webform and saves its source code on a new revision when it's changed."),
 *   category = @Translation("Webform"),
 *   default_widget = "webform_workflow_widget",
 *   default_formatter = "webform_workflow_formatter"
 * )
 */
class WebformWorkflow extends FieldItemBase {

  protected $languageManager;
  protected $config;

  /**
   * {@inheritdoc}
   */
  public function __construct(DataDefinitionInterface $definition, $name, TypedDataInterface $parent) {
    parent::__construct($definition, $name, $parent);
    $this->languageManager = \Drupal::languageManager();
    $this->config = \Drupal::configFactory();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Webform code'))
      ->setRequired(TRUE);

    $properties['webform_id'] = DataDefinition::create('string')
      ->setLabel(t('Webform id'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'text',
          'size' => 'big',
        ],
        'webform_id' => [
          'type' => 'varchar',
          'length' => 32,
          'not null' => TRUE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function preSave() {

    // Loads the Webform with the selected language.
    $langcode = $this->getLangcode();
    $language = $this->languageManager->getLanguage($langcode);;
    $this->languageManager->setConfigOverrideLanguage($language);
    $webform_id = $this->get('webform_id')->getValue();
    $webform = $this->config->get('webform.webform.' . $webform_id)->get();

    // Save a JSON encoded version of the Webform.
    $encoded_webform = Json::encode($webform);
    $this->set('value', $encoded_webform);
  }

}
