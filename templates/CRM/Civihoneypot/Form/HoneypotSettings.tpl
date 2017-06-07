<div class="crm-block crm-form-block crm-miscellaneous-form-block">

  <table class="form-layout">
    <tbody>
      <tr>
        <td class="label">{$form.form_ids.label}</td>
        <td class="content">{$form.form_ids.html}
          <p class="description">{ts domain='com.elisseck.civihoneypot'}Choose which contribution pages you would like to protect{/ts}</p></td>
      </tr>
      <tr>
        <td class="label">{$form.protect_all.label}</td>
        <td class="content">{$form.protect_all.html}
          <p class="description">{ts domain='com.elisseck.civihoneypot'}Alternatively, protect all contribution pages by ticking this checkbox{/ts}</p></td>
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
	  <tr>
        <td class="label">{$form.ipban.label}</td>
        <td class="content">{$form.ipban.html}
          <p class="description">{ts domain='com.elisseck.civihoneypot'}Enter a comma separated list of IP addresses you would like to ban from Contribution pages.{/ts}</p></td>
      </tr>
    </tbody>
  </table>
 
{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>

</div>
