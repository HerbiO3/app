$(() => {
    function getText(item, text) {
        return `Hodnota: ${item} - ${text}`;
    }

    const series = [{
        argumentField: 'arg',
        valueField: 'y1',
    }, {
        argumentField: 'arg',
        valueField: 'y2',
    }];

    $('#zoomedChart').dxChart({
        palette: 'Harmony Light',
        dataSource: zoomingData,
        commonSeriesSettings: {
            point: {
                size: 7,
            },
        },
        series,
        tooltip: {
            enabled: true,
            customizeTooltip(arg) {
                return {
                    text: getText(arg.argument, arg.valueText),
                };
            },
        },
        legend: {
            visible: true,
        },
        onLegendClick: function (e) {
            var series = e.target;
            if (series.isVisible()) {
                series.hide();
            } else {
                series.show();
            }
        }
    });

    $('#rangeSelector').dxRangeSelector({
        size: {
            height: 120,
        },
        margin: {
            left: 10,
        },
        scale: {
            minorTickCount: 1,
        },
        dataSource: zoomingData,
        chart: {
            series,
            palette: 'Harmony Light',
        },
        behavior: {
            callValueChanged: 'onMoving',
        },
        onValueChanged(e) {
            let zoomedChart = $('#zoomedChart').dxChart('instance');
            zoomedChart.getArgumentAxis().visualRange(e.value);

            //zoomedChart = $('#zoomedChart2').dxChart('instance');
            //zoomedChart.getArgumentAxis().visualRange(e.value);
            let range = DevExpress.viz.dxRangeSelector.getInstance($('#rangeSelector'));
            let range2 = DevExpress.viz.dxRangeSelector.getInstance($('#rangeSelector2'));
            range2.setValue(range.getValue())
        },
    });
});



$(() => {
    const series = [{
        argumentField: 'arg',
        valueField: 'y3',
    }];

    $('#zoomedChart2').dxChart({
        palette: 'Harmony Light',
        dataSource: zoomingData,
        commonSeriesSettings: {
            point: {
                size: 7,
            },
        },
        series,
        legend: {
            visible: false,
        },
    });

    $('#rangeSelector2').dxRangeSelector({
        size: {
            height: 120,
        },
        margin: {
            left: 10,
        },
        scale: {
            minorTickCount: 1,
        },
        dataSource: zoomingData,
        chart: {
            series,
            palette: 'Harmony Light',
        },
        behavior: {
            callValueChanged: 'onMoving',
        },
        onValueChanged(e) {
            let zoomedChart = $('#zoomedChart2').dxChart('instance');
            zoomedChart.getArgumentAxis().visualRange(e.value);
            //zoomedChart = $('#zoomedChart').dxChart('instance');
            //zoomedChart.getArgumentAxis().visualRange(e.value);
            let range = DevExpress.viz.dxRangeSelector.getInstance($('#rangeSelector'));
            let range2 = DevExpress.viz.dxRangeSelector.getInstance($('#rangeSelector2'));
            range.setValue(range2.getValue())

        },
    });
});




