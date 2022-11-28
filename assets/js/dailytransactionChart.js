var chart = {
    create_chart : function(){
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/create_chart",
            data: {},
            dataType: 'json'   
        }).done(function(data) {
            console.log(data);
            if (data.status) {
                var date = [];
                var census = [];
                
                for(var i in data.censusx) {
                    date.push(moment(data.censusx[i].datex).format('MM-DD'));
                    census.push(data.censusx[i].totalx);
                }
                
                console.log(data.censusx[0].datex);
                
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
                    responsive : true,
                     bezierCurve: false,
                    maintainAspectRatio: false,
                    onAnimationComplete: done,
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
    
    
    
    monthly_census_chart : function(){
        $.ajax({
            type: 'POST',
            url:  BASE_URL + "user/fetch_monthly_census",
            data: {},
            dataType: 'json'   
        }).done(function(data) {
            console.log(data);
            if (data.status) {
                var months = [];
                var census = [];
                
                for(var i in data.censusm) {
                    months.push(data.censusm[i].datex);
                    census.push(parseInt(data.censusm[i].totalpx));
                }
                
                var ctx = document.getElementById('myMChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: months.reverse(),
                        datasets: [{
                            label: "Census Flow",
                            fill: false,
                            borderColor: 'rgb(0, 204, 153)',
                            data: census.reverse()
                        }]
                    },
                    options: {
                    responsive : true,
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
                console.log("fail to load 2nd chart");
            }
        });
    }
};

Chart.plugins.register({
   afterDatasetsDraw: function(chart) {
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



