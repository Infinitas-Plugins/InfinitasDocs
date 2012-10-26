If you have some documentation that you do not want to show, it can be hidden by adjusting the configuration for the plugin.

You may want to do this to display documentation for your custom plugins to clients or visitors to your website, whilst hiding the general Infinitas documentation.

By default **all** documentation is available and can be viewed on sites that have debug enabled. Turning debug off will by default hide all documentation.

### Config options

There are two configuration options available that control what documentation is available.

- `only`: If the only option is configured, only plugins listed will be available. This is the setting to use if you only want to show a limited set of documentation.
- `ignore`: When configured the documentation for the configured plugins will not be available.

> When the `only` option is set, `ignore` is not used at all.

> Hiding documentation will not affect links in pages that are still available. If you had a link to documentation that was not available a [notice](/infinitas\_docs/Libs/error-notices) will be shown.

#### Backend

Open up the [configs](/infinitas\_docs/Configs) in the backend and add or edit the options for `InfinitasDocs.ignore` to include the plugins that you do not want included in the listing.

#### Programmatically

You can set the config options after the database configs have been merged, and before the read on the model is done for the listing.

	// array usage
	Configure::write('InfinitasDocs.ignore', array(
		'SomePlugin',
		'AnotherPlugin'
	));

	// string usage
	Configure::write('InfinitasDocs.only', 'SomePlugin,AnotherPlugin');

> Either array or string notation may be used for both configuration options.
