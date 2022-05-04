<script>
	$(function() {ldelim}
		$('#QuartzOASettings').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form
  class="pkp_form"
  id="QuartzOASettings"
  method="POST"
  action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="blocks" plugin=$pluginName verb="settings" save=true}"
>
  <!-- Always add the csrf token to secure your form -->
	{csrf}

  {fbvFormArea}
		{fbvFormSection}
			{fbvElement
        type="text"
        id="secretKey"
        value=$secretKey
        label="Secret Key"
      }
		{/fbvFormSection}
  {/fbvFormArea}
	{fbvFormButtons submitText="common.save"}
</form>
