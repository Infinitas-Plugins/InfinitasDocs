<?php
App::uses('CakeSession', 'Model/Datasource');

class InfinitasDoc extends InfinitasDocsAppModel {
/**
 * @brief there is no table for this model
 *
 * @var boolean
 */
	public $useTable = false;

/**
 * @brief the available documentation types
 *
 * @var array
 */
	protected $_docTypes = array();

/**
 * @brief where the current doc type is stored
 *
 * @var array
 */
	protected $_docTypeVar = 'InfinitasDocs.doc_type';

/**
 * @brief check that a plugin is valid
 *
 * @param string $plugin the plugin to check
 *
 * @return boolean
 */
	protected function validateValidPlugin($plugin) {
		return in_array($plugin, $this->plugins('all'));
	}

/**
 * @brief get the available documentation types
 *
 * @return array
 */
	public function docTypes($type = null) {
		if(empty($this->_docTypes)) {
			$this->_docTypes = array(
				'user' => array(
					'name' => __d('infinitas_docs', 'User'),
					'slug' => 'user',
					'prefix' => null
				),
				'dev' => array(
					'name' => __d('infinitas_docs', 'Developer'),
					'slug' => 'dev',
					'prefix' => 'dev'
				)
			);
		}

		if($type) {
			if(!empty($this->_docTypes[$type])) {
				return $this->_docTypes[$type];
			}
			return array();
		}

		return $this->_docTypes;
	}

/**
 * @brief switch the doc type that is shown
 *
 * @param string $type the selected doc type
 *
 * @throws InvalidArgumentException
 */
	public function switchType($type) {
		$type = $this->docTypes($type);

		if(!empty($type['slug'])) {
			return CakeSession::write($this->_docTypeVar, $type['slug']);
		}
		throw new InvalidArgumentException(__d('infinitas_docs', 'Invalid documentation type'));
	}

/**
 * @brief get the currently selected doc type
 *
 * @return string
 */
	public function getType() {
		return CakeSession::read($this->_docTypeVar);
	}

/**
 * @brief get a list of plugins available by type
 *
 * @return array
 */
	public function plugins($type, $count = false) {
		$plugins = $this->_documentedPlugins($type);
		if(!$count) {
			return $plugins;
		}

		$return = array();
		foreach($plugins as $plugin) {
			$return[] = array(
				'name' => $plugin,
				'slug' => $plugin,
				'count' => $this->_countDocs($plugin)
			);
		}

		return $return;
	}

/**
 * @brief get plugins to display docs for
 *
 * - only: If set, only plugins in this list will be available.
 * - ignore: If set, anything in this list will be filtered out an not available
 *
 * @param string $type the type of plugin to look for.
 *
 * @return array
 */
	protected function _documentedPlugins($type) {
		$plugins = InfinitasPlugin::listPlugins($type);
		$ignore = Configure::read('InfinitasDocs.ignore');
		$only = Configure::read('InfinitasDocs.only');

		if(empty($ignore) && empty($only)) {
			return $plugins;
		}

		if(!is_array($ignore)) {
			$ignore = array_filter(explode(',', $ignore));
		}

		if(!is_array($only)) {
			$only = array_filter(explode(',', $only));
		}

		foreach($plugins as $k => $plugin) {
			if(!empty($only)) {
				if(!in_array($plugin, $only)) {
					unset($plugins[$k]);
				}
				continue;
			}

			if(in_array($plugin, $ignore)) {
				unset($plugins[$k]);
			}
		}

		return $plugins;
	}

/**
 * @brief get a cound of docs available
 *
 * @param string $plugin the plugin to get the doc count for
 *
 * @return integer
 */
	protected function _countDocs($plugin) {
		try {
			return $this->_iterator($plugin)->count();
		} catch (Exception $e){}

		return 0;
	}

/**
 * @brief get all the docs for the selected plugin
 *
 * @param string $plugin the plugin to get docs for
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	public function plugin($plugin) {
		if(!$this->validateValidPlugin($plugin)) {
			throw new InvalidArgumentException(__d('infinitas_docs', 'Invalid plugin selected'));
		}

		return $this->_pluginDocs($plugin);
	}

/**
 * @brief get the docs available for the selected plugin
 *
 * @param string $plugin the plugin that has been selected
 *
 * @return array
 */
	protected function _pluginDocs($plugin) {
		$docs = $this->_iterator($plugin);

		$pluginDocs = array();
		for($docs->rewind(); $docs->valid(); $docs->next()) {
			$file = $docs->current()->getBasename('.md');
			if(strtolower($file) == 'readme') {
				continue;
			}
			$pluginDocs[] = array(
				'name' => $this->_docName($file),
				'slug' => $file,
				'file' => $docs->current()->getBasename(),
				'path' => $docs->current()->getPath()
			);
		}

		if(empty($pluginDocs)) {
			return array();
		}

		usort($pluginDocs, function ($a, $b) {
			return strcasecmp($a['slug'], $b['slug']);
		});

		return $pluginDocs = array(
			'Plugin' => array(
				'name' => Inflector::humanize($plugin),
				'slug' => $plugin,
				'core' => in_array($plugin, $this->plugins('core'))
			),
			'Documentation' => $pluginDocs
		);
	}

/**
 * @brief make a decent name for the plugin to be displayed
 *
 * @param string $name the name of the file
 *
 * @return string
 */
	protected function _docName($name) {
		$type = $this->docTypes($this->getType());
		$list = explode('-', $name, 2);
		if(!empty($list[1]) && ((int)$list[0] !== 0 || $list[0] === '0')) {
			$name = $list[1];
		}
		$name = Inflector::humanize(Inflector::slug($name));

		return $name;
	}

/**
 * @brief get the contents of a specific doc
 *
 * @param string $plugin the name of the plugin the doc is from
 * @param string $file the file to load
 *
 * @return array
 *
 * @throws InvalidArgumentException
 */
	public function documentation($plugin, $file) {
		if($file === null && $plugin == 'readme') {
			return array(
				'Plugin' => array(
					'name' => 'Infinitas Cms',
					'slug' => null,
					'core' => true
				),
				'Documentation' => array(
					'name' => 'Infinitas Cms',
					'slug' => 'readme',
					'file' => 'readme.md',
					'path' => APP . 'Core' . DS,
					'contents' => $this->_getContent(APP . 'Core' . DS . 'readme.md'),
					'github' => $this->_gitHub(APP . 'Core' . DS . 'readme.md')
				),
				'Contributor' => $this->_contributors('Users')
			);
		}
		if(!$this->validateValidPlugin($plugin)) {
			throw new InvalidArgumentException(__d('infinitas_docs', 'Invalid plugin selected'));
		}
		$docs = $this->_iterator($plugin);

		$pluginDocs = array();
		for($docs->rewind(); $docs->valid(); $docs->next()) {
			if($file == $docs->current()->getBasename('.md')) {
				$pluginDocs = array(
					'name' => $this->_docName($docs->current()->getBasename('.md')),
					'slug' => $docs->current()->getBasename('.md'),
					'file' => $docs->current()->getBasename(),
					'path' => $docs->current()->getPath(),
					'contents' => $this->_getContent($docs->current()->getPath() . DS . $docs->current()->getBasename()),
					'github' => $this->_gitHub($docs->current()->getPath() . DS . $docs->current()->getBasename())
				);
				break;
			}
		}

		if(empty($pluginDocs)) {
			return array();
		}

		return array(
			'Plugin' => array(
				'name' => Inflector::humanize($plugin),
				'slug' => $plugin,
				'core' => in_array($plugin, $this->plugins('core'))
			),
			'Documentation' => $pluginDocs,
			'Contributor' => $this->_contributors($plugin)
		);
	}

/**
 * @brief return the github url for easy access to editing the docs.
 *
 * @param string $file the full path to the file
 *
 * @return string
 */
	protected function _gitHub($file) {
		$url = 'https://github.com/';
		$github = array(
			'core' => 'infinitas/infinitas/blob/dev/',
			'plugin' => 'Infinitas-Plugins/',
			'developer' => 'Infinitas-Plugins/Developer/tree/master/',
			'docs' => 'Infinitas-Plugins/InfinitasDocs/tree/infinitas/'
		);

		if(strstr($file, '/Developer/') !== false) {
			if(strstr($file, 'InfinitasDocs/') === false) {
				return $url . str_replace(APP . 'Developer' . DS, $github['developer'], $file);
			}
			return $url . str_replace(APP . 'Developer' . DS . 'InfinitasDocs' . DS, $github['docs'], $file);
		}

		if(strstr($file, '/Core/') !== false) {
			return $url . str_replace(APP, $github['core'], $file);
		}

		return $url . str_replace(APP . 'Plugin' . DS, $github['plugin'], $file);
	}

/**
 * @brief get the markdown and parse to html
 *
 * @param string $file the path to the documentation
 *
 * @return string
 */
	protected function _getContent($file, $raw = false) {
		App::uses('File', 'Utility');
		$File = new File($file);
		$content = $File->read();

		$plugins = $this->plugins('all');
		$find = $replace = array();
		$regex = '/[^:|`|\\\'|\*|\/|\\|\[]\b(%s)(,?)[^:-]\b/';
		$link = ' [$1](/infinitas\_docs/%s)$2 ';
		foreach($plugins as $plugin) {
			$name = preg_replace('/^Infinitas/', '', $plugin);
			if(!empty($name)) {
				$find[] = sprintf($regex, $name);
				$replace[] = sprintf($link, $plugin);
			}

			$find[] = sprintf($regex, $plugin);
			$replace[] = sprintf($link, $plugin);
		}
		$content = preg_replace($find, $replace, $content);

		$find = array(
			sprintf($regex, 'Infinitas'),
			sprintf($regex, 'CakePHP|Cake')
		);
		$replace = array(
			' [$1](http://infinitas-cms.org "Infinitas Cms") ',
			' [$1](http://cakephp.org "CakePHP framework") ',
		);
		$content = preg_replace($find, $replace, $content);
		if($raw) {
			return $content;
		}

		App::uses('MarkdownText', 'InfinitasDocs.Lib/Markdown');
		$Markdown = new MarkdownText();
		$Markdown->setMarkdown($content . "\n");
		return $Markdown->getHtml();

	}

/**
 * @brief get the iterator for the docs
 *
 * @param string $plugin The plugin name to load docs for
 *
 * @return InfinitasDocsIterator
 */
	protected function _iterator($plugin) {
		if(!$this->validateValidPlugin($plugin)) {
			throw new InvalidArgumentException(__d('infinitas_docs', 'Invalid plugin selected'));
		}

		App::uses('InfinitasDocsIterator', 'InfinitasDocs.Lib');
		return new InfinitasDocsIterator(
				new RecursiveIteratorIterator(
					new RecursiveDirectoryIterator(InfinitasPlugin::path($plugin))));
	}

/**
 * @brief get a list of contributors for the passed in plugin
 *
 * @param type $plugin
 * @return type
 */
	protected function _contributors($plugin) {
		$github = 'https://api.github.com/repos/infinitas/infinitas/contributors';
		$pluginPath = InfinitasPlugin::path($plugin);

		if(strstr($pluginPath, '/Core/') === false) {
			$names = array(
				'Shop' => 'InfinitasShop',
				'Gallery' => 'InfinitasGallery',
				'Cms' => 'InfinitasCms',
				'Blog' => 'InfinitasBlog'
			);
			if(!empty($names[$plugin])) {
				$plugin = $names[$plugin];
			}
			if(in_array($plugin, array('Dev', 'Dummy', 'Xhprof'))) {
				$plugin = 'Developer';
			}
			$github = sprintf('https://api.github.com/repos/Infinitas-Plugins/%s/contributors', $plugin);
		}

		$contributors = @json_decode(file_get_contents($github), true);
		if(empty($contributors)) {
			return array();
		}
		
		foreach($contributors as &$contributor) {
			$contributor = array(
				'name' => $contributor['login'],
				'link' => $contributor['url'],
				'avatar' => $contributor['avatar_url'],
				'commits' => $contributor['contributions']
			);
		}

		return $contributors;
	}

}
