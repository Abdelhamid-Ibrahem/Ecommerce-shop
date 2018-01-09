<?php


/*
 *********************************************************************************************
 ** Manage Comments Page
 ** You Can Add | Edit | Delete | Approve Comments Form Here
 *********************************************************************************************
 */
ob_start();  // Output Buffering Start

Session_start();

$pageTitle = 'Comments';

if (isset($_SESSION['Username'])) {
    
    include 'Init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    // Start Manage Page
    
    if ($do == 'Manage') { // Manage Comment Page
        
        // Select All Users Except Admin
        
        $Stmt = $con->prepare("SELECT
                                    comments.*, items.Name AS Item_Name, users.Username AS Member
                               FROM 
                                   comments
                               INNER JOIN
                                    items
                               ON
                                    items.Item_ID = comments.Item_id
                               INNER JOIN
                                      users
                               ON
                                    users.userID = comments.user_id
                                Order by 
                                    C_id DESC");
        
        
        // Execute The Statement
        
        $Stmt->execute();
        
        // Assign To Variable
        
        $comments = $Stmt->fetchAll();
        
        if (! empty($comments)) {
            
        ?>
              <h1 class="text-center">Manage Comments</h1>
              <div class="container">
                     <div class="table-responsive">
                          <table class="main-table text-center table table-bordered">
                          <tr>
                              <td>#ID</td>
                              <td>Comment</td>
                              <td>Item Name</td>
                              <td>User Name</td>
                              <td>Added Date</td>
                              <td>Control</td>                  
                          </tr>
                          <?php 
                          foreach ($comments as $comment) {
                                          echo "<tr>";
                                          echo "<td>" . $comment['C_id'] . "</td>";
                                          echo "<td>" . $comment['Comment'] . "</td>";
                                          echo "<td>" . $comment['Item_Name'] . "</td>";
                                          echo "<td>" . $comment['Member'] . "</td>";
                                          echo "<td>" . $comment['Comment_Date'] . "</td>";
                                     echo "<td>
                                          <a href='comments.php?do=Edit&comid=" . $comment['C_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                          <a href='comments.php?do=Delete&comid=" . $comment['C_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                     if ($comment['Status'] == 0) {
                                         echo "<a href='comments.php?do=Approve&comid=" . $comment['C_id'] . "' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
                                         }
                                          echo "</td>";
                              echo "</tr>";
                          }
                          
                          ?>
                          <tr>  
                          </tr>
                          </table>
                     </div>
               </div>>
            <?php } else {
             echo  '<div class="container">';
                echo '<div class="nice-message">There\'s No Comments To Show</div>';
             echo '</div>';
    
        }?>
<?php 
         } elseif ($do == 'Edit') {  // Edit Page 
        
       // Check If Get Request comid Is Numeric & Get The Integer Value Of It 
    
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        
        // Select All Data Depend On This ID 
        
        $Stmt = $con->prepare("SELECT * FROM comments WHERE C_id = ? ");
        
        // Execute Query 
        
        $Stmt->execute(array($comid));
        
        // Fetch The Data 
        
        $row = $Stmt->fetch();
        
        // The Row Count 
        
        $Count = $Stmt->rowCount();
        
        // If There's Such ID Show The Form 
        
        if ($Count > 0)   {  ?>
        
                  <h1 class="text-center">Edit Comment</h1>
                 <div class="container">
                 <form class="form-horizontal" action="?do=Update" method="post" >
                        <input type="hidden" name="comid" value="<?php echo $comid ?>" />
                        
                        <!-- Start Comment Field -->
                        <div class="form-group form-group-lg">
                         <label class="col-sm-2 control-label">Comment</label>
                         <div class="col-sm-10 col-md-5">
                         	<textarea class="form-control" name="comment"><?php echo $row['Comment']?></textarea>
                         </div>
                  </div>
                       <!-- End Comment Field -->
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
        
      echo  "<h1 class='text-center'>Update Comment</h1>";
      echo  "<div class='container'>";
      
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
       
          // Get Variables From The Form 
          
          $comid     = $_POST['comid'];
          $comment   = $_POST['comment'];
          
              
          // Update The Datebase With This Info
          
          $Stmt = $con->prepare(" UPDATE comments SET Comment = ? WHERE C_id = ?");
          $Stmt->execute(array($comment, $comid));
          
          // Echo Success Message
          
          $theMsg =  "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Updated </div>';
           
          redirectHome($theMsg, 'back');
        
      }else {
          
          $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
          
          redirectHome($theMsg);
      }
     
      echo "</div>";
        
    } elseif ($do == 'Delete'){  // Delete Comment Page 
        
        echo  "<h1 class='text-center'>Delete Comment</h1>";
        echo  "<div class='container'>";
        
            // Check If Get Request comid Is Numeric & Get The Integer Value Of It
            
           $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
            
            // Select All Data Depend On This ID

           $check = checkItem('C_id', 'comments', $comid );
            
            if ($check  > 0)   {  
                
               $Stmt = $con->prepare("DELETE FROM comments WHERE C_id = :zid");
               
               $Stmt->bindParam(":zid", $comid);
               
               $Stmt->execute();
                   
                  $theMsg = "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Deleted </div>';
                  
                  redirectHome($theMsg, 'back');
               
            } else {
                
               $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
               
                redirectHome($theMsg);
            }
              echo '</div>';
              
    } elseif ($do == 'Approve') {
        
        echo  "<h1 class='text-center'>Approve Comment</h1>";
        echo  "<div class='container'>";
        
        // Check If Get Request Com ID Is Numeric & Get The Integer Value Of It
        
        $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;
        
        // Select All Data Depend On This ID
        
        $check = checkItem('C_id', 'comments', $comid );
        
        if ($check  > 0)   {
            
            $Stmt = $con->prepare("Update comments Set Status = 1 WHERE C_id = ?");
            
            $Stmt->execute(array($comid));
            
            $theMsg = "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Comment Approved </div>';
            
            redirectHome($theMsg, 'back');
            
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