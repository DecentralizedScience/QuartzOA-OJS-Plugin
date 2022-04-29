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
		return 'Quartz OA';
	}

	/**
	* Provide a description for this plugin
	*
	* The description will appear in the Plugin Gallery where editors can
	* install, enable and disable plugins.
	*/
	public function getDescription() {
		return 'This plugin enables <a href="https://quartz.to">Quartz OA</a> donations and microdonations using web monetization.';
	}

	public function getContents($templateMgr, $request = null) {
		$templateMgr->assign('madeByText', 'Made with ❤ by the Quartz OA team');
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
						'category' => 'generic'
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

			// Return a JSON response containing the
			// settings form
			case 'settings':
			$templateMgr = TemplateManager::getManager($request);
			$settingsForm = $templateMgr->fetch($this->getTemplateResource('settings.tpl'));
			return new JSONMessage(true, $settingsForm);
		}
		return parent::manage($args, $request);
	}
}
