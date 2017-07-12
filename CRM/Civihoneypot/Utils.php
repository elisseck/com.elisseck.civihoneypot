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
      'CRM_Profile_Form_Dynamic',
      'CRM_Mailing_Form_Subscribe',
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

  /**
   * Function used to assign html class and id selectors
   *  based on $formName later used in honeypot.tpl
   *
   * @param CRM_Core_Smarty $template
   * @param string $formName
   * @param CRM_Core_Form $form
   *
   */
  public static function assignTemplateVar(&$template, $formName, $form) {
    $insertAfterClass = $noValidateSelectorID = '';
    if ($formName == 'CRM_Contribute_Form_Contribution_Main') {
      $insertAfterClass = '.custom_pre_profile-group';
      $noValidateSelectorID = '#Main';
    }
    elseif ($formName == 'CRM_Event_Form_Registration_Register') {
      $insertAfterClass = '.custom_pre-section';
      $noValidateSelectorID = '#Register';
    }
    elseif ($formName == 'CRM_Mailing_Form_Subscribe') {
      $insertAfterClass = '.form-layout-compressed';
      $noValidateSelectorID = '#Subscribe';
    }

    $template->assign_by_ref('insertAfterClass', $insertAfterClass);
    $template->assign_by_ref('noValidateSelectorID', $noValidateSelectorID);
  }

}
