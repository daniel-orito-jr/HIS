var chart = {
    create_chart: function () {
        $.ajax({
            type: 'POST',
            url: BASE_URL + "user/create_chart",
            data: {},
            dataType: 'json'
        }).done(function (data) {
//            console.log(data);
            if (data.status) {
                var date = [];
                var census = [];


                for (var i in data.censusx) {
                    date.push(moment(data.censusx[i].datex).format('MM-DD'));
                    census.push(data.censusx[i].totalx);
                }

//                console.log(data.censusx[0].datex);

                var ctx = document.getElementById('myChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: date,
                        datasets: [{
                                label: "Census Flow",
                                fill: false,
                                borderColor: 'rgb(0, 204, 153)',
                                data: census
                            }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            yAxes:
                                    [
                                        {
                                            stacked: true,
                                            gridLines:
                                                    {
                                                        display: true,
                                                        color: "rgba(255,99,132,0.2)"
                                                    }
                                        }
                                    ],
                            xAxes:
                                    [
                                        {
                                            gridLines: {
                                                display: true
                                            }
                                        }
                                    ]
                        }
                    }
                });
            } else {
                console.log("fail to load chart");
            }
        });
    },

    monthly_census_chart: function () {
        $.ajax({
            type: 'POST',
            url: BASE_URL + "user/fetch_monthly_census",
            data: {},
            dataType: 'json'
        }).done(function (data) {
//            console.log(data);
            if (data.status) {
                var months = [];
                var census = [];
                var gynecology = [],
                        medical = [],
                        newBorn = [],
                        obstetrics = [],
                        others = [],
                        pediatrics = [],
                        surgery = [];
                var totalpx = 0;

                for (var i in data.censusm) {
                    months.push(data.censusm[i]['datex']);
                    totalpx = parseInt(data.censusm[i]['Gynecology']) +
                            parseInt(data.censusm[i]['Medical']) +
                            parseInt(data.censusm[i]['NewBorn']) +
                            parseInt(data.censusm[i]['Obstetrics']) +
                            parseInt(data.censusm[i]['Others']) +
                            parseInt(data.censusm[i]['Pediatrics']) +
                            parseInt(data.censusm[i]['Surgery']);
                    census.push(totalpx);
                    gynecology.push(parseInt(data.censusm[i]['Gynecology']));
                    medical.push(parseInt(data.censusm[i]['Medical']));
                    newBorn.push(parseInt(data.censusm[i]['NewBorn']));
                    obstetrics.push(parseInt(data.censusm[i]['Obstetrics']));
                    others.push(parseInt(data.censusm[i]['Others']));
                    pediatrics.push(parseInt(data.censusm[i]['Pediatrics']));
                    surgery.push(parseInt(data.censusm[i]['Surgery']));
                }


                var ctx = document.getElementById('myMChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'Total Census',
                                fill: false,
                                borderColor: 'rgb(128, 0, 0)',
                                data: census
                            },
                            {
                                label: 'Obstetrics',
                                fill: false,
                                borderColor: 'rgb(0, 204, 153)',
                                data: obstetrics,
                                hidden: true
                            },
                            {
                                label: 'New Born',
                                fill: false,
                                borderColor: 'rgb(0, 153, 51)',
                                data: newBorn,
                                hidden: true
                            },

                            {
                                label: 'Gynecology',
                                fill: false,
                                borderColor: 'rgb(255, 153, 51)',
                                data: gynecology,
                                hidden: true
                            },
                            {
                                label: 'Medical',
                                fill: false,
                                borderColor: 'rgb(51, 153, 255)',
                                data: medical,
                                hidden: true
                            },

                            {
                                label: 'Pediatrics',
                                fill: false,
                                borderColor: 'rgb(255, 102, 204)',
                                data: pediatrics,
                                hidden: true
                            },
                            {
                                label: 'Surgery',
                                fill: false,
                                borderColor: 'rgb(51, 204, 204)',
                                data: surgery,
                                hidden: true
                            },
                            {
                                label: 'Others',
                                fill: false,
                                borderColor: 'rgb(51, 153, 102)',
                                data: others,
                                hidden: true
                            }
                        ]
                    },
//                    options: {
//                        responsive: true,
//                        maintainAspectRatio: false,
//                        scales: {
//                            yAxes:
//                                    [
//                                        {
//                                            stacked: true,
//                                            gridLines:
//                                                    {
//                                                        display: true,
//                                                        color: "rgba(255,99,132,0.2)"
//                                                    }
//                                        }
//                                    ],
//                            xAxes:
//                                    [
//                                        {
//                                            gridLines: {
//                                                display: true
//                                            }
//                                        }
//                                    ]
//                        }
//                    }

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function (tooltipItem, chart) {
                                    return chart.datasets[tooltipItem.datasetIndex]["label"] + ': ' + tooltipItem.yLabel;
                                }
                            }
                        }
                    }
                });
            } else {
                console.log("fail to load 2nd chart");
            }
        });
    },

    proofsheet_chart: function () {

        $.ajax({
            type: 'POST',
            url: BASE_URL + "user/fetch_proofsheet_chart/" + 1,
            data: {
                start_date: $('#search-proofsheet-form input[name=start_date]').val(),
                end_date: $('#search-proofsheet-form input[name=end_date]').val()
            },
            dataType: 'json'
        }).done(function (data) {
//            console.log(data);
            if (data.status) {
                var date = [],
                        debit = [],
                        credit = [];

                for (var i = 0; i < data.proofx.length; i++) {
                    date.push(moment(data.proofx[i]["datex"]).format('ddd,MMM DD YYYY'));
                    debit.push(data.proofx[i]["debit"]);
                    credit.push(data.proofx[i]["credit"]);

                }

                var ctx = document.getElementById('myChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: date,
                        datasets: [
                            {
                                label: "Debit",
                                fill: false,
                                borderColor: 'rgb(128, 0, 0)',
                                data: debit
                            },
                            {
                                label: "Credit",
                                fill: false,
                                borderColor: 'rgb(0, 204, 153)',
                                data: credit
                            }

                        ]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function (tooltipItem, chart) {
                                    return chart.datasets[tooltipItem.datasetIndex]["label"] + ': ₱' + accounting.format(tooltipItem.yLabel, 2);
                                }
                            }
                        }
                    }
                });
//alert(data.proofx[0]['credit']);
            } else {
                console.log("fail to load 2nd chart");
            }
        });


    }

};




Chart.plugins.register({
    afterDatasetsDraw: function (chart) {
        if (chart.tooltip._active && chart.tooltip._active.length) {
            var activePoint = chart.tooltip._active[0],
                    ctx = chart.ctx,
                    y_axis = chart.scales['y-axis-0'],
                    x = activePoint.tooltipPosition().x,
                    topY = y_axis.top,
                    bottomY = y_axis.bottom;
            // draw line
            ctx.save();
            ctx.beginPath();
            ctx.moveTo(x, topY);
            ctx.lineTo(x, bottomY);
            ctx.lineWidth = 2;
            ctx.strokeStyle = '#07C';
            ctx.stroke();
            ctx.restore();
        }
    }
});
