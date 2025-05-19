<!-- partials/sidebar.php -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="../assets/css/style.css">

<div class="sidebar">
  <div class="sidebar-header text-center">  
    <i class="fas fa-user-shield fa-2x"></i>
      <span class="sidebar-title">Admin Panel</span>
  </div>
    <!-- <h4 class="text-center">Admin Panel</h4> -->
    <a href="../public/index.php"><i class="fas fa-chart-bar"></i> <span>Dashboard</span></a>
    <a href="../public/add-user.php"><i class="fas fa-user-plus"></i><span> Add User</span></a>
    <a href="../public/view.php"><i class="fas fa-users"></i><span> View Users</span></a>
    <a href="logout.php" class="btn btn-sm btn-danger"><span>Logout</span></a>
    <link rel="stylesheet" href="assets/css/style.css">

</div>

<script>
  const sidebar = document.querySelector('.sidebar');

  // Collapse on mouse leave
  sidebar.addEventListener('mouseenter', () => {
    sidebar.classList.remove('collapsed');
  });

  sidebar.addEventListener('mouseleave', () => {
    sidebar.classList.add('collapsed');
  });

  // Optional: toggle button for mobile
  const toggleBtn = document.createElement('button');
  toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
  toggleBtn.className = 'btn btn-dark d-md-none';
  toggleBtn.style.position = 'fixed';
  toggleBtn.style.top = '15px';
  toggleBtn.style.left = '15px';
  toggleBtn.style.zIndex = 1100;
  document.body.appendChild(toggleBtn);

  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('open');
  });
</script>
