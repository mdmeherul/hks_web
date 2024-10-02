(function ($) {

  const wdtChartWidgetHandler = function($scope, $) {

    const $chartItem = $scope.find('.wdt-chart-container');
    const $settings = $chartItem.data('chart-settings');
    const $moduleId = $('.'+$settings['moduleId']);

    const $deviceMode = elementorFrontend.getCurrentDeviceMode();

    console.log($deviceMode);
    console.log($settings.responsiveData);
    console.log($settings.responsiveData.legend_width[$deviceMode]);
    console.log($settings.responsiveData.legend_height[$deviceMode]);
    console.log($settings.responsiveData.legend_margin[$deviceMode]);
    $settings.chartLegend.labels.boxWidth = $settings.responsiveData.legend_width[$deviceMode];
    $settings.chartLegend.labels.boxHeight = $settings.responsiveData.legend_height[$deviceMode];
    $settings.chartLegend.labels.padding = $settings.responsiveData.legend_margin[$deviceMode];
    $settings.chartLegend.labels.font.size = $settings.responsiveData.legend_font_size[$deviceMode];

    const $config = {
      type:  $settings.chartType,
      data: $settings.chartData,
      options: {
        responsive: true,
        maintainAspectRatio: true,
        animation: $settings.chartAnimation,
        plugins: {
          legend: $settings.chartLegend,
          tooltip: $settings.chartTooltip,
        },
        cutout: $settings.chartCutoutPercentage
      }
    };

    console.log($config);

    const $wdtChart = new Chart( $moduleId, $config );

  };


  $(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/wdt-chart.default', wdtChartWidgetHandler);
  });

})(jQuery);
