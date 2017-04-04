<div class="crm-block crm-form-block crm-miscellaneous-form-block">

  <table class="form-layout">
    <tbody>
      <tr>
        <td class="label">{$form.form_ids.label}</td>
        <td class="content">{$form.form_ids.html}
          <p class="description">{ts domain='com.elisseck.civihoneypot'}Form IDs to place honeypot - use a comma separated list for multiple forms e.g. 1,2,3{/ts}</p></td>
      </tr>
      <tr>
        <td class="label">{$form.field_names.label}</td>
        <td class="content">{$form.field_names.html}
          <p class="description">{ts domain='com.elisseck.civihoneypot'}Names for honeypot fields - use a comma separated list for multiple randomized names e.g. url,link,username{/ts}</p></td>
      </tr>
	  <tr>
        <td class="label">{$form.limit.label}</td>
        <td class="content">{$form.limit.html}
          <p class="description">{ts domain='com.elisseck.civihoneypot'}Time limiter for protected forms. Honeypot will prevent submissions in under this number of seconds after form loads.{/ts}</p></td>
      </tr>
    </tbody>
  </table>

{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>

</div>