const ctx = document.getElementById('graficoVentas').getContext('2d');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
    datasets: [{
      label: 'Ventas',
      data: [150, 200, 170, 220, 300, 400, 380],
      fill: true,
      borderColor: '#1fe4d4',
      backgroundColor: 'rgba(20, 213, 219, 0.2)',
      tension: 0.3
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        labels: { color: 'white' }
      }
    },
    scales: {
      x: { ticks: { color: 'white' } },
      y: { ticks: { color: 'white' } }
    }
  }
});
