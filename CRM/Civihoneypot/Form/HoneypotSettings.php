<?php
require_once 'CRM/Core/Form.php';
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
    $this->addEntityRef('form_ids',
      ts('Contribution Page(s)'),
      array(
        'entity' => 'ContributionPage',
        'placeholder' => ts('- Select Contribution Page -'),
        'select' => array('minimumInputLength' => 0),
        'multiple' => TRUE,
        'api' => array('label_field' => 'title'),
      )
    );
    $this->add('text', 'field_names', ts('Field Names', array('domain' => 'com.elisseck.civihoneypot')), TRUE);
    $this->add('advcheckbox', 'protect_all', ts('Protect All Pages', array('domain' => 'com.elisseck.civihoneypot')));
    $this->add('text', 'limit', ts('Time Limiter (in secs)', array('domain' => 'com.elisseck.civihoneypot')));
    $this->add('textarea', 'ipban', ts('Banned IP Address(es)', array('domain' => 'com.elisseck.civihoneypot')));
    $this->addFormRule(array('CRM_Civihoneypot_Form_HoneypotSettings', 'formRule'), $this);

    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => ts('Submit', array('domain' => 'com.elisseck.civihoneypot')),
        'isDefault' => TRUE,
      ),
      array(
        'type' => 'cancel',
        'name' => ts('Cancel', array('domain' => 'com.elisseck.civihoneypot')),
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
    if ($fields['protect_all'] != "1" && empty($fields['form_ids'])) {
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
    $domains = civicrm_api3('Domain', 'get');
    foreach(array_keys($domains['values']) as $domain) {
     Civi::settings($domain)->set('honeypot_settings', $values);
    }
    CRM_Core_Session::setStatus(ts("Honeypot settings saved"), ts('Success'), 'success');
  }
}
