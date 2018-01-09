<?php
/*
 *********************************************************************************************
 ** Items Page
 *********************************************************************************************
 */


ob_start();  // Output Buffering Start

Session_start();

$pageTitle = 'Items';

if (isset($_SESSION['Username'])) {
    
    include 'Init.php';
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    if ($do == 'Manage') {
                
        $Stmt = $con->prepare(" SELECT 
                                      items.* , 
                                      categories.Name as categories_Name,
                                      users.Username as users_Name 
                                FROM 
                                      items
                                INNER JOIN 
                                      categories 
                                ON 
                                      categories.ID = items.Cat_ID
                                INNER JOIN 
                                      users 
                                ON 
                                      users.userID = items.Member_ID
                                Order by 
                                      Item_ID DESC");
            
        
        // Execute The Statement
        
        $Stmt->execute();
        
        // Assign To Variable
        
        $items = $Stmt->fetchAll();
        
        if (! empty($items)) {
        
        ?>
        
    
      <h1 class="text-center">Manage Items</h1>
      <div class="container">
             <div class="table-responsive">
                  <table class="main-table text-center table table-bordered">
                  <tr>
                      <td>#ID</td>
                      <td>Name</td>
                      <td>Description</td>
                      <td>Price</td>
                      <td>Adding Date</td>
                      <td>Category</td>
                      <td>Username</td>
                      <td>Control</td>                  
                  </tr>
                  <?php 
                  foreach ($items as $item) {
                      echo "<tr>";
                      echo "<td>" . $item['Item_ID'] . "</td>";
                      echo "<td>" . $item['Name'] . "</td>";
                      echo "<td>" . $item['Description'] . "</td>";
                      echo "<td>" . $item['Price'] . "</td>";
                      echo "<td>" . $item['Add_Date'] . "</td>";
                      echo "<td>" . $item['categories_Name'] . "</td>";
                      echo "<td>" . $item['users_Name'] . "</td>";
                             echo "<td>
                                  <a href='Items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                  <a href='Items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                     if ($item['Approve'] == 0) {
                                         echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' 
                                                class='btn btn-info activate'>
                                                <i class='fa fa-check'></i> Approve</a>";
                                     }
                             echo "</td>";
                      echo "</tr>";
                  }
                  
                  ?>
                  <tr>
                    
                  </tr>
                  </table>
             </div>
             <a href="Items.php?do=Add" class="btn btn-sm btn-primary">
             <i class="fa fa-plus"></i> New Item 
             </a>
       </div>>
       <?php } else {
             echo  '<div class="container">';
                echo '<div class="nice-message">There\'s No Items To Show</div>';
                echo '<a href="Items.php?do=Add" class="btn btn-sm btn-primary">
                     <i class="fa fa-plus"></i> New Item 
                     </a>';
             echo '</div>';
    
        }?>
        
    <?php } elseif ($do == 'Add') { ?>
    
     <h1 class="text-center">Add New Item</h1>
          <div class="container">
              <form class="form-horizontal" action="?do=Insert" method="post" >    
                   <!-- Start Name Field -->
                   <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                       		 <input 
                       		 		type="text" 
                       		 		name="Name" 
                       		 		class="form-control"  
                       				required="required"
                       		 		placeholder="Name Of The Item" />
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Start Description Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                       		 <input 
                       		 		type="text" 
                       		 		name="Description" 
                       		 		class="form-control"  
                       				required="required"
                       				placeholder="Description Of The Item" />
                        </div>
                    </div>
                    <!-- End Description Field -->
                    <!-- Start Price Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                       		 <input 
                       		 		type="text" 
                       		 		name="Price" 
                       		 		class="form-control"  
                       				required="required"
                       				placeholder="Price Of The Item" />
                        </div>
                    </div>
                    <!-- End Price Field -->
                    <!-- Start Country Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-10 col-md-6">
                       		 <input 
                       		 		type="text" 
                       		 		name="Country" 
                       		 		class="form-control"  
                       				required="required"
                       				placeholder="Country Of Made" />
                        </div>
                    </div>
                    <!-- End Country Field -->
                    <!-- Start Status Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Status</label>
                        <div class="col-sm-10 col-md-6">
                       		 <select  name="Status">
                       		    <option value="0">...</option>
                   		 		<option value="1">New</option>
                   		 		<option value="2">Like New</option>
                   		 		<option value="3">Used</option>
                   		 		<option value="4">Very Old</option>
                       		 </select>
                        </div>
                    </div>
                    <!-- End Status Field -->
                    <!-- Start Members Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-10 col-md-6">
                       		 <select  name="Member">
                       		    <option value="0">...</option>
                   				<?php 
                   				     $stmt = $con->prepare("Select * from users");
                   				     $stmt->execute();
                   				     $users = $stmt->fetchAll();
                   				     foreach ($users as $user) {
                   				         echo "<option value='" . $user['userID'] . "'>" . $user['Username'] . "</option>";
                   				     }
                   				?>
                       		 </select>
                        </div>
                    </div>
                    <!-- End Members Field -->
                    <!-- Start Categories Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category</label>
                        <div class="col-sm-10 col-md-6">
                       		 <select  name="category">
                       		    <option value="0">...</option>
                   				<?php 
                   				     $stmt2 = $con->prepare("Select * from categories");
                   				     $stmt2->execute();
                   				     $cats = $stmt2->fetchAll();
                   				     foreach ($cats as $cat) {
                   				         echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                   				     }
                   				?>
                       		 </select>
                        </div>
                    </div>
                    <!-- End Categories Field -->
                    <!-- Start submit Field -->
                    <div class="form-group form-group-lg">
                         <div class="col-sm-offset-2 col-sm-10">
                              <input type="submit" Value="Add Item" class="btn btn-primary btn-sm" />
                         </div>
                    </div>
                    <!-- End submit Field -->
              </form>
         </div>
       
         <?php 
         
    } elseif ($do == 'Insert') {
      
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            
            echo  "<h1 class='text-center'>Insert Item</h1>";
            echo  "<div class='container'>";
            
            
            // Get Variables From The Form
            
            $name   = $_POST['Name'];
            $desc   = $_POST['Description'];
            $price  = $_POST['Price'];
            $mad    = $_POST['Country'];
            $status = $_POST['Status'];
            $member = $_POST['Member'];
            $cat    = $_POST['category'];
            
                        
            // Validate The Form
            
            $formErrors = array();
            
            if (empty($name)) {
                
                $formErrors[] = 'Name Can\'t Be <strong> Empty </strong>';
            }
            if (empty($desc)) {
                
                $formErrors[] = 'Description Can\'t Be <strong> Empty </strong>';
            }
            if (empty($price)) {
                
                $formErrors[] = 'Price Can\'t Be <strong> Empty </strong>';
            }
            if (empty($mad)) {
                
                $formErrors[] = 'Country Can\'t Be <strong> Empty </strong>';
            }
            
            if ($status == 0) {
                
                $formErrors[] = 'You Must Choose The <strong> Status </strong>';
            }
            if ($member == 0) {
                
                $formErrors[] = 'You Must Choose The <strong> Member </strong>';
            }
            if ($cat == 0) {
                
                $formErrors[] = 'You Must Choose The <strong> Category </strong>';
            }
            
            // Loop Into Errors Array And Echo It
            
            foreach ($formErrors as $error) {
                
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
            
            // Check If There's No Error Proceed The Update Operation
            
            if (empty($formErrors)) {

                    
                    // Insert UserInfo In Database
                    
                    $Stmt = $con->prepare("Insert Into
                                                  items(Name, Description, Price, Add_Date, Country_Made, Status, Member_ID, Cat_ID)
                                                  Values(:zname, :zdesc, :zprice, now(), :zmad, :zstatus, :zmember, :zcat )");
                    
                    $Stmt->execute(array(
                        
                        'zname'    => $name,
                        'zdesc'    => $desc,
                        'zprice'   => $price,
                        'zmad'     => $mad,                        
                        'zstatus'  => $status,
                        'zmember'  => $member,
                        'zcat'     => $cat
                        
                    ));
                    
                    // Echo Success Message
                    
                    $theMsg = "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Inserted </div>';
                    redirectHome($theMsg, 'back');
                
            }
            
        }else {
            
            echo "<div class='container'>";
            
            $theMsg = '<div class="alert alert-danger"> Sorry You Cant Browse This Page Directly</div>';
            
            redirectHome($theMsg);
            
            echo "</div>";
        }
        
        echo "</div>";
        
    } elseif ($do == 'Edit') {
        
        // Check If Get Request item id Is Numeric & Get The Integer Value Of It
        
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        
        // Select All Data Depend On This ID
        
        $Stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? ");
        
        // Execute Query
        
        $Stmt->execute(array($itemid));
        
        // Fetch The Data
        
        $item = $Stmt->fetch();
        
        // The Row Count
        
        $Count = $Stmt->rowCount();
        
        // If There's Such ID Show The Form
        
        if ($Count > 0)   {  ?>
        
            <h1 class="text-center">Edit Item</h1>
              <div class="container">
                  <form class="form-horizontal" action="?do=Update" method="post" >
                       <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
                       <!-- Start Name Field -->
                       <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-6">
                           		 <input 
                           		 		type="text" 
                           		 		name="Name" 
                           		 		class="form-control"  
                           				required="required"
                           		 		placeholder="Name Of The Item"
                           		 		value="<?php echo $item['Name'] ?>" />
                            </div>
                        </div>
                        <!-- End Name Field -->
                        <!-- Start Description Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10 col-md-6">
                           		 <input 
                           		 		type="text" 
                           		 		name="Description" 
                           		 		class="form-control"  
                           				required="required"
                           				placeholder="Description Of The Item" 
                           				value="<?php echo $item['Description'] ?>" />
                            </div>
                        </div>
                        <!-- End Description Field -->
                        <!-- Start Price Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-10 col-md-6">
                           		 <input 
                           		 		type="text" 
                           		 		name="Price" 
                           		 		class="form-control"  
                           				required="required"
                           				placeholder="Price Of The Item" 
                           				value="<?php echo $item['Price'] ?>" />
                            </div>
                        </div>
                        <!-- End Price Field -->
                        <!-- Start Country Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Country</label>
                            <div class="col-sm-10 col-md-6">
                           		 <input 
                           		 		type="text" 
                           		 		name="Country" 
                           		 		class="form-control"  
                           				required="required"
                           				placeholder="Country Of Made" 
                           				value="<?php echo $item['Country_Made'] ?>" />
                            </div>
                        </div>
                        <!-- End Country Field -->
                        <!-- Start Status Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Status</label>
                            <div class="col-sm-10 col-md-6">
                           		 <select  name="Status">
                       		 		<option value="1" <?php if ($item['Status'] == 1) { echo 'selected'; } ?>>New</option>
                       		 		<option value="2" <?php if ($item['Status'] == 2) { echo 'selected'; } ?>>Like New</option>
                       		 		<option value="3" <?php if ($item['Status'] == 3) { echo 'selected'; } ?>>Used</option>
                       		 		<option value="4" <?php if ($item['Status'] == 4) { echo 'selected'; } ?>>Very Old</option>
                           		 </select>
                            </div>
                        </div>
                        <!-- End Status Field -->
                        <!-- Start Members Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Member</label>
                            <div class="col-sm-10 col-md-6">
                           		 <select  name="Member">
                       				<?php 
                       				     $stmt = $con->prepare("Select * from users");
                       				     $stmt->execute();
                       				     $users = $stmt->fetchAll();
                       				     foreach ($users as $user) {
                       				         echo "<option value='" . $user['userID'] . "'"; 
                       				         if ($item['Member_ID'] == $user['userID']) { echo 'selected'; } 
                       				         echo " >" . $user['Username'] . "</option>";
                       				     }
                       				?>
                           		 </select>
                            </div>
                        </div>
                        <!-- End Members Field -->
                        <!-- Start Categories Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Category</label>
                            <div class="col-sm-10 col-md-6">
                           		 <select  name="category">
                       				<?php 
                       				     $stmt2 = $con->prepare("Select * from categories");
                       				     $stmt2->execute();
                       				     $cats = $stmt2->fetchAll();
                       				     foreach ($cats as $cat) {
                       				         echo "<option value='" . $cat['ID'] . "'";
                       				         if ($item['Cat_ID'] == $cat['ID']) { echo 'selected'; } 
                       				         echo ">" . $cat['Name'] . "</option>";
                       				     }
                       				?>
                           		 </select>
                            </div>
                        </div>
                        <!-- End Categories Field -->
                        <!-- Start submit Field -->
                        <div class="form-group form-group-lg">
                             <div class="col-sm-offset-2 col-sm-10">
                                  <input type="submit" Value="Save Item" class="btn btn-primary btn-sm" />
                             </div>
                        </div>
                        <!-- End submit Field -->
                  </form>
                  
                  <?php 
                  
                   // Select All Users Except Admin
                    
                    $Stmt = $con->prepare("SELECT
                                                comments.*, users.Username AS Member
                                           FROM 
                                               comments
                                           INNER JOIN
                                                  users
                                           ON
                                                users.userID = comments.user_id
                                           WHERE
                                                Item_id = ?");
                    
                    
                    // Execute The Statement
                    
                    $Stmt->execute(array($itemid));
                    
                    // Assign To Variable
                    
                    $rows = $Stmt->fetchAll();
                    
                    if (! empty($rows)) {
                   
                  ?>
                  <h1 class="text-center">Manage [ <?php echo $item['Name'] ?> ] Comments</h1>
                  <div class="table-responsive">
                      <table class="main-table text-center table table-bordered">
                      <tr>
                          <td>Comment</td>
                          <td>User Name</td>
                          <td>Added Date</td>
                          <td>Control</td>                  
                      </tr>
                      <?php 
                      foreach ($rows as $row) {
                          echo "<tr>";
                                 echo "<td>" . $row['Comment'] . "</td>";
                                 echo "<td>" . $row['Member'] . "</td>";
                                 echo "<td>" . $row['Comment_Date'] . "</td>";
                                 echo "<td>
                                      <a href='comments.php?do=Edit&comid=" . $row['C_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
                                      <a href='comments.php?do=Delete&comid=" . $row['C_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
                                     if ($row['Status'] == 0) {
                                       echo "<a href='comments.php?do=Approve&comid=" . $row['C_id'] . "' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";
                                     }
                                      echo "</td>";
                          echo "</tr>";
                      }
                      
                      ?>
                      <tr>
                        
                      </tr>
                      </table>
                 </div>    
                 <?php } ?>  
             </div>
                  
<?php 

       // If There's No Such ID Show Error Message

        } else {
            echo "<div class='container'>";
            
           $theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';
           
            redirectHome($theMsg);
            
            echo "</div>";
      
        }
        
    } elseif ($do == 'Update') {
        
            echo  "<h1 class='text-center'>Update Item</h1>";
            echo  "<div class='container'>";
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                // Get Variables From The Form
                
                $id       = $_POST['itemid'];
                $name     = $_POST['Name'];
                $desc     = $_POST['Description'];
                $price    = $_POST['Price'];   
                $country  = $_POST['Country'];
                $status   = $_POST['Status'];
                $cat      = $_POST['category'];
                $member   = $_POST['Member'];
                
                // Validate The Form
                
                    $formErrors = array();
                    
                    if (empty($name)) {
                        
                        $formErrors[] = 'Name Can\'t Be <strong> Empty </strong>';
                    }
                    if (empty($desc)) {
                        
                        $formErrors[] = 'Description Can\'t Be <strong> Empty </strong>';
                    }
                    if (empty($price)) {
                        
                        $formErrors[] = 'Price Can\'t Be <strong> Empty </strong>';
                    }
                    if (empty($country)) {
                        
                        $formErrors[] = 'Country Can\'t Be <strong> Empty </strong>';
                    }
                    
                    if ($status == 0) {
                        
                        $formErrors[] = 'You Must Choose The <strong> Status </strong>';
                    }
                    if ($member == 0) {
                        
                        $formErrors[] = 'You Must Choose The <strong> Member </strong>';
                    }
                    if ($cat == 0) {
                        
                        $formErrors[] = 'You Must Choose The <strong> Category </strong>';
                    }
                    
                    // Loop Into Errors Array And Echo It
                    
                    foreach ($formErrors as $error) {
                        
                        echo '<div class="alert alert-danger">' . $error . '</div>';
                    }
                
                // Check If There's No Error Proceed The Update Operation
                
                if (empty($formErrors)) {
                    
                    // Update The Datebase With This Info
                    
                    $Stmt = $con->prepare(" UPDATE 
                                                items 
                                            SET 
                                                Name = ?, 
                                                Description = ?, 
                                                Price = ?, 
                                                Country_Made = ?, 
                                                Status = ?, 
                                                Cat_ID = ?, 
                                                Member_ID = ? 
                                            WHERE 
                                                Item_ID = ?");
                    $Stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $id ));
                    
                    // Echo Success Message
                    
                    $theMsg =  "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Updated </div>';
                    
                    redirectHome($theMsg, 'back');
                }
                
            }else {
                
                $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
                
                redirectHome($theMsg);
            }
            
            echo "</div>";
        
    } elseif ($do == 'Delete'){
        
        echo  "<h1 class='text-center'>Delete Item</h1>";
        echo  "<div class='container'>";
        
        // Check If Get Request Item ID Is Numeric & Get The Integer Value Of It
        
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        
        // Select All Data Depend On This ID
        
        $check = checkItem('Item_ID', 'items', $itemid );
        
        if ($check  > 0)   {
            
            $Stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");
            
            $Stmt->bindParam(":zid", $itemid);
            
            $Stmt->execute();
            
            $theMsg = "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Deleted </div>';
            
            redirectHome($theMsg, 'back');
            
        } else {
            
            $theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';
            
            redirectHome($theMsg);
        }
        echo '</div>';
        
        
    } elseif ($do == 'Approve') {
        
        echo  "<h1 class='text-center'>Approve Item</h1>";
        echo  "<div class='container'>";
        
        // Check If Get Request Item ID Is Numeric & Get The Integer Value Of It
        
        $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
        
        // Select All Data Depend On This ID
        
        $check = checkItem('Item_ID', 'items', $itemid );
        
        if ($check  > 0)   {
            
            $Stmt = $con->prepare("Update items Set Approve = 1 WHERE Item_ID = ?");
            
            $Stmt->execute(array($itemid));
            
            $theMsg = "<div class='alert alert-success'>" . $Stmt->rowCount() . ' Record Updated </div>';
            
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