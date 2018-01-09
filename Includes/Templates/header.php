
<!DOCTYPE html>
<html>
	<head>
        <meta charset="utf-8"/>
        <title><?php getTitle() ?></title>
        <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo $css;?>font-awesome.min.css"/>
        <link rel="stylesheet" href="<?php echo $css;?>jquery-ui.css"/>
        <link rel="stylesheet" href="<?php echo $css;?>jquery.selectBoxIt.css"/>
        <link rel="stylesheet" href="<?php echo $css;?>Forntend.css"/>
    </head>
    <body>
    <div class="upper-bar">
    	<div class="container">
    	
            <?php 
                if (isset($_SESSION['user'])) {
                    echo 'Wlecome ' . $_SESSION['user'] ;  
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
        <div class="navbar-header ">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Homepage</a>
        </div>
        <div class="collapse navbar-collapse" id="app-nav">
          <ul class="nav navbar-nav navbar-right">
		  <?php 
		  foreach (getCat() as $cat) {
		      echo '<li><a href="categories.php?pageid=' . $cat['ID'] . '&pagename=' . str_replace(' ', '-', $cat['Name']) . '">' . $cat['Name'] . '</a></li>';
		  }
		  ?>
          </ul>
        
        </div>
      </div>
    </nav>