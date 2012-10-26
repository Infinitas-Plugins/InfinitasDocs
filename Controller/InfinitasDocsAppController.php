<?php
/**
 * @brief  InfinitasDocsAppController
 */

class InfinitasDocsAppController extends AppController {
/**
 * @brief  before filter for InfinitasDocs plugin
 *
 * If the app is not in debug mode and allow_live config is false an exception is
 * thrown. To allow viewing the documentation on live sites the config option
 * InfinitasDocs.allow_live should be set to true
 *
 * @throws NotFoundException
 */
	public function beforeFilter() {
		parent::beforeFilter();

		if(Configure::read('debug') === 0 && !Configure::read('InfinitasDocs.allow_live')) {
			throw new NotFoundException();
		}
	}
	
}
