import {chart} from 'highcharts';
import * as moment from 'moment';
import {fetch} from 'whatwg-fetch';

const chartElement = {
    deviceRepartition: (<HTMLDivElement> document.getElementById("device-repartition-graph")),
    languageRepartition: (<HTMLDivElement> document.getElementById("lang-repartition-graph")),
    topUrl: (<HTMLDivElement> document.getElementById("top-url-graph")),
};
const charts = {
    deviceRepartition: null,
    languageRepartition: null,
    topUrl: null,
};

charts.deviceRepartition = chart(chartElement.deviceRepartition, {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
    },
    credits: {
        enabled: false
    },
    title: {
        text: 'Device repartition'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
            }
        }
    },
    series: [ <any> {
        name: 'Type',
        colorByPoint: true,
        data: []
    }]
});

(async function loadDeviceRepresentation() {
    const rawData = await fetch("/chart/device-repartition.json").then(res => res.json()) as any;
    const series = charts.deviceRepartition.series[0];
    Object.keys(rawData).forEach(device => {
        series.addPoint({
            name: device,
            y: rawData[device]
        });
    });
})();

charts.languageRepartition = chart(chartElement.languageRepartition, {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
    },
    credits: {
        enabled: false
    },
    title: {
        text: 'Language repartition'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
            }
        }
    },
    series: [ <any> {
        name: 'Type',
        colorByPoint: true,
        data: []
    }]
});

(async function loadLanguageRepresentation() {
    const rawData = await fetch("/chart/language-repartition.json").then(res => res.json()) as any;
    const series = charts.languageRepartition.series[0];
    Object.keys(rawData).forEach(device => {
        series.addPoint({
            name: device,
            y: rawData[device]
        });
    });
})();

(async function loadTopURL() {
    const rawData = await fetch("/chart/top-url.json").then(res => res.json()) as any;
    const series = {};
    const opts: any = {
        credits: {
            enabled: false
        },
        title: {
            text: 'Top 10 URL'
        },
        xAxis: {
            type: 'datetime'
        },
        yAxis: {
            title: {
                text: 'Hit count'
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
            }
        }
    };

    Object.keys(rawData).forEach(page => {

        series[page] = {
            type: 'column',
            name: page,
            data: []
        };

        Object.keys(rawData[page])
            .sort((timeA, timeB) => {
                return moment(timeA, 'YYYY-M-D H') >= moment(timeB, 'YYYY-M-D H') ? 1 : -1;
            })
            .forEach(time => {
                const timestamp = moment(time, 'YYYY-M-D H').unix() * 1000;

                series[page].data.push({
                    x: timestamp,
                    y: rawData[page][time]
                });
            });
    });

    opts.series = Object.keys(series).map(serial => series[serial]);

    charts.topUrl = chart(chartElement.topUrl, opts);
})();
