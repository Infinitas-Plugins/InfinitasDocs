<?php
$link = $this->Html->link($pluginDoc['Plugin']['name'], array(
	'action' => 'index',
	'doc_plugin' => $pluginDoc['Plugin']['name']
));
echo $this->Html->tag('h1', __d('infinitas_docs', '%s :: %s', $link, $pluginDoc['Documentation']['name']));
echo $this->Html->tag('div', $pluginDoc['Documentation']['contents'], array('class' => 'infinitas_docs'));

echo $this->Html->tag('div', implode('', array(
	__d('infinitas_docs', 'Back to %s docs', $link)
)));