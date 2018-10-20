<?php
    Session_start();
    $noNavbar = '';
    $pageTitle = 'Login';
    
    if (isset($_SESSION['Username'])) {
        header('location: dashboard.php');   // Redirect To Dashboard Page 
    }
    
    include 'Init.php';

// Check If User Coming from HTTP Post Request

if ($_SERVER['REQUEST_METHOD']=='POST') {
    
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedpass = sha1($password);
   
    // Check If The User In Database
    
     $Stmt = $con->prepare("SELECT 
                                UserID, Username, Password 
                              FROM 
                                  users 
                             WHERE 
                                  Username = ? 
                              AND 
                                  Password= ? 
                              AND 
                                 GroupID=1
                                 LIMIT 1");
     
     $Stmt->execute(array($username, $hashedpass));
     $row = $Stmt->fetch();
     
     $Count = $Stmt->rowCount();
    
     // If Count > 0 This Mean The Database Contain Record About This Username
     
     if ($Count > 0) {
         
         $_SESSION['Username'] = $username;   // Register Session Name
         $_SESSION['ID'] = $row['UserID'];    // Register Session ID
         header('location: dashboard.php');   // Redirect To Dashboard Page
        exit();
     }
  }

?>


  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
         <h4 class="text-center">Admin Login</h4>
         <input 
             class="form-control" 
             type="text" 
             name="user" 
             placeholder="username" 
             autocomplete="off"/>
         <input 
             class="form-control" 
             type="password" 
             name="pass" 
             placeholder="password" 
             autocomplete="new-password"/>
         <input class="btn btn-primary btn-block" type="submit"value="Login" />
  </form>
  
  
  
  
  

<?php include $tpl . 'footer.php'; ?>
 