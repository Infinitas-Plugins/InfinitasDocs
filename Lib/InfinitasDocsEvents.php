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
	public function onPluginRollCall(Event $Event) {
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
	protected function _loadAssets(Event $Event) {
		return array(
			'InfinitasDocs.infinitas_docs'
		);
	}

/**
 * Return messages for docs and api requests
 *
 * Options:
 * 	!docs for documentaion links
 * 	!api for api links
 * 
 * @param Event  $Event the event being triggered
 * @param array $data the data being parsed
 * 
 * @return boolean
 */
	public function onIrcMessage(Event $Event, $data = null) {
		$options = array(
			'to' => $data['to'],
			'args' => $data['args'],
			'api' => 'http://api.infinitas-cms.org',
			'docs' => 'http://infinitas-cms.org/infinitas_docs'
		);

		if($data['command'] == 'api') {
			$message = ':to: :api';
			if(!empty($options['args'])) {
				if($options['args'] == 'help') {
					$message = ':to: !api [class_name|ClassName|plugin_name|PluginName]';
				} else {
					$message = ':to: :api/classes/:args.html';

					$options['args'] = Inflector::camelize($options['args']);
					if(in_array($options['args'], InfinitasPlugin::listPlugins('all'))) {
						if(strstr(InfinitasPlugin::path($options['args']), '/Core/') !== false) {
							$options['args'] = 'Infinitas.' . $options['args'];
						}
						$message = ':to: :api/packages/:args.html';
					}
				}
					
			}

			$Event->Handler->reply($data['channel'], $message, $options);
			return true;
		}

		if($data['command'] == 'docs') {
			$message = ':to: :docs';
			if(!empty($options['args'])) {
				if($options['args'] == 'help') {
					$message = ':to: !docs [plugin_name|PluginName]';
				} else {
					$options['args'] = Inflector::camelize($options['args']);
					$message = ':to: :docs/:args';
				}
			}

			$Event->Handler->reply($data['channel'], $message, $options);
			return true;
		}

		return false;
	}

}
