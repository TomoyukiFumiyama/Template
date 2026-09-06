(function () {
	'use strict';

	var mobileQuery = window.matchMedia('(max-width: 767px)');

	/**
	 * Telephone links remain usable on smartphones, but do not launch a phone
	 * handler on tablet/desktop layouts.
	 */
	document.addEventListener('click', function (event) {
		var telephoneLink = event.target.closest('a[href^="tel:"]');

		if (telephoneLink && !mobileQuery.matches) {
			event.preventDefault();
		}
	});
}());
