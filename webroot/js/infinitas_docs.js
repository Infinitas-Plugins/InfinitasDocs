/**
 * @brief add some functionality to the docs that is difficult with markdown
 */
$(document).ready(function() {
	$('.infinitas_docs a>img').on('click', function() {
		var $this = $(this);
		debug($this.parent());
		var title = $this.attr('title'),
			url = $this.parent().attr('href'),
			imageGroup = this.rel || false;

		tb_show(title, url, imageGroup);
		this.blur();
		return false;
	});

	$('a').on('click', function() {
		var $this = $(this),
			url = $this.attr('href');
		var external = strstr(url, location.host) === false && url.charAt(0) != '/' && url.charAt(0) != '#';
		if(external) {
			$this.attr('target', '_blank');
		}
	});
});

/**
 * @brief copy from KVZ's php -> js port.
 *
 * Works like php strstr
 */
function strstr(haystack, needle, bool) {
    var pos = 0;

    haystack += "";
    pos = haystack.indexOf(needle);

	if (pos == -1) {
        return false;
    }

	if (bool) {
		return haystack.substr(0, pos);
	}
	return haystack.slice(pos);
}