<?php
echo $this->element('InfinitasDocs.plugins', array(
	'plugins' => $docsCorePlugins,
	'core' => true
));

echo $this->element('InfinitasDocs.plugins', array(
	'plugins' => $docsPlugins,
	'core' => false
));

if(empty($pluginDocs)) {
	return;
}

$pluginDocs['Documentation'] = array_chunk($pluginDocs['Documentation'], round((count($pluginDocs['Documentation']) / 3) + 1));

foreach($pluginDocs['Documentation'] as &$docs)  {
	foreach($docs as &$doc) {
		$doc = $this->Html->link($doc['name'], array(
			'plugin' => 'infinitas_docs',
			'controller' => 'infinitas_docs',
			'action' => 'view',
			'doc_plugin' => $pluginDocs['Plugin']['slug'],
			'slug' => $doc['slug']
		));
	}

	$docs = $this->Html->tag('div', $this->Design->arrayToList($docs), array(
		'class' => 'plugins'
	));
}

$readme = null;
if(!empty($pluginReadme['Documentation']['contents'])) {
	$readme = $this->Html->tag('div', $pluginReadme['Documentation']['contents'] . "<hr>", array('class' => 'readme'));
}

$class = array(
	'infinitas_docs',
	$pluginDocs['Plugin']['core'] ? 'core' : null
);
echo $this->Html->tag('div', implode('', array(
	$this->Html->tag('h1', $pluginDocs['Plugin']['name']),
	$readme,
	implode('', $pluginDocs['Documentation'])
)), array('class' => $class));

echo $this->Html->tag('div', $this->Html->link(__d('infinitas_docs', 'Show all'), array(
	'action' => 'index',
	'slug' => false,
	'doc_plugin' => false
)), array('class' => 'infinitas_docs footer'));
