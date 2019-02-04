import * as Chart from 'chart.js';
import * as moment from 'moment';
import {fetch} from 'whatwg-fetch';

window['chartColors'] = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    blue: 'rgb(54, 162, 235)',
    purple: 'rgb(153, 102, 255)',
    grey: 'rgb(201, 203, 207)'
};

Array.prototype['randomize'] = function () {
    let currentIndex = this.length, temporaryValue, randomIndex;
    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = this[currentIndex];
        this[currentIndex] = this[randomIndex];
        this[randomIndex] = temporaryValue;
    }

    return this;
};

Chart.defaults.global.options= { responsive: true };

// @ts-ignore
const backgroundColor = Object.keys(window['chartColors']).randomize().map(color => window['chartColors'][color]);

const chartElement = {
    deviceRepartition: (<HTMLCanvasElement> document.getElementById("device-repartition-graph")).getContext("2d"),
    languageRepartition: (<HTMLCanvasElement> document.getElementById("lang-repartition-graph")).getContext("2d"),
    topUrl: (<HTMLCanvasElement> document.getElementById("top-url-graph")).getContext("2d"),
};
const charts = {
    deviceRepartition: null,
    languageRepartition: null,
    topUrl: null,
};

charts.deviceRepartition = new Chart(chartElement.deviceRepartition, {
    type: "pie",
    options: {
    },
    data: {
        labels: [],
        datasets: [{
            label: "Device repartition",
            data: [],
            backgroundColor
        }]
    }
});

charts.languageRepartition = new Chart(chartElement.languageRepartition, {
    type: "pie",
    options: {
    },
    data: {
        labels: [],
        datasets: [{
            label: "Device repartition",
            data: [],
            backgroundColor
        }]
    }
});

const timeFormat = 'MM/DD/YYYY HH:mm';
charts.topUrl = new Chart(chartElement.topUrl, {
    type: "line",
    options: {
        cubicInterpolationMode: 'monotone',
        scales: {
            yAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: 'Visit count'
                },
                stacked: true,
                ticks: {
                    beginAtZero: true
                }
            }],
            xAxes: [{
                type: 'time',
                time: {
                    parser: timeFormat,
                    round: 'hour',
                    tooltipFormat: 'll HH:mm'
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Time'
                }
            }],
        },
    },
    data: {
        labels: [],
        datasets: []
    }
});

async function loadDeviceRepresentation() {
    const rawData = await fetch("/chart/device-repartition.json").then(res => res.json()) as Object;
    Object.keys(rawData).forEach(device => {
        charts.deviceRepartition.data.labels.push(device);
        charts.deviceRepartition.data.datasets[0].data.push(rawData[device]);
    });
    charts.deviceRepartition.update();
}

async function loadLanguageRepresentation() {
    const rawData = await fetch("/chart/language-repartition.json").then(res => res.json()) as Object;
    Object.keys(rawData).forEach(lang => {
        charts.languageRepartition.data.labels.push(lang);
        charts.languageRepartition.data.datasets[0].data.push(rawData[lang]);
    });
    charts.languageRepartition.update();
}

async function loadTopURL() {
    const rawData = await fetch("/chart/top-url.json").then(res => res.json()) as Object;
    const sortedData = {};

    let urlIndexes = {};
    let urlIndex = 0;

    let dateIndexes = {};
    let dateIndex = 0;

    Object
        .keys(rawData)
        .sort((timeA, timeB) => {
            return moment(timeA, 'YYYY-M-D H') >= moment(timeB, 'YYYY-M-D H') ? 1 : -1;
        })
        .forEach(time => {
            sortedData[time] = rawData[time];
        });

    Object.keys(sortedData).forEach(time => {
        if (typeof dateIndexes[time] === 'undefined') {
            dateIndexes[time] = dateIndex;
            dateIndex++;
        }

        charts.topUrl.data.labels[dateIndexes[time]] = moment(time, 'YYYY-M-D H').toDate();

        Object.keys(sortedData[time]).forEach(url => {
            if (typeof urlIndexes[url] === 'undefined') {
                urlIndexes[url] = urlIndex;
                urlIndex++;
            }

            if (typeof charts.topUrl.data.datasets[urlIndexes[url]] === 'undefined') {
                charts.topUrl.data.datasets[urlIndexes[url]] = {
                    label: url,
                    backgroundColor: backgroundColor[urlIndex],
                    borderColor: backgroundColor[urlIndex],
                    data: [],
                    fill: false,
                };
            }

            charts.topUrl.data.datasets[urlIndexes[url]].data.push({
                x: moment(time, 'YYYY-M-D H').format(timeFormat),
                y: sortedData[time][url]
            });
        });


    });

    console.log(charts.topUrl.data);

    charts.topUrl.update();
}

loadDeviceRepresentation();
loadLanguageRepresentation();
loadTopURL();
