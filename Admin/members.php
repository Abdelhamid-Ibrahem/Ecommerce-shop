<?php

/*
*********************************************************************************************
                                   ** Manage Members Page 
                      ** You Can Add | Edit | Delete Members Form Here 
*********************************************************************************************
*/
ob_start();  // Output Buffering Start 

Session_start();

$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {
    
    include 'Init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    // Start Manage Page 
    
    if ($do == 'Manage') { // Manage Members Page 
        
        $Query = '';
        
        if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
            
            $Query = 'AND Regstatus = 0';
        }
        
        // Select All Users Except Admin 
        
        $Stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $Query ORDER BY userID DESC");
        
        
        // Execute The Statement 
        
        $Stmt->execute();
        
        // Assign To Variable
        
        $rows = $Stmt->fetchAll();
        
        if (!empty($rows)) {
        
    ?>
    
      <h1 class="text-center">Manage Members</h1>
      <div class="container">
             <div class="table-responsive">
                  <table class="main-table text-center table table-bordered">
                  <tr>
                      <td>#ID</td>
                      <td>Username</td>
                      <td>Email</td>
                      <td>Full Name</td>
                      <td>Registerd Date</td>
                      <td>Control</td>                  
                  </tr>
                  <?php 
                  foreach ($rows as $row) {
                      echo "<tr>";
                             echo "<td>" . $row['userID'] . "</td>";
                             echo "<td>" . $row['Username'] . "</td>";
                             echo "<td>" . $row['Email'] . "</td>";
                             echo "<td>" . $row['Fullname'] . "</td>";
                             echo "<td>"  . $row['Date'] . "</td>";
                             echo "<td>
                                  <a href='members.php?do=Edit&userid=" . $row['userID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                  <a href='members.php?do=Delete&userid=" . $row['userID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                 if ($row['Regstatus'] == 0) {
                                   echo "<a href='members.php?do=Activate&userid=" . $row['userID'] . "' class='btn btn-info activate'><i class='fa fa-check'></i> Activate</a>";
                                 }
                                  echo "</td>";
                      echo "</tr>";
                  }
                  
                  ?>
                  <tr>
                    
                  </tr>
                  </table>
             </div>
             <a href="members.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New Member </a>
       </div>>
       
       <?php } else {
             echo  '<div class="container">';
                echo '<div class="nice-message">There\'s No Members To Show</div>';
                echo '<a href="members.php?do=Add" class="btn btn-sm btn-primary">
                     <i class="fa fa-plus"></i> New Member
                     </a>';
             echo '</div>';
    
        }?>

   <?php } elseif ($do == 'Add') { // Add Members Page?>
     
          <h1 class="text-center">Add New Member</h1>
          <div class="container">
              <form class="form-horizontal" action="?do=Insert" method="post" >    
                   <!-- Start Username Field -->
                   <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-5">
                       		 <input type="text" name="username" class="form-control" autocomplete="off" 
                       		 required="required" placeholder="Username To Login Into Shop"/>
                        </div>
                   </div>
                   <!-- End Username Field -->
                   <!-- Start Password Field -->
                   <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-5">
                             <input type="Password" name="Password" class="password form-control" autocomplete="new-password" 
                             required="required" placeholder="Password Must Be Hard & Complex"/>
                             <i class="show-pass fa fa-eye fa-2x"></i>
                        </div>
                    </div>
                    <!-- End Password Field -->
                    <!-- Start Email Field -->
                    <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">Email</label>
                         <div class="col-sm-10 col-md-5">
                              <input type="Email" name="Email" class="form-control" required="required" placeholder="Email Must Be Valid"/>
                         </div>
                    </div>
                    <!-- End Email Field -->
                    <!-- Start Full Name Field -->
                    <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">Full Name</label>
                         <div class="col-sm-10 col-md-5">
                              <input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page" />
                         </div>
                    </div>
                    <!-- End Full Name Field -->
                    <!-- Start submit Field -->
                    <div class="form-group form-group-lg">
                         <div class="col-sm-offset-2 col-sm-10">
                              <input type="submit" Value="Add Member" class="btn btn-primary btn-lg" />
                         </div>
                    </div>
                    <!-- End submit Field -->
              </form>
         </div>
  <?php
  
    } elseif ($do == 'Insert') { // Insert Member Page 
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
        
           echo  "<h1 class='text-center'>Insert Member</h1>";
           echo  "<div class='container'>";
        
             
                // Get Variables From The Form
               
                $user   = $_POST['username'];
                $pass   = $_POST['Password'];
                $email  = $_POST['Email'];
                $name   = $_POST['full'];
                
                $hashPass = sha1($_POST['Password']);
                
                // Validate The Form
                
                $formErrors = array();
                
                if (strlen($user) < 4) {
                    
                    $formErrors[] = 'Username Cant Be Less Than <strong> 4 Characters </strong> ';
                    
                }
                if (strlen($user) > 20) {
                    $formErrors[] = 'Username Cant Be More Than <strong> 20 Characters </strong>';
                    
                }
                
                if (empty($user)) {
                    
                    $formErrors[] = 'Username Can\'t Be <strong> Empty </strong>';
                }
                if (empty($pass)) {
                    
                    $formErrors[] = 'Password Can\'t Be <strong> Empty </strong>';
                }
                if (empty($name)) {
                    
                    $formErrors[] = 'Full Name Can\'t Be <strong> Empty </strong>';
                }
                if (empty($email)) {
                    
                    $formErrors[] = 'Email Can\'t Be <strong> Empty </strong>';
                }
                
                // Loop Into Errors Array And Echo It
                
                foreach ($formErrors as $error) {
                    
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
                
                // Check If There's No Error Proceed The Update Operation
                
                if (empty($formErrors)) {
                    
                    // Check If User Exist In Datebase
                    
                    
                    $check = checkItem("Username", "users", $user);
                    
                    if ($check == 1) {
                        
                        $theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
                        redirectHome($theMsg, 'back');
                    } else {
                        
                           
                        // Insert UserInfo In Database
                        
                        $Stmt = $con->prepare("Insert Into 
                                                  users(Username, password, Email, Fullname, Regstatus, Date)
                                                  Values(:zuser, :zpass, :zmail, :zname, 1, now() )");
                        
                       $Stmt->execute(array(
                           
                           'zuser' => $user,
                           'zpass' => $hashPass,
                           'zmail' => $email,
                           'zname' => $name
                       ));
                        
                        // Echo Success Message
                        
                       $theMsg = "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Inserted </div>';
                        redirectHome($theMsg, 'back');
                    }
                }
                
            }else {
                
                echo "<div class='container'>";
                
                $theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly</div>';
                
                redirectHome($theMsg);
                
                echo "</div>";
            }
            
            echo "</div>";
         
         } elseif ($do == 'Edit') {  // Edit Page 
        
        // Check If Get Request userid Is Numeric & Get The Integer Value Of It 
    
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        
        // Select All Data Depend On This ID 
        
        $Stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        
        // Execute Query 
        
        $Stmt->execute(array($userid));
        
        // Fetch The Data 
        
        $row = $Stmt->fetch();
        
        // The Row Count 
        
        $Count = $Stmt->rowCount();
        
        // If There's Such ID Show The Form 
        
        if ($Count > 0)   {  ?>
        
                  <h1 class="text-center">Edit Member</h1>
                 <div class="container">
                 <form class="form-horizontal" action="?do=Update" method="post" >
                        <input type="hidden" name="userid" value="<?php echo $userid ?>" />
                        
                        <!-- Start Username Field -->
                        <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">Username</label>
                         <div class="col-sm-10 col-md-5">
                         <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required" />
                         </div>
                  </div>
                       <!-- End Username Field -->
                       <!-- Start Password Field -->
                  <div class="form-group form-group-lg">
                           <label class="col-sm-2 control-label">Password</label>
                           <div class="col-sm-10 col-md-5">
                           <input type="hidden" name="oldPassword" value="<?php echo $row['password'] ?>" />
                           <input type="Password" name="newPassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont want To Change"/>
                           </div>
                  </div>
                          <!-- End Password Field -->
                          <!-- Start Email Field -->
                  <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-5">
                            <input type="Email" name="Email" value="<?php echo $row['Email'] ?>" class="form-control" required="required" />
                          </div>
                   </div>
                         <!-- End Email Field -->
                          <!-- Start Full Name Field -->
                   <div class="form-group form-group-lg">
                              <label class="col-sm-2 control-label">Full Name</label>
                             <div class="col-sm-10 col-md-5">
                             <input type="text" name="full" value="<?php echo $row['Fullname'] ?>" class="form-control" required="required" />
                             </div>
                   </div>
                          <!-- End Full Name Field -->
                          <!-- Start submit Field -->
                   <div class="form-group form-group-lg">
                           <div class="col-sm-offset-2 col-sm-10">
                          <input type="submit" Value="Save" class="btn btn-primary btn-lg" />
                          </div>
                  </div>
                         <!-- End submit Field -->
                  </form>
                 </div>
<?php 

       // If There's No Such ID Show Error Message

        } else {
            echo "<div class='container'>";
            
           $theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';
           
            redirectHome($theMsg);
            
            echo "</div>";
      
        }
    } elseif ($do == 'Update') {   // Update Page 
        
      echo  "<h1 class='text-center'>Update Member</h1>";
      echo  "<div class='container'>";
      
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
          // Get Variables From The Form 
          
          $id     = $_POST['userid'];
          $user   = $_POST['username'];
          $email  = $_POST['Email'];
          $name   = $_POST['full'];
          
           // Password Trick
           
           // Condition ? True : False;
           
          $pass = empty($_POST['newPassword']) ? $_POST['oldPassword'] :  $pass = sha1($_POST['newPassword']);
          
           // Validate The Form 
           
          $formErrors = array();
          
          if (strlen($user) < 4) {
              
              $formErrors[] = 'Username Cant Be Less Than <strong> 4 Characters </strong>';
              
          }
          if (strlen($user) > 20) {
              $formErrors[] = 'Username Cant Be More Than <strong> 20 Characters </strong>';
              
          }
          
          if (empty($user)) {
              
              $formErrors[] = 'Username Cant Be <strong> Empty </strong>';
          }
          if (empty($name)) {
              
              $formErrors[] = 'Full Name Cant Be <strong> Empty </strong>';
          }
          if (empty($email)) {
              
              $formErrors[] = 'Email Cant Be <strong> Empty </strong>';
          }
          
          // Loop Into Errors Array And Echo It
          
          foreach ($formErrors as $error) {
              
              echo '<div class="alert alert-danger">' . $error . '</div>';
              
          }
          
           // Check If There's No Error Proceed The Update Operation 
           
          if (empty($formErrors)) {
              
              $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND userID != ?");
              
              $stmt2->execute(array($user, $id));
              $count = $stmt2->rowCount();
              
              if ($count == 1) {
                  
                  $theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
                  
                  redirectHome($theMsg, 'back');
                  
              } else {
                  
                  // Update The Datebase With This Info
                  
                  $Stmt = $con->prepare(" UPDATE users SET Username = ?, Email = ?, FullName = ?, password = ? WHERE userID = ?");
                  $Stmt->execute(array($user, $email, $name, $pass, $id));
                  
                  // Echo Success Message
                  
                  $theMsg =  "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Updated </div>';
                  
                  redirectHome($theMsg, 'back');
              }
           
          }
        
      }else {
          
          $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
          
          redirectHome($theMsg);
      }
     
      echo "</div>";
        
    } elseif ($do == 'Delete'){  // Delete Member Page 
        
        echo  "<h1 class='text-center'>Delete Member</h1>";
        echo  "<div class='container'>";
        
            // Check If Get Request userid Is Numeric & Get The Integer Value Of It
            
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
            
            // Select All Data Depend On This ID

            $check = checkItem('userid', 'users', $userid );
            
            if ($check  > 0)   {  
                
               $Stmt = $con->prepare("DELETE FROM users WHERE userID = :zuser");
               
               $Stmt->bindParam(":zuser", $userid);
               
               $Stmt->execute();
                   
                  $theMsg = "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Deleted </div>';
                  
                  redirectHome($theMsg, 'back');
               
            } else {
                
               $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
               
                redirectHome($theMsg);
            }
              echo '</div>';
              
    } elseif ($do == 'Activate') {
        
        echo  "<h1 class='text-center'>Activate Member</h1>";
        echo  "<div class='container'>";
        
        // Check If Get Request userid Is Numeric & Get The Integer Value Of It
        
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
        
        // Select All Data Depend On This ID
        
        $check = checkItem('userid', 'users', $userid );
        
        if ($check  > 0)   {
            
            $Stmt = $con->prepare("Update users Set Regstatus = 1 WHERE userID = ?");
            
            $Stmt->execute(array($userid));
            
            $theMsg = "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Updated </div>';
            
            redirectHome($theMsg);
            
        } else {
            
            $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
            
            redirectHome($theMsg);
        }
        echo '</div>';
        
        
    }
    
    include $tpl . 'footer.php';
    
 } else {
    
    header('location: index.php');
    exit();
}
 
ob_end_flush();  // Release The Output

?>