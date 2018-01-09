<?php

ob_start();  // Output Buffering Start 

Session_start();

if (isset($_SESSION['Username'])) {
    
    $pageTitle = 'Dashboard';
    
    include 'Init.php';
    
    /* Start Dashboard Page */
    
     $numUsers = 6;  // Number Of Latest Users
     
     $latestUsers = getLatest("*", "users", "userID", $numUsers);  // Latest Users Array 
     
     $numItems = 6; // Number Of Latest Items
     
     $latestItems = getLatest("*", "items", "Item_ID", $numItems);  // Latest Items Array 
     
     $numComments = 4; // Number Of Comments
     
    
   
    ?>
    
    <div class="home-stats">
        <div class="container text-center">
          <h1>Dashboard</h1>
          <div class="row">
              <div class="col-md-3">
                  <div class="stat st-members">
                  	  <i class="fa fa-users"></i>
                      <div class="info">
                          Total Members
                          <span><a href="members.php"><?php echo CountItems('userID', 'users') ?></a></span>
                      </div>
                  </div>
              </div>
               <div class="col-md-3">
                  <div class="stat st-pending">
                      <i class="fa fa-user-plus"></i>
                      <div class="info">
                        Pending Members
                          <span><a href="members.php?do=Manage&page=Pending">
                          <?php echo checkItem("Regstatus", "users", 0) ?>
                          </a></span>
                      </div>                
                  </div>
              </div>
               <div class="col-md-3">
                  <div class="stat st-items">
                      <i class="fa fa-tag"></i>
                          <div class="info">
                          Total Items
                          <span><a href="Items.php"><?php echo CountItems('Item_ID', 'items') ?></a></span>
                          </div>
                  </div>
              </div>
               <div class="col-md-3">
                  <div class="stat st-comments">
                      <i class="fa fa-comments"></i>
                      <div class="info">
                      Total Comments
                      <span>
                      	  <a href="comments.php"><?php echo CountItems('C_id', 'comments') ?></a>
					  </span> 
                  	  </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
    
      <div class="latest">
          <div class="container">
              <div class="row">
                  <div class="col-sm-6">
    				  <div class="panel panel-default">
        				  <div class="panel-heading">
        				  		<i class="fa fa-users"></i> Letest <?php echo $numUsers ?> Registerd Users
        				  		<span class="toggle-info pull-right">
        				  			<i class="fa fa-plus fa-lg"></i>
        				  		</span>
        				  </div>
        				  <div class="panel-body">
        				  		<ul class="list-unstyled latest-users">
                    				  <?php 
                    				  if (! empty($latestUsers)) {
                        				  foreach ($latestUsers as $user) {
                            				      echo '<li>';
                            			     	      echo $user['Username'];
                            			     	      echo '<a href="members.php?do=Edit&userid=' . $user['userID'] . '">';
                                				          echo '<span class="btn btn-success pull-right">';
                                                               echo '<i class="fa fa-edit"></i> Edit';
                                                               if ($user['Regstatus'] == 0) {
                                                                   echo "<a href='members.php?do=Activate&userid=" . $user['userID'] . "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i> Activate</a>";
                                                               }
                                                          echo '</span>';
                                                      echo '</a>';
                                                  echo '</li>';
                            				  }
                    			 	  } else {
                    				      echo 'There\'s No Members To Show';
                    				  }
                    				  ?>
            			  		  </ul>
        				  </div>
    				  </div>              	
                  </div>
                   <div class="col-sm-6">
    				  <div class="panel panel-default">
        				  <div class="panel-heading">
        				  		<i class="fa fa-tag"></i> Letest <?php echo $numItems ?> Items 
            				  		<span class="toggle-info pull-right">
            				  			<i class="fa fa-plus fa-lg"></i>
            				  		</span>
        				  </div>
        				  <div class="panel-body">
								 <ul class="list-unstyled latest-users">
                    				  <?php 
                        				  if (! empty($latestItems)) {
                            				  foreach ($latestItems as $item) {
                                				      echo '<li>';
                                				          echo $item['Name'];
                                				          echo '<a href="Items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
                                    				          echo '<span class="btn btn-success pull-right">';
                                                                   echo '<i class="fa fa-edit"></i> Edit';
                                                                   if ($item['Approve'] == 0) {
                                                                       echo "<a href='Items.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i> Approve</a>";
                                                                   }
                                                              echo '</span>';
                                                          echo '</a>';
                                                      echo '</li>';
                                				  }
                        				  } else {
                        				      echo 'There\'s No Items To Show';
                        				  }
                    				  ?>
            			  		  </ul>
        				  </div>
    				  </div>              	
                  </div>
              </div>
      
              <!-- Start Latest Comments -->
              <div class="row">
                  <div class="col-sm-6">
    				  <div class="panel panel-default">
        				  <div class="panel-heading">
        				  		<i class="fa fa-comments-o"></i> 
        				  		Letest <?php echo $numComments ?> Comments 
        				  		<span class="toggle-info pull-right">
        				  			<i class="fa fa-plus fa-lg"></i>
        				  		</span>
        				  </div>
        				  <div class="panel-body">
            				  <?php 
                				  $Stmt = $con->prepare("SELECT
                                                        comments.*, users.Username AS Member
                                                   FROM
                                                       comments
                                                   INNER JOIN
                                                          users
                                                   ON
                                                        users.userID = comments.user_id
                                                   Order by 
                                                           C_id DESC
                                                   LIMIT $numComments");
    
                				  $Stmt->execute();
                				  $comments = $Stmt->fetchAll();
                				  if (! empty($comments)) {
                    				  foreach ($comments as $comment) {
                    				      
                    				      echo '<div class="comment-box">';
                    				          echo '<span class="member-n">
                                                    <a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
                                                    ' . $comment['Member'] . '</a></span>'; 
                    				          echo '<p class="member-c">' . $comment['Comment'] . '</p>';
                    				      echo '</div>';
                    				   }
                				  } else {
                				      echo 'There\'s No Comments To Show';
                				  }
            				  ?>

        				  </div>
    				  </div>              	
                  </div>
                </div>
                <!-- End Latest Comments -->
           </div>
      </div> 

    <?php
    /* End Dashboard Page */

    include $tpl . 'footer.php';
    
} else {
    
    header('location: index.php');
    exit();
}

ob_end_flush();

?>