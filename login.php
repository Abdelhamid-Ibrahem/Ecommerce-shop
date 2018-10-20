<?php 
    ob_start();
    Session_start();
    $pageTitle = 'Login';
    
    if (isset($_SESSION['user'])) {
        header('location: index.php');   // Redirect To Home Page
    }
    Include 'Init.php';
    
    // Check If User Coming from HTTP Post Request
    
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        if (isset($_POST['login'])) {
            
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $hashedpass = sha1($pass);
            
            // Check If The User In Database
            
            $Stmt = $con->prepare("SELECT
                                     userID, Username, Password
                                  FROM
                                      users
                                 WHERE
                                      Username = ?
                                  AND
                                      Password= ?");
            
            $Stmt->execute(array($user, $hashedpass));

            $get = $Stmt->fetch();
            
            $Count = $Stmt->rowCount();
            
            // If Count > 0 This Mean The Database Contain Record About This Username
            
            if ($Count > 0) {
               
                $_SESSION['user'] = $user;   // Register Session Name

                $_SESSION['uid'] = $get['userID'];  // Register User ID in Session
                
                header('location: index.php');   // Redirect To Home Page
                exit();
            }


        } else {

            $formErrors = array();

            $username   = $_POST['username'];
            $password   = $_POST['password'];
            $password2  = $_POST['password2'];
            $email      = $_POST['email'];

            if (isset($username)) {
                
                $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);
                if (strlen($filterdUser) < 4) {
                    $formErrors[] = 'Username Must Be Larger than 4 Characters';
                }
            }
            if (isset($password) && isset($password2)) {

                if (empty($password)) {
                    $formErrors[] = 'Sorry Password Cant Be Empty';
                    }

                 if (sha1($password) !== sha1($password2)) {
                    $formErrors[] = 'Sorry Password Is Not Match';

                     }
                }
            if (isset($email)) {
                
                $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {
                    $formErrors[] = 'This Email Is Not Valid';
                }
            
            }
                    // Check If There's No Error Proceed The User Add

                    if (empty($formErrors)) {
                    
                    // Check If User Exist In Datebase
                    
                    
                    $check = checkItem("Username", "users", $username);
                    
                    if ($check == 1) {
                        
                          $formErrors[] = 'Sorry This User Is Exists';

                    } else {
                        
                           
                        // Insert UserInfo In Database
                        
                        $Stmt = $con->prepare("Insert Into 
                                                  users(Username, password, Email,  Regstatus, Date)
                                                  Values(:zuser, :zpass, :zmail,  0, now() )");
                        
                       $Stmt->execute(array(
                           
                           'zuser' => $username,
                           'zpass' => sha1($password),
                           'zmail' => $email
                           
                       ));
                        
                        // Echo Success Message
                        
                       $SuccessMsg = 'Congrats You Are Now Registerd User';
                    
                    }
                }
                


         }
        
    }
?>


    <div class="container login-page">
    	<h1 class="text-center">
    		<span class="selected" data-class="login">Login</span> | 
    		<span data-class="signup">Signup</span>
    	</h1>
    	<!-- Start Login Form -->
    	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    		<div class="input-container">
        		<input 
            		class="form-control" 
            		type="text" 
            		name="username" 
            		autocomplete="off" 
            		placeholder="Type Your Username"
            		required />
        	</div>
        	<div class="input-container">
            	<input 
                	class="form-control" 
                	type="password" 
                	name="password" 
                	placeholder="Type Your Password" 
                	autocomplete="new-password" 
                	required />
            </div>	
        	<input class="btn btn-primary btn-block" name="login" type="submit" Value="Login" />
        </form>
    	<!-- End Login Form -->
    	<!-- Start Signup Form -->
    	<form class="signup"action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    		<div class="input-container">
        		<input 
                    pattern=".{4,8}"
                    title="Username Must Be 4 Chars" 
            		class="form-control" 
            		type="text" 
            		name="username" 
            		autocomplete="off" 
            		placeholder="Type Your Username"
            		required />
    		</div>
        	<div class="input-container">	
            	<input 
                    minlength="4" 
                	class="form-control" 
                	type="password" 
                	name="password" 
                	placeholder="Type a Complex Password" 
                	autocomplete="new-password" 
                	required />
        	</div>
            <div class="input-container">	
                <input 
                    minlength="4" 
                	class="form-control" 
                	type="password" 
                	name="password2" 
                	placeholder="Type a Password Again" 
                	autocomplete="new-password" 
                	required />
        	</div>
            <div class="input-container">	
                <input 
                	class="form-control" 
                	type="email" 
                	name="email" 
                	placeholder="Type a Valid Email" 
                	required />	
        	</div>
        	<input 
            	class="btn btn-success btn-block"
                name="signup" 
            	type="submit" 
            	Value="Signup" />
    	</form>
    	<!-- End Signup Form -->
        <div class="the-errors text-center">
            <?php 
                if (!empty($formErrors)) {
                    foreach ($formErrors as $error) {
                        echo $error .  '<br>';
                    }
                }

                if (isset($SuccessMsg)) {
                    echo '<div class="msg Success">' . $SuccessMsg . '</div>';
                }

            ?>
        </div>
    </div>






<?php 
    Include $tpl . 'footer.php'; 
    ob_end_flush();
?>