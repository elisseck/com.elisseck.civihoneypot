{* template block that contains the new field *}
<div>{debug}</div>
<div id={$fieldname} hidden>
  <div>{$form.$fieldname.label}</div>
  <div>{$form.$fieldname.html}</div>
</div>
{* reposition the above block after #someOtherBlock *}
<script type="text/javascript">
  CRM.$('#{$fieldname}').insertAfter('.custom_pre_profile-group')
  CRM.$('input[name={$fieldname}]').prop('required',true);
  CRM.$('#Main').attr('novalidate','novalidate');
</script>