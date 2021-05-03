if(window.attachEvent) {
    window.attachEvent('onload', createCharts);
} else {
    if(window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            createCHarts(evt);
        };
        window.onload = newonload;
    } else {
        window.onload = createCharts;
    }
}

function createCharts(){
    var chartElement = document.createElement('div');
    chartElement.className = "col-md-4";
    chartElement.id = "campus_vac_chart"

    var campusChart = LightweightCharts.createChart(chartElement, {
        width: 600,
    height: 300,
        layout: {
            fontFamily: 'Comic Sans MS',
        },
        rightPriceScale: {
            borderColor: 'rgba(197, 203, 206, 1)',
        },
        timeScale: {
            borderColor: 'rgba(197, 203, 206, 1)',
        },
    });
    var row1 = document.getElementById('row-1');
    row1.appendChild(chartElement);

    var areaSeries = campusChart.addAreaSeries({
    topColor: 'rgba(33, 150, 243, 0.56)',
    bottomColor: 'rgba(33, 150, 243, 0.04)',
    lineColor: 'rgba(33, 150, 243, 1)',
    lineWidth: 2,
    });

    areaSeries.setData([
    <?php echo $total_graph_data; ?>
    ]);
}