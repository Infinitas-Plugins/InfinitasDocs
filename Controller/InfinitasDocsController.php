<?php
/**
 * @brief Infinitas
 */
class InfinitasDocsController extends InfinitasDocsAppController {
/**
 * @brief before filter to configure notices
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->notice['changed'] = array(
			'message' => __d('infinitas_docs', 'The doc type has been changed'),
			'redirect' => true
		);

		$this->notice['not_changed'] = array(
			'message' => __d('infinitas_docs', 'The doc type could not be changed'),
			'redirect' => true,
			'level' => 'warning'
		);

		$this->notice['not_found'] = array(
			'message' => __d('infinitas_docs', 'The selected doc could not be found'),
			'redirect' => true,
			'level' => 'warning'
		);

		$this->notice['empty'] = array(
			'message' => __d('infinitas_docs', 'The selected docs are empty'),
			'redirect' => true,
			'level' => 'warning'
		);

		$this->set('infinitasDocTypes', $this->{$this->modelClass}->docTypes());
	}

/**
 * @brief switch the doc type being shown
 *
 * @param string $type the type to show
 */
	public function switchDocType($type = null) {
		try {
			if($this->{$this->modelClass}->switchType($type)) {
				$this->notice('changed');
			}
		} catch (Exception $e) {
			$this->notice($e);
		}

		$this->notice('not_changed');
	}

/**
 * @brief view a list of available docs
 *
 * If no plugin is selected a list of plugins will be displayed. If a plugin is
 * selected the list of docs will be displayed
 */
	public function index() {
		$this->saveRedirectMarker();
		$docsCorePlugins = $docsPlugins = $pluginDocs = array();
		if(empty($this->request->doc_plugin)) {
			$docsCorePlugins = $this->{$this->modelClass}->plugins('core');
			$docsPlugins = $this->{$this->modelClass}->plugins('nonCore');
		} else {
			try {
				$pluginDocs = $this->{$this->modelClass}->plugin($this->request->doc_plugin);
				if(empty($pluginDocs)) {
					$this->notice('empty');
				}
			} catch (Exception $e) {
				$this->notice($e);
			}
		}

		$this->set(compact('docsCorePlugins', 'docsPlugins', 'pluginDocs'));
	}

/**
 * @brief view a page of documentation
 */
	public function view() {
		if(empty($this->request->doc_plugin) || empty($this->request->slug)) {
			$this->notice(__d('infinitas_docs', 'Invalid documentation selected'), array(
				'level' => 'warning',
				'redirect' => true
			));
		}

		$pluginDoc = $this->{$this->modelClass}->documentation(
			$this->request->doc_plugin,
			$this->request->slug
		);

		if(empty($pluginDoc)) {
			$this->notice('not_found');
		}

		$this->set(compact('pluginDoc'));
	}

}