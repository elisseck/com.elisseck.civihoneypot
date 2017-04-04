# com.elisseck.civihoneypot
Simple honeypot fields for CiviCRM Contribute forms.
Development supported by Northeast Sustainable Energy Association

Features:
- Classic hidden honeypot field, configurable name and id
- Configure which Contribute forms to protect by form ID (More form types coming in the future)
- Configurable velocity limiter for submissions - set the minimum number of seconds that must pass before you accept a form submission
- IP Banning from protected forms based on manually entered list.

How to Use:
1) Download, install, and enable this CiviCRM extension
2) Grab the IDs of the Contribute forms you would like to protect
3) Navigate to CiviCRM>Administer>Honeypot Settings and set at least one Form ID, and at least one field name.

Next Priority:
Suggestions welcome, open an issue in this repo. I can't promise anything that isn't in line with what this organization needs.