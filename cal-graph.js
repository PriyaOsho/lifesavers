const graph = document.getElementById('calories-graph');

var calories_options = {
    scales: {
        x: {
          grid: {
            display: false
          }
        },
        y: {
          grid: {
            display: false
          }
        }
    },
    tooltips: {
        enabled: false
    },
    hover :{
        animationDuration:0
    },
    legend:{
        display:false
    },
    indexAxis: 'y',
    pointLabelFontFamily : "Quadon Extra Bold",
    scaleFontFamily : "Quadon Extra Bold",
};

let calNum = document.getElementById('calories').value;
Chart.defaults.font.size = 16;
Chart.defaults.color = "#ffffff";
new Chart(graph, {
    type: 'bar',
    data: {
        labels: ['Calories Eaten' , 'Target Calories'],
        datasets: [{
            label: 'Calories',
            data: [calNum, 2000],
            borderWidth: 1
        }]
    },
    options: calories_options,
});