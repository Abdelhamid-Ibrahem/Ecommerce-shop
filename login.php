<?php 
    Session_start();
    $pageTitle = 'Login';
    
    if (isset($_SESSION['user'])) {
        header('location: index.php');   // Redirect To Home Page
    }
    Include 'Init.php';
    
    // Check If User Coming from HTTP Post Request
    
    if ($_SERVER['REQUEST_METHOD']=='POST') {
        
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $hashedpass = sha1($pass);
        
        // Check If The User In Database
        
        $Stmt = $con->prepare("SELECT
                                 Username, Password
                              FROM
                                  users
                             WHERE
                                  Username = ?
                              AND
                                  Password= ?");
        
        $Stmt->execute(array($user, $hashedpass));
        
        $Count = $Stmt->rowCount();
        
        // If Count > 0 This Mean The Database Contain Record About This Username
        
        if ($Count > 0) {
           
            $_SESSION['user'] = $user;   // Register Session Name
            
            
            header('location: index.php');   // Redirect To Home Page
            exit();
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
        	<input class="btn btn-primary btn-block" type="submit" Value="Login" />
    	<!-- End Login Form -->
    	<!-- Start Signup Form -->
    	</form>
    	<form class="signup">
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
                	placeholder="Type a Complex Password" 
                	autocomplete="new-password" 
                	required />
        	</div>
            <div class="input-container">	
                <input 
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
            	type="submit" 
            	Value="Signup" />
    	</form>
    	<!-- End Signup Form -->
    </div>






<?php Include $tpl . 'footer.php'; ?>