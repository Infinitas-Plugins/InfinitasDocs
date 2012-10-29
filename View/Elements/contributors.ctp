<?php
if(empty($plugin['Contributor'])) {
	return;
}

foreach($plugin['Contributor'] as &$contributor) {
	$commits = __d('infinitas_docs', '%d commits', $contributor['commits']);
	$contributor = $this->Html->link(
		sprintf('%s<br/>%s<br/>',
			$this->Html->image($contributor['avatar'], array('width' => '80px')),
			$contributor['name']
		),
		$contributor['link'],
		array(
			'escape' => false
		)
	);
	$contributor = $this->Html->tag('div', $contributor . $commits, array('class' => 'contributor'));
}

array_unshift($plugin['Contributor'], $this->Html->tag('h2', __d('infinitas_docs', 'Contributors')));
echo $this->Html->tag('div', implode('', $plugin['Contributor']), array(
	'class' => array(
		'infinitas_docs',
		'contributors'
	)
));
