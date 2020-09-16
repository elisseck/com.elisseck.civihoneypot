# com.elisseck.civihoneypot
Simple honeypot fields for CiviCRM Contribute forms and CiviCRM Event Forms
First round development supported by Northeast Sustainable Energy Association. Currently a volunteer time project.

Features:
- Classic hidden honeypot field, configurable name and id
- Configure which Contribute or Event forms to protect by form ID (More form types coming in the future)
- Configurable velocity limiter for submissions - set the minimum number of seconds that must pass before you accept a form submission
- IP Banning from protected forms based on manually entered list (Supports wildcard bans such as 198.168.0.\*, 198.168.\*, 198.* etc. Use with caution!).

When to use:

The intent of this extension is NOT to replace the reCaptcha option for Contribute pages! If you are having trouble with spam / malicious users and reCaptcha is not on, that option should be explored before installing this tool.

Use this extension when you need to deter a particularly persistent malicious person and/or bot testing credit card numbers on a donation page with different CC numbers, IP proxies, etc.
Nonprofits are typically targets of this type of activity because their donate pages are as easy to submit as possible, in general. Holding banks (your account with payment processor) do not like to see this type of activity, and may give even a small organization trouble, so it's best to limit fraudulent transactions of this type as much as possible.

These tools will be especially useful when...

1) Your CMS security is compromised or misconfigured in some way and a user/bot can create malicious authenticated users, bypassing reCaptcha. This tool can trip them up to buy you time to find people and/or budget to figure out the CMS issue(s) and shut them down.
2) Your donation page is being targeted by a bot that can pass reCaptcha, or a real person simply answering reCaptcha and testing card numbers.

How to Use:
1) Download, install, and enable this CiviCRM extension
2) Navigate to CiviCRM>Administer>Honeypot Settings and choose the Contribute forms you would like to protect, and at least one field name for the honeypot field.

Next Priority:
Suggestions welcome, open an issue in this repo. I currently can't promise things not in line with what this organization needs, but please feel free to PR!
