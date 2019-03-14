var Highcharts = require('highcharts');
global.Highcharts = Highcharts;
require('highcharts/modules/exporting')(Highcharts);
require('highcharts/highcharts-3d')(Highcharts);

$(document).ready(function() {
    Highcharts.chart('container', {
        chart: {
            type: 'scatter',
            zoomType: 'xy'
        },
        title: {
            text: 'Resonances groups'
        },
        subtitle: {
            text: 'Source: Smirnov, Dovgalev, Popova (2017)'
        },
        xAxis: {
            title: {
                enabled: true,
                text: 'Semi-major Axis'
            },
            startOnTick: true,
            endOnTick: true,
            showLastLabel: true
        },
        yAxis: {
            title: {
                text: 'Eccentricity'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 100,
            y: 70,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
            borderWidth: 1
        },
        plotOptions: {
            scatter: {
                marker: {
                    radius: 2,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    }
                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x} AU, {point.y}'
                }
            }
        },
        series: window.series
    });
});
