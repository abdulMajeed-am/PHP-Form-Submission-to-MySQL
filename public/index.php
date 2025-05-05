<?php
require_once '../partials/header.php';
require_once '../partials/sidebar.php';
?>

<div class="content">
  <h2 class="mb-4">Dashboard</h2>
  <div class="row">
    <div class="chart-card col-md-6">
      <h5 class="text-center">Bar Chart: Users Registered Daily</h5>
      <canvas id="barChart"></canvas>
    </div>
    <div class="chart-card col-md-6">
      <h5 class="text-center">Pie Chart: Users Registered Share</h5>
      <canvas id="pieChart"></canvas>
    </div>
  </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="assets/css/style.css">


<script>
fetch('../charts/chart-data.php')
  .then(response => response.json())
  .then(data => {
    // ✅ Bar Chart (Corrected data path)
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: data.bar.labels,
        datasets: [{
          label: 'Users Registered (daily)',
          data: data.bar.counts,
          backgroundColor: '#007bff'
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: { beginAtZero: true }
        }
      }
    });

    // ✅ Pie Chart (already correct)
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: data.pie.labels,
        datasets: [{
          data: data.pie.counts,
          backgroundColor: [
            '#007bff', '#28a745', '#dc3545', '#ffc107',
            '#17a2b8', '#6610f2', '#fd7e14', '#20c997', '#e83e8c'
          ]
        }]
      },
      options: {
        responsive: true
      }
    });
  });
</script>

</body>
</html>
