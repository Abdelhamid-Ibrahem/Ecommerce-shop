<?php
    ob_start();
    session_start();

    $pageTitle = 'Create New Item';

    
    include 'Init.php';
    If (isset($_SESSION['user'])) {

	    	if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	    		$formErrors = array();

	    		$name 		= filter_var($_POST['Name'], FILTER_SANITIZE_STRING);
	    		$desc 		= filter_var($_POST['Description'], FILTER_SANITIZE_STRING);
	    		$price 	    = filter_var($_POST['Price'], FILTER_SANITIZE_NUMBER_INT);
	    		$Country    = filter_var($_POST['Country'], FILTER_SANITIZE_STRING);
	    		$Status 	= filter_var($_POST['Status'], FILTER_SANITIZE_NUMBER_INT);
	    		$category   = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
	    		$tags   	= filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

	    		if (strlen($name) < 4) {
	    			$formErrors[] = 'Item Title Must Be At Least 4 Characters';
	    		}
	    		if (strlen($desc) < 10) {
	    			$formErrors[] = 'Item Description Must Be At Least 10 Characters';
	    		}
	    		if (strlen($Country) < 2) {
	    			$formErrors[] = 'Item Country Must Be At Least 2 Characters';
	    		}
	    		if (empty($price)) {
	    			$formErrors[] = 'Item Price Must Be Not Empty';
	    		}
	    		if (empty($Status)) {
	    			$formErrors[] = 'Item Status Must Be Not Empty';
	    		}
	    		
	    		if (empty($category)) {
	    			$formErrors[] = 'Item Category Must Be Not Empty';
	    		}

	            // Check If There's No Error Proceed The Update Operation
	            
	            if (empty($formErrors)) {

	                    
	                    // Insert UserInfo In Database
	                    
	                    $Stmt = $con->prepare("Insert Into
	                                                  items(Name, Description, Price, Add_Date, Country_Made, Status, Member_ID, Cat_ID, tags)
	                                                  Values(:zname, :zdesc, :zprice, now(), :zmad, :zstatus, :zmember, :zcat, :ztags )");
	                    
	                    $Stmt->execute(array(
	                        
	                        'zname'    => $name,
	                        'zdesc'    => $desc,
	                        'zprice'   => $price,
	                        'zmad'     => $Country,                        
	                        'zstatus'  => $Status,
	                        'zcat'     => $category,
	                        'zmember'  => $_SESSION['uid'],
	                        'ztags'    => $tags
	                        
	                    ));
	                    
	                    // Echo Success Message
	                    
	                    if ($Stmt) {

	                   		 $SuccessMsg = 'Item Has Been Added';

	                	}
	            }
		    			
	    	}
?>
	<h1 class="text-center"><?php echo $pageTitle ?></h1>
	<div class="Create-ad block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading"><?php echo $pageTitle ?></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-8">
							 	  <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" >    
					                   <!-- Start Name Field -->
					                   <div class="form-group form-group-lg">
					                        <label class="col-sm-3 control-label">Name</label>
					                        <div class="col-sm-10 col-md-9">
					                       		 <input 
					                       		 		pattern=".{4,}"
					                       		 		title="This Field Require At Least 4 Characters" 
					                       		 		type="text" 
					                       		 		name="Name" 
					                       		 		class="form-control live"  
					                       				required="required"
					                       		 		placeholder="Name Of The Item"
					                       		 		data-class=".live-title"
					                       		 		required />
					                        </div>
					                    </div>
					                    <!-- End Name Field -->
					                    <!-- Start Description Field -->
					                    <div class="form-group form-group-lg">
					                        <label class="col-sm-3 control-label">Description</label>
					                        <div class="col-sm-10 col-md-9">
					                       		 <input 
					                       		 		pattern=".{10,}"
					                       		 		title="This Field Require At Least 10 Characters" 
					                       		 		type="text" 
					                       		 		name="Description" 
					                       		 		class="form-control live"  
					                       				required="required"
					                       				placeholder="Description Of The Item" 
					                       				data-class=".live-desc"
					                       				required />
					                        </div>
					                    </div>
					                    <!-- End Description Field -->
					                    <!-- Start Price Field -->
					                    <div class="form-group form-group-lg">
					                        <label class="col-sm-3 control-label">Price</label>
					                        <div class="col-sm-10 col-md-9">
					                       		 <input 
					                       		 		type="text" 
					                       		 		name="Price" 
					                       		 		class="form-control live"  
					                       				required="required"
					                       				placeholder="Price Of The Item" 
					                       				data-class=".live-price"
					                       				required />
					                        </div>
					                    </div>
					                    <!-- End Price Field -->
					                    <!-- Start Country Field -->
					                    <div class="form-group form-group-lg">
					                        <label class="col-sm-3 control-label">Country</label>
					                        <div class="col-sm-10 col-md-9">
					                       		 <input 
					                       		 		type="text" 
					                       		 		name="Country" 
					                       		 		class="form-control"  
					                       				required="required"
					                       				placeholder="Country Of Made" 
					                       				required />
					                        </div>
					                    </div>
					                    <!-- End Country Field -->
					                    <!-- Start Status Field -->
					                    <div class="form-group form-group-lg">
					                        <label class="col-sm-3 control-label">Status</label>
					                        <div class="col-sm-10 col-md-9">
					                       		 <select  name="Status" required>
					                       		    <option value="0">...</option>
					                   		 		<option value="1">New</option>
					                   		 		<option value="2">Like New</option>
					                   		 		<option value="3">Used</option>
					                   		 		<option value="4">Very Old</option>
					                       		 </select>
					                        </div>
					                    </div>
					                    <!-- End Status Field -->
   					                    <!-- Start Categories Field -->
					                    <div class="form-group form-group-lg">
					                        <label class="col-sm-3 control-label">Category</label>
					                        <div class="col-sm-10 col-md-9">
					                       		 <select  name="category" required>
					                       		    <option value="0">...</option>
					                   				<?php 
					                   					$cats = getAllFrom('*', 'categories', '', '', 'ID');
					                   				    foreach ($cats as $cat) {
					                   				         echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
					                   				     }
					                   				?>
					                       		 </select>
					                        </div>
					                    </div>
					                    <!-- End Categories Field -->
					                    <!-- Start Tags Field -->
					                    <div class="form-group form-group-lg">
					                        <label class="col-sm-3 control-label">Tags</label>
					                        <div class="col-sm-10 col-md-9">
					                           <input 
					                              type="text" 
					                              name="tags" 
					                              class="form-control"  
					                              placeholder="Separate Tags With Comma (,)" />
					                        </div>
					                    </div>
					                    <!-- End Tags Field -->
					                    <!-- Start submit Field -->
					                    <div class="form-group form-group-lg">
					                         <div class="col-sm-offset-3 col-sm-9">
					                              <input type="submit" Value="Add Item" class="btn btn-primary btn-sm" />
					                         </div>
					                    </div>
					                    <!-- End submit Field -->
					              </form>	
							</div>
							<div class="col-md-4">
		                        <div class="thumbnail item-box live-preview">
		                            <span class="price-tag">
		                            	$<span class="live-price">0</span>
		                            </span>
		                            <img class="img-responsive" src="User_male.png" alt="" />
		                            <div class="caption">
		                                <h3 class="live-title">Title</h3>
		                                <p class="live-desc">Description</p>
		                            </div>
	                    	    </div>
			
							</div>
						</div>
						<!-- Start Loopiong Through Errors -->
						<?php
							if (! empty($formErrors)) {
								foreach ($formErrors as $error) {
									echo '<div class="alert alert-danger">' . $error . '</div>';
								}
							}

							if (isset($SuccessMsg)) {
			                    echo '<div class="alert alert-success">' . $SuccessMsg . '</div>';
			                }
						?>
						<!-- End Loopiong Through Errors -->
					</div>
			</div>
		</div>
	</div>
   

<?php 
    
    } else {

    	header('Location: login.php');
    	exit();

    } 
    include $tpl . 'footer.php'; 
     ob_end_flush();
?>
 