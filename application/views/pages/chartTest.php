<!doctype html>
<html>

<head>
    <title>Line Chart</title>
    <script src="<?= base_url("assets/vendors/js/Chart.js"); ?>" ></script>
    <style>
    body {  
        background: #1D1F20;
        padding: 16px;
      }

      canvas {
        border: 1px dotted red;
      }

      .chart-container {
        position: relative;
        margin: auto;
        height: 80vh;
        width: 80vw;
      }

    </style>
</head>

<body>
    <div class="chart-container" style="position: relative; height:40vh; width:80vw">
        <canvas id="myChart"></canvas>
    </div>
</body>
<script>
    
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["1", "2", "3", "4", "5", 
            "6", "7","8","9","10",
            "11", "12", "13", "14", "15",
            "16", "17","18","19","20",
            "21", "22", "23", "24", "25",
            "26", "27","28","29","30"],
        datasets: [{
            label: "My First dataset",
            backgroundColor: 'transparent',
            borderColor: 'rgb(0, 204, 153)',
            data: [0, 10, 5, 2, 20, 30, 100,0, 10, 5, 2, 20, 30, 100,0, 10, 5, 2, 20, 30, 100,0, 10, 5, 2, 20, 30, 100,1,100]
        },
    {
            label: "My Second dataset",
            backgroundColor: 'transparent',
            borderColor: 'rgb(255, 99, 132)',
            data: [5, 4, 5, 2, 50, 30, 20,5, 4, 5, 2, 50, 30, 20,5, 4, 5, 2, 50, 30, 20,5, 4, 5, 2, 50, 30, 20,5,80]
        }]
    },

    // Configuration options go here
    options: {}
});
</script>

</html>
