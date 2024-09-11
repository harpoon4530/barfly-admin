/**
* Theme: Zircos Dashboard
* Author: Coderthemes
* Chartist chart
*/



//Simple line chart
new Chartist.Line('#simple-line-chart', {
  labels: ['May', 'June', 'July', 'August',],
  series: [
    [12, 9, 7, 14,],
  ]
}, {
  fullWidth: true,
  chartPadding: {
    right: 40
  },
  plugins: [
    Chartist.plugins.tooltip()
  ]
});

//Label placement

new Chartist.Bar('#label-placement-chart', {
  labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
  series: [
    [6, 5, 6, 7, 5, 14, 11],
  ]
}, {
  axisX: {
    // On the x-axis start means top and end means bottom
    position: 'start'
  },
  axisY: {
    // On the y-axis start means left and end means right
    position: 'end'
  },
  plugins: [
    Chartist.plugins.tooltip()
  ]
});
