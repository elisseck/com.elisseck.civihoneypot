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
    $this->processHoneypotOptions('build');
    $arr1 = $this->processHoneypotOptions('defaults');
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
  function processHoneypotOptions($mode) {
    if ( $mode == 'build' ) {
	  $this->addEntityRef('form_ids', ts('Contribution Pages'), array(
		'entity' => 'ContributionPage',
		'placeholder' => ts('- Select Contribution Page -'),
		'select' => array('minimumInputLength' => 0),
		'multiple' => TRUE,
		'api' => array('label_field' => 'title'),
	  ));
      $this->add('text', 'field_names', ts('Field Names', array('domain' => 'com.elisseck.civihoneypot')));
      $this->add('advcheckbox', 'protect_all', ts('Protect All Pages', array('domain' => 'com.elisseck.civihoneypot')));
	  $this->add('text', 'limit', ts('Time Limiter', array('domain' => 'com.elisseck.civihoneypot')));
	  $this->add('textarea', 'ipban', ts('Banned IP Addresses', array('domain' => 'com.elisseck.civihoneypot')));
      $this->addRule('field_names', 'Enter Field Names', 'required');
    }
    else if ( $mode == 'defaults' ) {
      $defaults = array(
        'form_ids' => CRM_Core_BAO_Setting::getItem(self::SETTINGS, 'form_ids'),
        'protect_all' => CRM_Core_BAO_Setting::getItem(self::SETTINGS, 'protect_all'),
        'field_names' => CRM_Core_BAO_Setting::getItem(self::SETTINGS, 'field_names'),
		'limit' => CRM_Core_BAO_Setting::getItem(self::SETTINGS, 'limit'),
		'ipban' => CRM_Core_BAO_Setting::getItem(self::SETTINGS, 'ipban'),
      );
      return $defaults;
    }
    else if ( $mode == 'post' ) {
      $values = $this->exportValues();
      CRM_Core_BAO_Setting::setItem($values['form_ids'], self::SETTINGS, 'form_ids');
      CRM_Core_BAO_Setting::setItem($values['protect_all'], self::SETTINGS, 'protect_all');
      CRM_Core_BAO_Setting::setItem($values['field_names'], self::SETTINGS, 'field_names');
	  CRM_Core_BAO_Setting::setItem($values['limit'], self::SETTINGS, 'limit');
	  CRM_Core_BAO_Setting::setItem($values['ipban'], self::SETTINGS, 'ipban');
    }
  }

  function postProcess() {
    parent::postProcess();
	$values = $this->exportvalues();
	if ($values['protect_all'] == "1" || $values['form_ids']) {
      $this->processHoneypotOptions('post');
      $statusMsg = ts('Your settings have been saved.', array('domain' => 'com.elisseck.civihoneypot'));
      CRM_Core_Session::setStatus( $statusMsg, '', 'success' );
	}
	else {
	  $statusMsg = ts('Settings not saved! You must either select at least one form or check the "Protect All" box');
	  CRM_Core_Session::setStatus( $statusMsg, '', 'failure' );
	}
  }
}
