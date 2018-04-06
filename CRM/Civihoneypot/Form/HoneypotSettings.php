<?php
use CRM_Civihoneypot_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC43/QuickForm+Reference
 */
class CRM_Civihoneypot_Form_HoneypotSettings extends CRM_Core_Form {

  protected $_honeypotSettings;

  /**
   * Set variables up before form is built.
   */
  public function preProcess() {
    if (!CRM_Core_Permission::check('administer CiviCRM')) {
      CRM_Core_Error::fatal(ts('You do not permission to access this page, please contact your system administrator.'));
    }
    $this->_honeypotSettings = Civi::settings()->get('honeypot_settings');
  }

  /**
   * Set default values.
   *
   * @return array
   */
  public function setDefaultValues() {
    return $this->_honeypotSettings;
  }

  function buildQuickForm() {
    $this->addEntityRef('honeypot_form_ids',
      ts('Contribution Page(s)'),
      array(
        'entity' => 'ContributionPage',
        'placeholder' => E::ts('- Select Contribution Page -'),
        'select' => array('minimumInputLength' => 0),
        'multiple' => TRUE,
        'api' => array('label_field' => 'title'),
      )
    );
    $this->add('text', 'honeypot_field_names', E::ts('Field Names'), TRUE);
    $this->add('advcheckbox', 'honeypot_protect_all', E::ts('Protect All Pages'));
    $this->add('text', 'honeypot_limit', E::ts('Time Limiter (in secs)'));
    $this->add('textarea', 'honeypot_ipban', E::ts('Banned IP Address(es)'));
    $this->addFormRule(array('CRM_Civihoneypot_Form_HoneypotSettings', 'formRule'), $this);

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
      array(
        'type' => 'cancel',
        'name' => E::ts('Cancel'),
      ),
    ));
    parent::buildQuickForm();
  }

  /**
   * Global form rule.
   *
   * @param array $fields
   *   The input form values.
   * @param array $files
   *   The uploaded files if any.
   * @param $self
   *
   * @return bool|array
   *   true if no errors, else array of errors
   */
  public static function formRule($fields, $files, $self) {
    $errors = array();
    if ($fields['honeypot_protect_all'] != "1" && empty($fields['honeypot_form_ids'])) {
      $errors['_qf_default'] = ts('You must either select at least one form or check the "Protect All" box');
    }

    return $errors;

  }


  function postProcess() {
    parent::postProcess();
    $values = $this->exportvalues();

    // cleanup submitted values
    unset($values['qfKey']);
    unset($values['entryURL']);
    unset($values['_qf_default']);
    unset($values['_qf_HoneypotSettings_submit']);

    // Store new settings in every domain, not just this one (for global effect)
    foreach ($values as $setting => $value) {
      civicrm_api3('Setting', 'create', ['domain_id' => 'all', $setting => $value]);
    }
    // Flush caches to ensure settings are applied immediately
    civicrm_api3('System', 'flush');
    CRM_Core_Session::setStatus(ts("Honeypot settings saved"), ts('Success'), 'success');
  }

}
