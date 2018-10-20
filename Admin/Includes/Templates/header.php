<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8"/>
		<title><?php getTitle() ?></title>
		<link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css"/>
		<link rel="stylesheet" href="<?php echo $css;?>font-awesome.min.css"/>
		<link rel="stylesheet" href="<?php echo $css;?>jquery-ui.css"/>
		<link rel="stylesheet" href="<?php echo $css;?>jquery.selectBoxIt.css"/>
		<link rel="stylesheet" href="<?php echo $css;?>backend.css"/>
	</head>
	<body>
	<div class="upper-bar">
		<div class="container">

		<?php 
   			 $pageTitle = 'Login';
    
    		if (isset($_SESSION['user'])) {
      		  	echo 'Welcome ' . $_SESSION['user'] ;
  			 } else {

   		 ?>
			<a href="login.php">
				<span class="pull-right">Login/Signup</span>
			</a>
			<?php } ?>
		</div>
	</div>
	<nav class="navbar navbar-inverse">
 		<div class="container">
    		<div class="navbar-header">
     		 <button 
     		 		type="button" 
     		 		class="navbar-toggle collapsed" 
     		 		data-toggle="collapse" 
     		 		data-target="#app-nav" 
     		 		aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dashboard.php"><?php echo lang('Home_admin') ?></a>
    </div>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li><a href="categories.php"><?php echo lang('CATEGORIES') ?> </a></li>
        <li><a href="Items.php"><?php echo lang('ITEMS') ?> </a></li>
        <li><a href="members.php"><?php echo lang('MEMBERS') ?> </a></li>
        <li><a href="comments.php"><?php echo lang('COMMENTS') ?> </a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ABDElhamid <span class="caret"></span></a>
          <ul class="dropdown-menu">
          	<li><a href="../index.php">Visit Shop</a></li>
            <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>