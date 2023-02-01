function loadAndShow(){
    if (!openedSectionId){
        return;
    }
    let url = "/api/sections/?sectionId="+openedSectionId+"&history=true&dateFrom="+start.value.slice(6, 10)+"/"+start.value.slice(0, 2)+start.value.slice(2, 5)+"&dateTo="+end.value.slice(6, 10)+"/"+end.value.slice(0, 2)+end.value.slice(2, 5)
    const ms = Date.now();
    fetch(url+"&time="+ms, {cache: 'no-store'}).then(function(response) {
        return response.json();
    }).then(function(data) {
        console.log(data);
        let waterLevelData = []
        let UVData = []
        let tempData = []
        let humData = []
        let i=0;
        const humSeries = [];

        data.sensors.forEach((sensor)=>{
            switch (sensor.type){
                case "level":
                    waterLevelData = sensor.data;
                    break;
                case "uv":
                    UVData = sensor.data;
                    break;
                case "temp":
                    tempData = sensor.data;
                    break;
                case "humidity":
                    sensor.data.forEach(obj => {
                        obj["value"+i] = obj["value"];
                        delete obj["value"];
                    });
                    humData.push(sensor.data);
                    humSeries.push({
                        argumentField: 'time',
                        valueField: 'value'+i,
                        name: sensor.name
                    })
                    i++;
                    break;
            }
        })
        let mergedHumData = []
        humData.forEach((sensor)=>{
            mergedHumData = mergeObjects(sensor,mergedHumData);
        })

        function mergeObjects(array1,array2) {
            const result = [];
            for (const object1 of array1) {
                const object2 = array2.find(obj => obj.time === object1.time);
                if (object2) {
                    result.push({ ...object1, ...object2 });
                }else{
                    result.push({ ...object1});
                }
            }

            for (const object2 of array2) {
                const object1 = array1.find(obj => obj.time === object2.time);
                if (!object1) {
                    result.push(object2);
                }
            }
            return result;
        }

        console.log(mergedHumData)
        //LEVEL
        $(() => {
            function getText(item, text) {
                return `Hodnota: ${item} - ${text}`;
            }

            const series = [{
                argumentField: 'time',
                valueField: 'value',
                name: 'Water level'

            }];

            $('#levelChart').dxChart({
                palette: 'Harmony Light',
                dataSource: waterLevelData,
                commonSeriesSettings: {
                    point: {
                        size: 7,
                    },
                },
                series,
                valueAxis: {
                    name: 'value',
                    valueType: "numeric"
                },
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

            $('#levelRangeSelector').dxRangeSelector({
                size: {
                    height: 120,
                },
                margin: {
                    left: 10,
                },
                scale: {
                    minorTickCount: 1,
                },
                dataSource: waterLevelData,
                chart: {
                    series,
                    palette: 'Harmony Light',
                    valueAxis: {
                        name: 'value',
                        valueType: "numeric",
                        type: "logarithmic"
                    },
                },
                behavior: {
                    callValueChanged: 'onMoving',
                },
                onValueChanged(e) {
                    let zoomedChart = $('#levelChart').dxChart('instance');
                    zoomedChart.getArgumentAxis().visualRange(e.value);

                    let rangeLevel = DevExpress.viz.dxRangeSelector.getInstance($('#levelRangeSelector'));
                    let othersRange = [
                        DevExpress.viz.dxRangeSelector.getInstance($('#uvRangeSelector')),
                        DevExpress.viz.dxRangeSelector.getInstance($('#tempRangeSelector')),
                        DevExpress.viz.dxRangeSelector.getInstance($('#humRangeSelector')),
                    ]
                    othersRange.forEach((range)=>{
                        range.setValue(rangeLevel.getValue())
                    })
                },
            });
        });

        //UV
        $(() => {
            function getText(item, text) {
                return `Hodnota: ${item} - ${text}`;
            }

            const series = [{
                argumentField: 'time',
                valueField: 'value',
                name: 'UV index'

            }];

            $('#uvChart').dxChart({
                palette: 'Harmony Light',
                dataSource: UVData,
                commonSeriesSettings: {
                    point: {
                        size: 7,
                    },
                },
                series,
                valueAxis: {
                    name: 'value',
                    valueType: "numeric"
                },
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

            $('#uvRangeSelector').dxRangeSelector({
                size: {
                    height: 120,
                },
                margin: {
                    left: 10,
                },
                scale: {
                    minorTickCount: 1,
                },
                dataSource: UVData,
                chart: {
                    series,
                    palette: 'Harmony Light',
                    valueAxis: {
                        name: 'value',
                        valueType: "numeric",
                        type: "logarithmic"
                    },

                },
                behavior: {
                    callValueChanged: 'onMoving',
                },
                onValueChanged(e) {
                    let zoomedChart = $('#uvChart').dxChart('instance');
                    zoomedChart.getArgumentAxis().visualRange(e.value);

                    let rangeLevel = DevExpress.viz.dxRangeSelector.getInstance($('#uvRangeSelector'));
                    let othersRange = [
                        DevExpress.viz.dxRangeSelector.getInstance($('#levelRangeSelector')),
                        DevExpress.viz.dxRangeSelector.getInstance($('#tempRangeSelector')),
                        DevExpress.viz.dxRangeSelector.getInstance($('#humRangeSelector')),
                    ]
                    othersRange.forEach((range)=>{
                        range.setValue(rangeLevel.getValue())
                    })
                },
            });
        });
        //TEMP
        $(() => {
            function getText(item, text) {
                return `Hodnota: ${item} - ${text}`;
            }

            const series = [{
                argumentField: 'time',
                valueField: 'value',
                name: 'Teplota'

            }];

            $('#tempChart').dxChart({
                palette: 'Harmony Light',
                dataSource: tempData,
                commonSeriesSettings: {
                    point: {
                        size: 7,
                    },
                },
                series,
                valueAxis: {
                    name: 'value',
                    valueType: "numeric"
                },
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

            $('#tempRangeSelector').dxRangeSelector({
                size: {
                    height: 120,
                },
                margin: {
                    left: 10,
                },
                scale: {
                    minorTickCount: 1,
                },
                dataSource: tempData,
                chart: {
                    series,
                    palette: 'Harmony Light',
                    valueAxis: {
                        name: 'value',
                        valueType: "numeric",
                        type: "logarithmic"
                    },
                },
                behavior: {
                    callValueChanged: 'onMoving',
                },
                onValueChanged(e) {
                    let zoomedChart = $('#tempChart').dxChart('instance');
                    zoomedChart.getArgumentAxis().visualRange(e.value);

                    let rangeLevel = DevExpress.viz.dxRangeSelector.getInstance($('#tempRangeSelector'));
                    let othersRange = [
                        DevExpress.viz.dxRangeSelector.getInstance($('#levelRangeSelector')),
                        DevExpress.viz.dxRangeSelector.getInstance($('#uvRangeSelector')),
                        DevExpress.viz.dxRangeSelector.getInstance($('#humRangeSelector')),
                    ]
                    othersRange.forEach((range)=>{
                        range.setValue(rangeLevel.getValue())
                    })
                },
            });
        });
        //HUM
        $(() => {
            function getText(item, text) {
                return `Hodnota: ${item} - ${text}`;
            }

            const series = humSeries;

            $('#humChart').dxChart({
                palette: 'Harmony Light',
                dataSource: mergedHumData,
                commonSeriesSettings: {
                    point: {
                        size: 7,
                    },
                },
                series,
                valueAxis: {
                    name: 'value',
                    valueType: "numeric"
                },
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

            $('#humRangeSelector').dxRangeSelector({
                size: {
                    height: 120,
                },
                margin: {
                    left: 10,
                },
                scale: {
                    minorTickCount: 1,
                },
                dataSource: mergedHumData,
                chart: {
                    series,
                    palette: 'Harmony Light',
                    valueAxis: {
                        name: 'value',
                        valueType: "numeric",
                        type: "logarithmic"
                    },
                },
                behavior: {
                    callValueChanged: 'onMoving',
                },
                onValueChanged(e) {
                    let zoomedChart = $('#humChart').dxChart('instance');
                    zoomedChart.getArgumentAxis().visualRange(e.value);

                    let rangeLevel = DevExpress.viz.dxRangeSelector.getInstance($('#humRangeSelector'));
                    let othersRange = [
                        DevExpress.viz.dxRangeSelector.getInstance($('#levelRangeSelector')),
                        DevExpress.viz.dxRangeSelector.getInstance($('#uvRangeSelector')),
                        DevExpress.viz.dxRangeSelector.getInstance($('#tempRangeSelector')),
                    ]
                    othersRange.forEach((range)=>{
                        range.setValue(rangeLevel.getValue())
                    })
                },
            });
        });

    }).catch(function(e) {
        console.log(e)
    });
}