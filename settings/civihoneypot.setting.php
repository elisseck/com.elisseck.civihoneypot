<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.7                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2017                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
 */
/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2017
 * $Id$
 *
 */
/*
 * Settings metadata file
 */
return [
  'honeypot_form_ids' => [
    'group_name' => 'CiviHoneyPot settings',
    'group' => 'honeypot',
    'name' => 'honeypot_form_ids',
    'type' => 'string',
    'default' => NULL,
    'is_domain' => 1,
    'title' => 'Contribution Pages',
    'add' => 1.0,
  ],
  'honeypot_protect_all' => [
    'group_name' => 'CiviHoneyPot settings',
    'group' => 'honeypot',
    'name' => 'honeypot_protect_all',
    'type' => 'Integer',
    'default' => 0,
    'is_domain' => 1,
    'title' => 'Protect All Pages',
    'add' => 1.0,
  ],
  'honeypot_field_names' => [
    'group_name' => 'CiviHoneyPot settings',
    'group' => 'honeypot',
    'name' => 'honeypot_field_names',
    'type' => 'String',
    'default' => NULL,
    'is_domain' => 1,
    'title' => 'Honeypot field names',
    'add' => 1.0,
  ],
  'honeypot_limit' => [
    'group_name' => 'CiviHoneyPot settings',
    'group' => 'honeypot',
    'name' => 'honeypot_limit',
    'type' => 'String',
    'default' => NULL,
    'is_domain' => 1,
    'title' => 'Time Limiter',
    'add' => 1.0,
  ],
  'honeypot_ipban' => [
    'group_name' => 'CiviHoneyPot settings',
    'group' => 'honeypot',
    'name' => 'honeypot_ipban',
    'type' => 'String',
    'default' => NULL,
    'is_domain' => 1,
    'title' => 'Banned IP Addresses',
    'add' => 1.0,
  ],
  'honeypot_event_ids' => [
    'group_name' => 'CiviHoneyPot settings',
    'group' => 'honeypot',
    'name' => 'honeypot_event_ids',
    'type' => 'String',
    'default' => NULL,
    'is_domain' => 1,
    'title' => 'Event IDs',
    'add' => 1.0,
  ],
  'honeypot_protect_all_events' => [
    'group_name' => 'CiviHoneyPot settings',
    'group' => 'honeypot',
    'name' => 'honeypot_protect_all_events',
    'type' => 'Integer',
    'default' => NULL,
    'is_domain' => 1,
    'title' => 'Protect All Events',
    'add' => 1.0,
  ],
];
