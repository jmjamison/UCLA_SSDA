(function ($) {

  /**
   * The recommended way for producing HTML markup through JavaScript is to write
   * theming functions. These are similiar to the theming functions that you might
   * know from 'phptemplate' (the default PHP templating engine used by most
   * Drupal themes including Omega). JavaScript theme functions accept arguments
   * and can be overriden by sub-themes.
   *
   * In most cases, there is no good reason to NOT wrap your markup producing
   * JavaScript in a theme function.
   */
  Drupal.theme.prototype.uclalibOmegaExampleButton = function (path, title) {
    // Create an anchor element with jQuery.
    return $('<a href="' + path + '" title="' + title + '">' + title + '</a>');
  };

  /**
   * Behaviors are Drupal's way of applying JavaScript to a page. In short, the
   * advantage of Behaviors over a simple 'document.ready()' lies in how it
   * interacts with content loaded through Ajax. Opposed to the
   * 'document.ready()' event which is only fired once when the page is
   * initially loaded, behaviors get re-executed whenever something is added to
   * the page through Ajax.
   *
   * You can attach as many behaviors as you wish. In fact, instead of overloading
   * a single behavior with multiple, completely unrelated tasks you should create
   * a separate behavior for every separate task.
   *
   * In most cases, there is no good reason to NOT wrap your JavaScript code in a
   * behavior.
   *
   * @param context
   *   The context for which the behavior is being executed. This is either the
   *   full page or a piece of HTML that was just added through Ajax.
   * @param settings
   *   An array of settings (added through drupal_add_js()). Instead of accessing
   *   Drupal.settings directly you should use this because of potential
   *   modifications made by the Ajax callback that also produced 'context'.
   */
  Drupal.behaviors.uclalibOmegaExampleBehavior = {
    attach: function (context, settings) {
      // By using the 'context' variable we make sure that our code only runs on
      // the relevant HTML. Furthermore, by using jQuery.once() we make sure that
      // we don't run the same piece of code for an HTML snippet that we already
      // processed previously. By using .once('foo') all processed elements will
      // get tagged with a 'foo-processed' class, causing all future invocations
      // of this behavior to ignore them.
      $('.some-selector', context).once('foo', function () {
        // Now, we are invoking the previously declared theme function using two
        // settings as arguments.
        var $anchor = Drupal.theme('uclalibOmegaExampleButton', settings.myExampleLinkPath, settings.myExampleLinkTitle);

        // The anchor is then appended to the current element.
        $anchor.appendTo(this);
      });
    }
  };

  Drupal.behaviors.uclalibSearchToggle = {
    attach: function () {
      $('.header-search-form-label').click( function () {
        $(this).toggleClass('is-active');
      });
    }
  };

  // Expand facet blocks with checked elements.
  Drupal.behaviors.uclalibFacetHeader = {
    attach: function () {
      $('.ctools-collapsible-container ul input[type="checkbox"]:checked').parents('.ctools-collapsible-content').siblings('h2').click();
    }
  };

})(jQuery);

function fancybox_beforeshow() {
  this.title = '<div class="title">' + (this.title ? '' + this.title + '' : '') + '</div><div class="slide-numbers" style="position: absolute; top: 0; left: 0;">' + (this.index + 1) + ' of ' + this.group.length + '</div>';
}

function fancybox_aftershow() {
  width = jQuery('.fancybox-title .child').width();
  image_width = jQuery('.fancybox-image').width();
  image_height = jQuery('.fancybox-image').height();
  jQuery('.fancybox-title .slide-numbers').css("margin-left", -(image_width - width - 390) + "px");
  jQuery('.fancybox-title .slide-numbers').css("top", -(image_height + 30) + "px");
}