const zoomingData = [
    {
        arg: 10, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 20, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 40, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 50, y1: -39, y2: 50, y3: 19,
    },
    {
        arg: 60, y1: -10, y2: 10, y3: 15,
    },
    {
        arg: 75, y1: 10, y2: 10, y3: 15,
    },
    {
        arg: 80, y1: 30, y2: 50, y3: 13,
    },
    {
        arg: 90, y1: 40, y2: 50, y3: 14,
    },
    {
        arg: 100, y1: 50, y2: 90, y3: 90,
    },
    {
        arg: 105, y1: 40, y2: 175, y3: 120,
    },
    {
        arg: 110, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 120, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 130, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 140, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 150, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 160, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 170, y1: -39, y2: 50, y3: 19,
    },
    {
        arg: 180, y1: -10, y2: 10, y3: 15,
    },
    {
        arg: 185, y1: 10, y2: 10, y3: 15,
    },
    {
        arg: 190, y1: 30, y2: 100, y3: 13,
    },
    {
        arg: 200, y1: 40, y2: 110, y3: 14,
    },
    {
        arg: 210, y1: 50, y2: 90, y3: 90,
    },
    {
        arg: 220, y1: 40, y2: 95, y3: 120,
    },
    {
        arg: 230, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 240, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 255, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 270, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 280, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 290, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 295, y1: -39, y2: 50, y3: 19,
    },
    {
        arg: 300, y1: -10, y2: 10, y3: 15,
    },
    {
        arg: 310, y1: 10, y2: 10, y3: 15,
    },
    {
        arg: 320, y1: 30, y2: 100, y3: 13,
    },
    {
        arg: 330, y1: 40, y2: 110, y3: 14,
    },
    {
        arg: 340, y1: 50, y2: 90, y3: 90,
    },
    {
        arg: 350, y1: 40, y2: 95, y3: 120,
    },
    {
        arg: 360, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 367, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 370, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 380, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 390, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 400, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 410, y1: -39, y2: 50, y3: 19,
    },
    {
        arg: 420, y1: -10, y2: 10, y3: 15,
    },
    {
        arg: 430, y1: 10, y2: 10, y3: 15,
    },
    {
        arg: 440, y1: 30, y2: 100, y3: 13,
    },
    {
        arg: 450, y1: 40, y2: 110, y3: 14,
    },
    {
        arg: 460, y1: 50, y2: 90, y3: 90,
    },
    {
        arg: 470, y1: 40, y2: 95, y3: 120,
    },
    {
        arg: 480, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 490, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 500, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 510, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 520, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 530, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 540, y1: -39, y2: 50, y3: 19,
    },
    {
        arg: 550, y1: -10, y2: 10, y3: 15,
    },
    {
        arg: 555, y1: 10, y2: 10, y3: 15,
    },
    {
        arg: 560, y1: 30, y2: 100, y3: 13,
    },
    {
        arg: 570, y1: 40, y2: 110, y3: 14,
    },
    {
        arg: 580, y1: 50, y2: 90, y3: 90,
    },
    {
        arg: 590, y1: 40, y2: 95, y3: 12,
    },
    {
        arg: 600, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 610, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 620, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 630, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 640, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 650, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 660, y1: -39, y2: 50, y3: 19,
    },
    {
        arg: 670, y1: -10, y2: 10, y3: 15,
    },
    {
        arg: 680, y1: 10, y2: 10, y3: 15,
    },
    {
        arg: 690, y1: 30, y2: 100, y3: 13,
    },
    {
        arg: 700, y1: 40, y2: 110, y3: 14,
    },
    {
        arg: 710, y1: 50, y2: 90, y3: 90,
    },
    {
        arg: 720, y1: 40, y2: 95, y3: 120,
    },
    {
        arg: 730, y1: 20, y2: 190, y3: 130,
    },
    {
        arg: 740, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 750, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 760, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 770, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 780, y1: -20, y2: 20, y3: 30,
    },
    {
        arg: 790, y1: -39, y2: 50, y3: 19,
    },
    {
        arg: 800, y1: -10, y2: 10, y3: 15,
    },
    {
        arg: 810, y1: 10, y2: 10, y3: 15,
    },
    {
        arg: 820, y1: 30, y2: 100, y3: 13,
    },
    {
        arg: 830, y1: 40, y2: 110, y3: 14,
    },
    {
        arg: 840, y1: 50, y2: 90, y3: 90,
    },
    {
        arg: 850, y1: 40, y2: 95, y3: 120,
    },
    {
        arg: 860, y1: -12, y2: 10, y3: 32,
    },
    {
        arg: 870, y1: -32, y2: 30, y3: 12,
    },
    {
        arg: 880, y1: -20, y2: 20, y3: 30,
    },
];
