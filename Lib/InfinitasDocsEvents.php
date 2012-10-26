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
		InfinitasRouter::connect(
			'/infinitas_docs/:doc_plugin', 
			array(
				'plugin' => 'infinitas_docs',
				'controller' => 'infinitas_docs',
				'action' => 'index'
			), 
			array(
				'pass' => array(
					'doc_plugin'
				)
			)
		);

		InfinitasRouter::connect(
			'/infinitas_docs/:doc_plugin/:slug', 
			array(
				'plugin' => 'infinitas_docs',
				'controller' => 'infinitas_docs',
				'action' => 'view'
			), 
			array(
				'pass' => array(
					'doc_plugin',
					'slug'
				)
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
		if(isset($Event->Handler->request->params['admin']) && $Event->Handler->request->params['admin']) {
			return;
		}

		return array(
			'InfinitasDocs.infinitas_docs'
		);
	}
}
