/**
 * @file uclalib_opening_hours.js
 */
(function ($) {

Drupal.behaviors.openingHours = {
	attach: function (context, settings) {

		// Attach pager behavior to hours arrow links.
		$('.opening-hours-link').once(function() {
			$(this).click(function() {
				addWeekPager($(this));
				return false;
			});
		});
	}
};

var addWeekPager = function (element) {
	var nid = $(element).attr('nid');
	var date = ($(element).attr('date'));
	var tableCallback = "/ajax/opening_hours_table/" + nid + "/" + date;
	var table = $(element).closest('table');
	table.load(tableCallback, function() {
		Drupal.attachBehaviors($(this));
	});
};

})(jQuery);
