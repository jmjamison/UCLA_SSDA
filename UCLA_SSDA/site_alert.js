
/**
 * @file ct_topic_landing_page.js
 */
(function ($) {

// Initial page load.
$(window).load(function() {
  // Load alert text.
  loadAlert();
});

// Function to update alert text.
var loadAlert = function () {
  var callback = '/ajax/site_alert';
  $('.site-alert').load(callback);
  // Update content every 5 minutes.
  setTimeout(loadAlert, 300000);
}

})(jQuery);
