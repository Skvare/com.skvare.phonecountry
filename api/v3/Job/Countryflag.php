<?php
use CRM_Phonecountry_ExtensionUtil as E;

/**
 * Job.Countryflag API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/api-architecture/
 */
function _civicrm_api3_job_Countryflag_spec(&$spec) {
}

/**
 * Job.Countryflag API
 *
 * @param array $params
 *
 * @return array
 *   API result descriptor
 *
 * @see civicrm_api3_create_success
 *
 * @throws CRM_Core_Exception
 */
function civicrm_api3_job_Countryflag($params) {
  $phones = \Civi\Api4\Phone::get(TRUE)
    ->addWhere('country_code', 'IS EMPTY')
    ->addWhere('phone', 'IS NOT EMPTY')
    ->setLimit(1000)
    ->execute();
  $count = 0;
  foreach ($phones as $phone) {
    // do something
    $newCode = CRM_Phonecountry_Utils::getPhoneCountryCode($phone['phone']);
    CRM_Core_DAO::setFieldValue('CRM_Core_DAO_Phone', $phone['id'], 'country_code', $newCode);
    $count++;
  }
  $returnValues = "Updated country falg for {$count} phone records";
  return civicrm_api3_create_success($returnValues, $params, 'Job', 'Countryflag');
}
