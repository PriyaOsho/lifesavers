<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Exercise Graph</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/Chart.min.js"></script>


</head>
<body>
    <div class="navbar">
        <a href="/CSE442-542/2023-Spring/cse-442r/homepage.php">Lifesavers</a>
        <a href="/CSE442-542/2023-Spring/cse-442r/Login/login.php" class="logout">Log Out</a>
        <a href="/CSE442-542/2023-Spring/cse-442r/sleep.html" class="btn">Sleep</a>
        <a href="/CSE442-542/2023-Spring/cse-442r/Exercise/exercise.php" class="btn"><b>Exercise</b></a>
        <a href="/CSE442-542/2023-Spring/cse-442r/Food/food.php" class="btn">Nutrition</a>
        <a href="/CSE442-542/2023-Spring/cse-442r/UserInfoTesting/user_display.php" class="btn">Tracked Info</a>
    </div>

    <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph();
        });


        function showGraph()
        {
            {
                $.post("graph_select.php",
                function (data)
                {
                    console.log(data);
                    var calories_burnt = [];
                    var duration = [];
                    var heart_rate = [];

                    for (var i in data) {
                        duration.push(data[i].duration);
                        heart_rate.push(data[i].heart_rate)
                        calories_burnt.push(data[i].calories_burnt)
                    }

                    var chartdata = {
                        labels: duration,
                        datasets: [
                            {
                                label: 'Exercise Durations',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: duration
                            },
                            {
                                label: 'Exercise Heart Rate',
                                backgroundColor: '#de4545',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: heart_rate 
                            },
                            {
                                label: 'Exercise Calories Burnt',
                                backgroundColor: '#227d4b',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: calories_burnt
                            }
                        ]
                    };


                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
        </script>

</body>
</html>