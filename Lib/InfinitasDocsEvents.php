<?php
/**
 * @brief events for the InfinitasDocs plugin
 */
class InfinitasDocsEvents extends AppEvents {
/**
 * @brief configure some basic routing for the docs
 *
 * @param Event $Event The event triggered
 *
 * @return void
 */
	public function onSetupRoutes(Event $Event) {
		$url = array(
			'plugin' => 'infinitas_docs',
			'controller' => 'infinitas_docs',
			'action' => 'index'
		);
		$params = array(
			'pass' => array(
				'doc_plugin'
			)
		);
		InfinitasRouter::connect('/infinitas_docs/:doc_plugin', $url, $params);

		$url['action'] = 'view';
		$params['pass'][] = 'slug';
		InfinitasRouter::connect('/infinitas_docs/:doc_plugin/:slug', $url, $params);
	}

/**
 * @brief plugin details
 *
 * @return array
 */
	public function onPluginRollCall() {
		return array(
			'name' => 'Docs',
			'description' => 'Infinitas docs viewer',
			'icon' => '/infinitas_docs/img/icon.png',
			'author' => 'Infinitas',
			'dashboard' => array(
				'plugin' => 'infinitas_docs',
				'controller' => 'infinitas_docs',
				'action' => 'index'
			)
		);
	}

/**
 * @brief load css required for the docs
 *
 * @param Event $Event the Event that was triggered
 *
 * @return array|void
 */
	public function onRequireCssToLoad(Event $Event) {
		return $this->_loadAssets($Event);
	}

/**
 * @brief load js required for the docs
 *
 * @param Event $Event the Event that was triggered
 *
 * @return array|void
 */
	public function onRequireJavascriptToLoad(Event $Event, $data = null) {
		return $this->_loadAssets($Event);
	}

/**
 * @brief method for loading the assets
 *
 * @param Event $Event the Event that was triggered
 *
 * @return array|void
 */
	protected function _loadAssets($Event) {
		return array(
			'InfinitasDocs.infinitas_docs'
		);
	}

}
