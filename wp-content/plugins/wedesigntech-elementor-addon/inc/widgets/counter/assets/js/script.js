(function ($) {

  const wdtCounterWidgetHandler = function($scope, $) {

    $scope.find('.wdt-content-counter-number').countTo();

  };

  $(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-counter.default', wdtCounterWidgetHandler);
  });

})(jQuery);
