<?php
echo $this->element('InfinitasDocs.plugins', array(
	'plugins' => $docsCorePlugins,
	'core' => true
));

echo $this->element('InfinitasDocs.plugins', array(
	'plugins' => $docsPlugins,
	'core' => false
));

if(!empty($pluginDocs)) {
	$chunk = round(count($pluginDocs['Documentation']) / 3);
	$chunk = $chunk > 0 ? $chunk : 1;
	$pluginDocs['Documentation'] = array_chunk($pluginDocs['Documentation'], $chunk);

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
}



$readme = null;
$links = array();
if(!empty($pluginReadme['Documentation']['contents'])) {
	$readme = $this->Html->tag('div', $pluginReadme['Documentation']['contents'] . "<hr>", array('class' => 'readme'));
	$links[] = $this->Html->link(__d('infinitas_docs', 'Edit on GitHub'), $pluginReadme['Documentation']['github']);
}

if(empty($pluginDocs)) {
	if(empty($readme)) {
		return;
	}
	$pluginDocs['Plugin'] = $pluginReadme['Plugin'];
	$pluginDocs['Documentation'] = array(__d('infinitas_docs', 'No more documentation found'));
}

$class = array(
	'infinitas_docs',
	isset($pluginDocs['Plugin']['core']) && $pluginDocs['Plugin']['core'] ? 'core' : null
);
echo $this->Html->tag('div', implode('', array(
	$this->Html->tag('h1', $pluginDocs['Plugin']['name']),
	$readme,
	$readme ? $this->Html->tag('h3', __d('infinitas_docs', 'More')) : null,
	implode('', $pluginDocs['Documentation']),
	$this->Html->tag('hr')
)), array('class' => $class));

array_unshift($links, $this->Html->link(__d('infinitas_docs', 'All Docs'), array(
	'action' => 'index',
	'slug' => false,
	'doc_plugin' => false
)));

echo $this->Design->arrayToList($links, array('div' => 'infinitas_docs footer'));
