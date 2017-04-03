<?php
require_once 'CRM/Core/Form.php';
/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Civihoneypot_Form_HoneypotSettings extends CRM_Core_Form {
  CONST SETTINGS = 'honeypot';
  function buildQuickForm() {
    CRM_Utils_System::setTitle(ts('Configure Honeypot', array('domain' => 'com.elisseck.civihoneypot')));
    $this->processOrgOptions('build');
    $arr1 = $this->processOrgOptions('defaults');
    $defaults = $arr1;
    $this->setDefaults($defaults);
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit', array('domain' => 'com.elisseck.civihoneypot')),
        'isDefault' => TRUE,
      ),
    ));
    parent::buildQuickForm();
  }
  function processOrgOptions($mode) {
    if ( $mode == 'build' ) {
      $this->add('text', 'form_ids', ts('Form IDs', array('domain' => 'com.elisseck.civihoneypot')));
      $this->add('text', 'field_names', ts('Field Names', array('domain' => 'com.elisseck.civihoneypot')));
      $this->addRule('form_ids', 'Enter Form IDs', 'required');
      $this->addRule('field_names', 'Enter Field Names', 'required');
    }
    else if ( $mode == 'defaults' ) {
      $defaults = array(
        'form_ids' => CRM_Core_BAO_Setting::getItem(self::SETTINGS, 'form_ids'),
        'field_names' => CRM_Core_BAO_Setting::getItem(self::SETTINGS, 'field_names'),
      );
      return $defaults;
    }
    else if ( $mode == 'post' ) {
      $values = $this->exportValues();
      CRM_Core_BAO_Setting::setItem($values['form_ids'], self::SETTINGS, 'form_ids');
      CRM_Core_BAO_Setting::setItem($values['field_names'], self::SETTINGS, 'field_names');
    }
  }

  function postProcess() {
    parent::postProcess();
    $this->processOrgOptions('post');
    $statusMsg = ts('Your settings have been saved.', array('domain' => 'com.elisseck.civihoneypot'));
    CRM_Core_Session::setStatus( $statusMsg, '', 'success' );
  }
}