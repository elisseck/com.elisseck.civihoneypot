<?php

class CRM_Civihoneypot_Utils {

  /**
   * Function used to fetch online Civi form names where
   *  we want to support honeypot validation
   *
   * @return array
   *   array of Civi form names
   */
  public static function getAllCiviFormNames() {
    // TODO : For now we are only supporting honeypot validation on
    //  online contribution page and event registration. Need to
    //  figure out what other online formnames to be included. 
    return array(
      'CRM_Contribute_Form_Contribution_Main',
      'CRM_Event_Form_Registration_Register',
    );
  }

  /**
   * Function used to fetch honeypot settings saved in CiviCRM.
   *  Comma-separated values are returned in array format
   *
   * @return array
   *   array of honeypot setting values
   */
  public static function getHoneypotSettings() {
    $values = Civi::settings()->get('honeypot_settings');

    foreach (array('form_ids', 'field_names', 'ipban') as $field) {
      if (!empty($values[$field])) {
        $values[$field] = explode(',', $values[$field]);
      }
    }

    return $values;
  }

}
