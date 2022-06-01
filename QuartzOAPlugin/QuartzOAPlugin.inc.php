<?php
import('lib.pkp.classes.plugins.BlockPlugin');
class QuartzOAPlugin extends BlockPlugin {
	public function register($category, $path, $mainContextId = NULL) {

		// Register the plugin even when it is not enabled
		$success = parent::register($category, $path);

		if ($success && $this->getEnabled()) {
			// Do something when the plugin is enabled
		}

		return $success;
	}

	/**
	* Provide a name for this plugin
	*
	* The name will appear in the Plugin Gallery where editors can
	* install, enable and disable plugins.
	*/
	public function getDisplayName() {
		
		return __('plugins.block.QuartzOAPlugin.displayName');
	}

	/**
	* Provide a description for this plugin
	*
	* The description will appear in the Plugin Gallery where editors can
	* install, enable and disable plugins.
	*/
	public function getDescription() {
		return __('plugins.block.QuartzOAPlugin.description');;
	}

	public function getContents($templateMgr, $request = null) {

		$templateMgr->assign('paypalEmail', $this->getSetting( $request->getContext()->getId(), 'paypalEmail'));
		$templateMgr->assign('ilpWallet', $this->getSetting( $request->getContext()->getId(), 'ilpWallet'));
		return parent::getContents($templateMgr, $request);
	}

	public function getActions($request, $actionArgs) {

		// Get the existing actions
		$actions = parent::getActions($request, $actionArgs);
		if (!$this->getEnabled()) {
			return $actions;
		}

		// Create a LinkAction that will call the plugin's
		// `manage` method with the `settings` verb.
		$router = $request->getRouter();
		import('lib.pkp.classes.linkAction.request.AjaxModal');
		$linkAction = new LinkAction(
			'settings',
			new AjaxModal(
				$router->url(
					$request,
					null,
					null,
					'manage',
					null,
					array(
						'verb' => 'settings',
						'plugin' => $this->getName(),
						'category' => 'blocks'
					)
				),
				$this->getDisplayName()
			),
			__('manager.plugins.settings'),
			null
		);

		// Add the LinkAction to the existing actions.
		// Make it the first action to be consistent with
		// other plugins.
		array_unshift($actions, $linkAction);

		return $actions;
	}

	public function manage($args, $request) {
		switch ($request->getUserVar('verb')) {
      case 'settings':

        // Load the custom form
        $this->import('QuartzOASettingsForm');
				$request = PKPApplication::getRequest();
				$context = $request->getContext();
				// This should only ever happen within a context, never site-wide.
				assert($context != null);
				$contextId = $context->getId();
        $form = new QuartzOASettingsForm($this);

        // Fetch the form the first time it loads, before
        // the user has tried to save it
        if (!$request->getUserVar('save')) {
          $form->initData();
				  return new JSONMessage(true, $form->fetch($request));
        }

        // Validate and execute the form
        $form->readInputData();
        if ($form->validate()) {
          $form->execute();
          return new JSONMessage(true);
        }
		}
		return parent::manage($args, $request);
	}

}
