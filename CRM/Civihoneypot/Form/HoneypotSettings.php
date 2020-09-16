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
    //this can't be right but I don't understand the fragmented documentation at all
    $settings = ['honeypot_form_ids', 'honeypot_protect_all', 'honeypot_field_names', 'honeypot_limit', 'honeypot_ipban', 'honeypot_event_ids', 'honeypot_protect_all_events'];
    foreach ($settings as $setting) {
      $this->_honeypotSettings[$setting] = Civi::settings()->get($setting);
    }

  }

  /**
   * Set default values.
   *
   * @return array
   */
  public function setDefaultValues() {
    return $this->_honeypotSettings;
  }

  public function buildQuickForm() {
    $this->addEntityRef('honeypot_form_ids',
      ts('Contribution Page(s)'),
      [
        'entity' => 'ContributionPage',
        'placeholder' => E::ts('- Select Contribution Page -'),
        'select' => ['minimumInputLength' => 0],
        'multiple' => TRUE,
        'api' => ['label_field' => 'title'],
      ],
    );
    $this->add('text', 'honeypot_field_names', E::ts('Field Names'), TRUE);
    $this->add('advcheckbox', 'honeypot_protect_all', E::ts('Protect All Contribution Pages'));
    $this->addEntityRef('honeypot_event_ids',
      E::ts('Event Registration Form(s)'),
      [
        'entity' => 'Event',
        'placeholder' => ts('- Select Event -'),
        'select' => ['minimumInputLength' => 0],
        'multiple' => TRUE,
        'api' => ['label_field' => 'title'],
      ],
    );
    $this->add('advcheckbox', 'honeypot_protect_all_events', E::ts('Protect All Events'));
    $this->add('text', 'honeypot_limit', E::ts('Time Limiter (in secs)'));
    $this->add('textarea', 'honeypot_ipban', E::ts('Banned IP Address(es)'));
    $this->addFormRule(['CRM_Civihoneypot_Form_HoneypotSettings', 'formRule'], $this);

    $this->addButtons([
      [
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ],
      [
        'type' => 'cancel',
        'name' => E::ts('Cancel'),
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
    if (!($fields['honeypot_protect_all'] || $fields['honeypot_form_ids'] || $fields['honeypot_protect_all_events'] || $fields['honeypot_event_ids'])) {
      $errors['_qf_default'] = ts('You must either select at least one form or check one of the "Protect All" boxes.');
    }

    return $errors;

  }

  public function postProcess() {
    parent::postProcess();
    $values = $this->exportValues();

    // cleanup submitted values
    unset($values['qfKey']);
    unset($values['entryURL']);
    unset($values['_qf_default']);
    unset($values['_qf_HoneypotSettings_submit']);

    // Store new settings in every domain, not just this one (for global effect)
    foreach ($values as $setting => $value) {
      Civi::settings()->set($setting, $value);
    }

    // Flush caches to ensure settings are applied immediately
    //civicrm_api3('System', 'flush');
    CRM_Core_Session::setStatus(ts("Honeypot settings saved"), ts('Success'), 'success');
  }

}
