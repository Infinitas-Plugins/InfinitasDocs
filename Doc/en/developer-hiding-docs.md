If you have some documentation that you do not want to show, they can easily be hidden by adjusting the configuration for the plugin.

You may want to do this to display documentation for your custom plugins to clients or visitors to your website, whilst hiding the general Infinitas documentation.

### Backend

Open up the [configs](/infinitas\_docs/Configs) in the backend and add or edit the options for `InfinitasDocs.ignore` to include the plugins that you do not want included in the listing.

### Programmatically

You can set the config options after the database configs have been merged, and before the read on the model is done for the listing.

	// array usage
	Configure::write('InfinitasDocs.ignore', array(
		'SomePlugin',
		'AnotherPlugin'
	));

	// string usage
	Configure::write('InfinitasDocs.ignore', 'SomePlugin,AnotherPlugin');
