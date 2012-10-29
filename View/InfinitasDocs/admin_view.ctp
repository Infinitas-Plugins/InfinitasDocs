<?php
$link = $this->Html->link($pluginDoc['Plugin']['name'], array(
	'action' => 'index',
	'doc_plugin' => $pluginDoc['Plugin']['name']
));
echo $this->Html->tag('h1', __d('infinitas_docs', '%s :: %s', $link, $pluginDoc['Documentation']['name']));
echo $this->Html->tag('div', $pluginDoc['Documentation']['contents'], array('class' => 'infinitas_docs'));

$links = array(
	$this->Html->link(__d('infinitas_docs', 'All Docs'), array(
		'plugin' => 'infinitas_docs',
		'controller' => 'infinitas_docs',
		'action' => 'index',
		'doc_plugin' => false
	)),
	__d('infinitas_docs', 'Back to %s docs', $link),
	$this->Html->link(__d('infinitas_docs', 'Edit on GitHub'), $pluginDoc['Documentation']['github'])
);
echo $this->Design->arrayToList($links, array('div' => 'infinitas_docs footer'));