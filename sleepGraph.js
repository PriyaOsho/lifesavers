const graph = document.getElementById('sleepTrack');

var sleep_options = {
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

new Chart(graph, {
    type: 'bar',
    data: {
        labels: ['Amount slept' , 'Target Sleep'],
        datasets: [{
            label: 'Sleep',
            data: [0, 10],
            borderWidth: 1
        }]
    },
    options: sleep_options,
});