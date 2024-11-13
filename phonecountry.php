<?php

require_once 'phonecountry.civix.php';

use CRM_Phonecountry_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function phonecountry_civicrm_config(&$config): void {
  _phonecountry_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function phonecountry_civicrm_install(): void {
  _phonecountry_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function phonecountry_civicrm_enable(): void {
  _phonecountry_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_pre
 */
function phonecountry_civicrm_post( $op, $objectName, $objectId, &$objectRef ) {
  if ($objectName == 'Phone') {
    $currentCode = CRM_Core_DAO::getFieldValue('CRM_Core_DAO_Phone', $objectId, 'country_code');
    $newCode = CRM_Phonecountry_Utils::getPhoneCountryCode($objectRef->phone);
    if ($newCode != $currentCode) {
      CRM_Core_DAO::setFieldValue('CRM_Core_DAO_Phone', $objectId, 'country_code', $newCode);
    }
  }
}

/**
 * Implements hook_civicrm_qType().
 */
function phonecountry_civicrm_entityTypes(&$entityTypes) {

  $civiVersion = CRM_Utils_System::version();
  $phone = 'CRM_Core_DAO_Phone';
  if (version_compare($civiVersion, '5.75.0') >= 0) {
    $phone = 'Phone';
  }
  $entityTypes[$phone]['fields_callback'][]
    = function ($class, &$fields) {
    $fields['country_code'] = [
      'name' => 'country_code',
      'title' => ts('Country code'),
      'type' => CRM_Utils_Type::T_STRING,
      'sql_type' => 'varchar(255)',
      'input_type' => 'Text',
      'description' => ts('Country Code.'),
      'add' => '5.75',
        'html' => [
        'type' => 'Text',
      ],
      'input_attrs' => [
        'label' => ts('Country Code.'),
      ],
      'where' => 'civicrm_phone.country_code',
      'table_name' => 'civicrm_phone',
      'entity' => 'Phone',
      'bao' =>  'CRM_Core_BAO_Phone',
    ];
  };
}
