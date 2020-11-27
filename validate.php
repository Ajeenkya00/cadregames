<?php
$servername = "localhost";
$username = "root";
$password = "Ajinkya_123";
$db = "cadre";

	$email	=$_POST['email'];	
	$passwd	=$_POST['passwd'];
	
	
$conn = new mysqli($servername, $username, $password, $db);
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location:index.html");
  exit;
}

 
// Define variables and initialize with empty values
$email = $passwd = "";
$email_err = $passwd_err = ""; 
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $username = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["passwd"]))){
        $passwd_err = "Please enter your password.";
    } else{
        $passwd = trim($_POST["passwd"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($passwd_err)){
        // Prepare a select statement
        $sql = "SELECT  Email, Password FROM cadre WHERE Email = ?;";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt,  $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($passwd, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["email"] = $email;                            
                            
                            // Redirect user to welcome page
                            header("location: index.html");
                        } else{
                            // Display an error message if password is not valid
                            $passwd_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $email_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>

