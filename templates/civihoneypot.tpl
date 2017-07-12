{* template block that contains the new field *}
<div id={$fieldname} hidden>
  <div>{$form.$fieldname.label}</div>
  <div>{$form.$fieldname.html}</div>
</div>
<div id=timestamp hidden>
  <div>{$form.timestamp.label}</div>
  <div>{$form.timestamp.html}</div>
</div>
{* reposition the above block after #someOtherBlock *}
<script type="text/javascript">
  CRM.$('#{$fieldname}').insertAfter(`{$insertAfterClass}`);
  CRM.$('#timestamp').insertAfter(`{$insertAfterClass}`);
  CRM.$('input[name={$fieldname}]').prop('required',true);
  CRM.$('input[name=timestamp]').attr('value',{$timestamp}).prop('readonly',true);
  CRM.$(`{$noValidateSelectorID}`).attr('novalidate','novalidate');
</script>
