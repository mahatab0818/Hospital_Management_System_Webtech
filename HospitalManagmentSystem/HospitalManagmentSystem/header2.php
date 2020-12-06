<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">American Hospital</a>
    </div>
	
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="patient.php">Patient</a></li>
      <li><a href="channel.php">Create Channel</a></li>
      <li><a href="view_channel.php">View Channel</a></li>
      <li><a href="view_press.php">View Prescription</a></li>
      <li><a href="user.php">Add User</a></li>
      

    </ul>
	
	<ul class="nav navbar-nav navbar-right">
	<li><a href="#"><span class="glyphicon glyphicon-user"> <?php echo $_SESSION['uname']; ?></span></a></li>
	<li><a href="logout.php"><span class="glyphicon glyphicon-user"></span>Log Out</a></li>
     
    </ul>
  </div>
</nav>