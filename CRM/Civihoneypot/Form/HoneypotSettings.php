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
      [
        'entity' => 'ContributionPage',
        'placeholder' => ts('- Select Contribution Page -'),
        'select' => ['minimumInputLength' => 0],
        'multiple' => TRUE,
        'api' => ['label_field' => 'title'],
      ],
    );
    $this->add('text', 'field_names', ts('Field Names', ['domain' => 'com.elisseck.civihoneypot']), TRUE);
    $this->add('advcheckbox', 'protect_all', ts('Protect All Contribution Pages', ['domain' => 'com.elisseck.civihoneypot']));
    $this->addEntityRef('event_ids',
      ts('Event Registration Form(s)'),
      [
        'entity' => 'Event',
        'placeholder' => ts('- Select Event -'),
        'select' => ['minimumInputLength' => 0],
        'multiple' => TRUE,
        'api' => ['label_field' => 'title'],
      ],
    );
    $this->add('advcheckbox', 'protect_all_events', ts('Protect All Events', ['domain' => 'com.elisseck.civihoneypot']));
    $this->add('text', 'limit', ts('Time Limiter (in secs)', ['domain' => 'com.elisseck.civihoneypot']));
    $this->add('textarea', 'ipban', ts('Banned IP Address(es)', ['domain' => 'com.elisseck.civihoneypot']));
    $this->addFormRule(['CRM_Civihoneypot_Form_HoneypotSettings', 'formRule'], $this);

    $this->addButtons([
      [
        'type' => 'submit',
        'name' => ts('Submit', ['domain' => 'com.elisseck.civihoneypot']),
        'isDefault' => TRUE,
      ],
      [
        'type' => 'cancel',
        'name' => ts('Cancel', ['domain' => 'com.elisseck.civihoneypot']),
      ],
    ]);
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
    $errors = [];
    if (!($fields['protect_all'] || $fields['form_ids'] || $fields['protect_all_events'] || $fields['event_ids'])) {
      $errors['_qf_default'] = ts('You must either select at least one form or check one of the "Protect All" boxes.');
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

    Civi::settings()->set('honeypot_settings', $values);
    CRM_Core_Session::setStatus(ts("Honeypot settings saved"), ts('Success'), 'success');
  }
}
