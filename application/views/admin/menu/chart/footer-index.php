<script type="text/javascript">
  'use strict';

  var ctx = document.getElementById('topLogin').getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'],
      datasets: [{
        label: 'Google',
        data: [290, 358, 220, 402, 690],
        borderWidth: 2,
        backgroundColor: 'transparent',
        borderColor: 'rgba(254,86,83,.7)',
        borderWidth: 2.5,
        pointBackgroundColor: 'transparent',
        pointBorderColor: 'transparent',
        pointRadius: 4
      },
      {
        label: 'Facebook',
        data: [450, 258, 390, 162, 440],
        borderWidth: 2,
        backgroundColor: 'transparent',
        borderColor: 'rgba(63,82,227,.8)',
        borderWidth: 0,
        pointBackgroundColor: 'transparent',
        pointBorderColor: 'transparent',
        pointRadius: 4
      },
      {
        label: 'Gitar',
        data: [40, 300, 390, 140, 420],
        borderWidth: 2,
        backgroundColor: 'transparent',
        borderColor: 'rgba(207,97,232,1)',
        borderWidth: 0,
        pointBackgroundColor: 'transparent',
        pointBorderColor: 'transparent',
        pointRadius: 4
      },
      ]
    },
    options: {
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          gridLines: {
            drawBorder: false,
            color: '#f2f2f2',
          },
          ticks: {
            beginAtZero: true,
            stepSize: 200
          }
        }],
        xAxes: [{
          gridLines: {
            display: false
          }
        }]
      },
    }
  });
</script>