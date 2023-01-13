<?php

require_once 'civihoneypot.civix.php';
const HONEYPOT_SETTINGS = 'honeypot';
use CRM_Civihoneypot_ExtensionUtil as E;

/**
 * Retrieve honeypot settings individually
 */
function _getHoneypotValues() {
  $values = [];
  //this can't be right but I don't understand the fragmented documentation at all
  $settings = ['honeypot_form_ids', 'honeypot_protect_all', 'honeypot_field_names', 'honeypot_limit', 'honeypot_ipban', 'honeypot_event_ids', 'honeypot_protect_all_events'];
  foreach ($settings as $setting) {
    $values[$setting] = Civi::settings()->get($setting);
  }

  foreach (['honeypot_form_ids', 'honeypot_field_names', 'honeypot_ipban', 'honeypot_event_ids'] as $field) {
    if (!empty($values[$field])) {
      $values[$field] = explode(',', $values[$field]);
    }
  }

  return $values;
}

/**
 * Implements hook_civicrm_buildForm().
 *
 */
function civihoneypot_civicrm_buildForm($formName, &$form) {
  $settings = _getHoneypotValues();
  $protect = FALSE;
  if ($formName == 'CRM_Contribute_Form_Contribution_Main' &&
    ($settings['honeypot_protect_all'] == "1" || (in_array($form->getVar('_id'), CRM_Utils_Array::value('honeypot_form_ids', $settings, []))))
  ) {
    $protect = TRUE;
  }
  if ($formName == 'CRM_Event_Form_Registration_Register' &&
    ($settings['honeypot_protect_all_events'] == "1" || (in_array($form->getVar('_id'), CRM_Utils_Array::value('honeypot_event_ids', $settings, []))))
  ) {
    $protect = TRUE;
  }
  if ($protect) {
    $deny = CRM_Utils_Array::value('honeypot_ipban', $settings, []);
    if ($deny) {
      $remote = $_SERVER['REMOTE_ADDR'];
      $parts = explode(".", $remote);

      if (count($parts)) {
        $wilds = array(
          sprintf('%s.*', $parts[0]),
        );
        if (!empty($parts[1])) {
          $wilds[] = sprintf('%s.%s.*', $parts[0], $parts[1]);
        }
        if (!empty($parts[2])) {
          $wilds[] = sprintf('%s.%s.%s.*', $parts[0], $parts[1], $parts[2]);
        }
        if (in_array($remote, $deny) || (bool) array_intersect($wilds, $deny)) {
          CRM_Core_Error::fatal(ts('Banned IP was denied access to a CiviCRM Contribution Form.'));
        }
      }
    }
    $timestamp = $_SERVER['REQUEST_TIME'];
    $fieldname = CRM_Utils_Array::value('honeypot_field_names', $settings);
    if (!empty($fieldname)) {
      $max = count($fieldname) - 1;
      $randfieldname = $fieldname[rand(0, $max)];

      // Assumes templates are in a templates folder relative to this file
      $templatePath = realpath(dirname(__FILE__)."/templates");
      $template = CRM_Core_Smarty::singleton();
      $template->assign_by_ref('fieldname', $randfieldname);
      $template->assign_by_ref('timestamp', $timestamp);

      // Add the field element in the form
      $form->addElement('text', $randfieldname, $randfieldname);
      $form->addElement('text', 'timestamp', 'timestamp');

      // dynamically insert a template block in the page
      CRM_Core_Region::instance('page-body')->add(array(
        'template' => "civihoneypot.tpl"
      ));
    }
  }
}

/*
 * Implements hook_civicrm_validateForm().
 *
 */
function civihoneypot_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {
  $settings = _getHoneypotValues();
  //check for honeypot field values from randomized fields
  $protect = FALSE;
  if ($formName == 'CRM_Contribute_Form_Contribution_Main' &&
    ($settings['honeypot_protect_all'] == "1" || (in_array($form->getVar('_id'), CRM_Utils_Array::value('honeypot_form_ids', $settings, []))))
  ) {
    $protect = TRUE;
  }
  if ($formName == 'CRM_Event_Form_Registration_Register' &&
    ($settings['honeypot_protect_all_events'] == "1" || (in_array($form->getVar('_id'), CRM_Utils_Array::value('honeypot_event_ids', $settings, []))))
  ) {
    $protect = TRUE;
  }
  if ($protect) {
    if ($limit = CRM_Utils_Array::value('honeypot_limit', $settings)) {
      $delay = ($_SERVER['REQUEST_TIME'] - $fields['timestamp']);
      if ($delay < $limit) {
        $errors['_qf_default'] = ts('User submitted a CiviCRM form too quickly');
      }
    }

    $fieldnames = CRM_Utils_Array::value('honeypot_field_names', $settings, array());
    foreach ($fields as $key => $value) {
      if (in_array($key, $fieldnames) && $value) {
        $errors['_qf_default'] = ts('User filled in hidden field');
      }
    }
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function civihoneypot_civicrm_config(&$config) {
  _civihoneypot_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function civihoneypot_civicrm_install() {
  _civihoneypot_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function civihoneypot_civicrm_postInstall() {
  _civihoneypot_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function civihoneypot_civicrm_uninstall() {
  _civihoneypot_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function civihoneypot_civicrm_enable() {
  _civihoneypot_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function civihoneypot_civicrm_disable() {
  _civihoneypot_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function civihoneypot_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _civihoneypot_civix_civicrm_upgrade($op, $queue);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *

 // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
 */
function civihoneypot_civicrm_navigationMenu(&$menu) {
  _civihoneypot_civix_insert_navigation_menu($menu, 'Administer', [
    'label' => E::ts('Honeypot Settings'),
    'name' => 'Honeypot Settings',
    'url' => 'civicrm/honeypot/settings',
    'permission' => 'administer CiviCRM',
    'operator' => 'OR',
    'separator' => 1,
  ]);
  _civihoneypot_civix_navigationMenu($menu);
}