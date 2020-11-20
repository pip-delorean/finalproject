import axios from 'axios';
import Chart from 'chart.js';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

var data = {
  labels: ['January', 'February', 'March'],
  datasets: [
    {
      data: [30, 122, 90]
    }
  ]
}


document.addEventListener("DOMContentLoaded", function() {
  var context = document.querySelector('#graph').getContext('2d');
  new Chart(context, {
    type: "line",
    data: data,
  })
});
