<?php
if(empty($plugins)) {
	return;
}

$out = array();
$plugins = array_chunk($plugins, round((count($plugins) / 3) + 1));
foreach($plugins as &$pluginList) {
	foreach($pluginList as &$plugin) {
		if($plugin['count']) {
			$plugin = $this->Html->link($plugin['name'], array(
				'plugin' => 'infinitas_docs',
				'controller' => 'infinitas_docs',
				'action' => 'index',
				'doc_plugin' => $plugin['slug']
			));
		} else {
			$plugin = $plugin['name'];
		}
	}

	$pluginList = $this->Html->tag('div', $this->Design->arrayToList($pluginList), array(
		'class' => 'plugins'
	));
}

$heading = __d('infinitas_docs', 'Plugins');
if($core) {
	$heading = __d('infinitas_docs', 'Core Plugins');
}
echo $this->Html->tag('div', $this->Html->tag('h2', $heading) . implode('', $plugins), array('class' => array(
	'infinitas_docs',
	$core ? 'core' : null
)));
