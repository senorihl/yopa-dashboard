import * as Highcharts from 'highcharts';
import {fetch} from 'whatwg-fetch';

const chartElement = {
    deviceRepartition: document.getElementById("device-repartition-graph")
};
const charts = {
    deviceRepartition: null
};

charts.deviceRepartition = Highcharts.chart("device-repartition-graph", {
    title: {
        text: "Device repartition"
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    series: [{
        // @ts-ignore
        name: "Repartition",
        // @ts-ignore
        type: "pie",
        // @ts-ignore
        data: [] as Highcharts.SeriesPieDataOptions
    }]
});

async function loadDeviceRepresentation() {
    const rawData = await fetch("/chart/device-repartition.json").then(res => res.json()) as Object;
    Object.keys(rawData).forEach(device => {
        charts.deviceRepartition.series[0].addPoint({ name: device, y: rawData[device] });
    });
}

loadDeviceRepresentation();
