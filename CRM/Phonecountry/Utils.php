<?php

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

require_once 'packages/libphonenumber/PhoneNumberUtil.php';

class CRM_Phonecountry_Utils {


  /**
   * function to get region using phone number.
   * 
   * @param $number
   * @return string|null
   */
  public static function getPhoneCountryCode($number) {
    $region = '';
    $country = 'US';
    if (empty($number)) {
      return $region;
    }
    $phoneUtil = PhoneNumberUtil::getInstance();
    try {
      $phoneProto = $phoneUtil->parse($number, $country);
    }
    catch (NumberParseException $e) {
      return $region;
    }
    if (!$phoneUtil->isValidNumber($phoneProto)) {
      return $region;
    }
    try {
      $region = $phoneUtil->getRegionCodeForNumber($phoneProto);
    }
    catch (NumberParseException $e) {
      return $region;
    }
    return $region;
  }
}
