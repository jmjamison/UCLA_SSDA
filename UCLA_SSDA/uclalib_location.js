/**
 * @file uclalib_location.js
 */
(function ($) {

// Initial page load.
$(window).load( function() {
  // Initial population of open now/closed text.
  checkIfOpen();

  // Update every five minutes.
  setInterval( function() {
    checkIfOpen();
  }, 300*1000);

});

// Function to check if the current location is open now or not.
var checkIfOpen = function () {
  var openNowCallback = "/ajax/open_now/" + Drupal.settings.locationNid.nid;
  $.getJSON(openNowCallback).done(function(data) {
    if (typeof data.nodes[0] !== 'undefined') {
      if (data.nodes[0].node.nid == Drupal.settings.locationNid.nid) {
        $('.open-now-pane').html('<span class="location-open-now">Open Now</span>');
      }
    }
    else {
      $('.open-now-pane').html('<span class="location-closed">Closed</span>');
    }
  })
  .fail(function() {
    console.log("Could not get location opening status.");
  })
}

})(jQuery);
