<?php
// Tips:
// 1.get cookie from victim browser
// 2.replace cookie and paste this code to attacker broswer console {document.cookie = "PHPSESSID=GetFromVictimCookie"}
// 3.open dashboard.php, it will auto unset session, because different user-agent.

//https://bcrypt.online/ generate hash password


// Set session cookie parameters with HttpOnly and Secure attributes
session_set_cookie_params([
    'httponly' => true,
    'secure' => true,
    'samesite' => 'Strict', // or 'Lax' depending on your requirements
]);

// session timeout in 1 hour
ini_set('session.gc_maxlifetime', 3600); 

session_start();
include('../../database/db_connection.php');


$input_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$input_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
//hash password = $2y$10$IBOPk9shxa4qeGsHAlvOUu5nqAgfU0GSWqpSCQYFwuFaTBqdDskIy 
//Algorithm by hash password is BCRYPT 


$verifySql = "SELECT * FROM user WHERE User_Name = '$input_username'";
$result= $conn->query($verifySql) or die($conn->error.__LINE__);//sql
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

$count = mysqli_num_rows($result);
if($count == 1){//if have username and password  
	$userId = $row['User_ID'];
	$username = $row['User_Name'];
	$HashPassword = $row['User_password'];



    // Use password_verify() to check if the provided password matches the stored hashed password
    if (password_verify($input_password, $HashPassword)) {


        //check user ip if change then invalid the session 
        if (isset($_SESSION['user_ip']) && $_SESSION['user_ip'] !== $_SERVER['REMOTE_ADDR']) {
            // Invalid session, possibly hijacked
            session_unset();
            session_destroy();
            header('Location: login.html'); // Redirect to login
            exit();
        }


         // Check if the session already exists
         if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
            // Invalid session, possibly hijacked
            session_unset();
            session_destroy();
            header('Location: login.html'); // Redirect to login
            exit();
        }

        //if no existing IPaddress/user-agent
        
        //***Session setup area***//
        session_regenerate_id(true);// Regenerate session ID to prevent session fixation
        $sessionID = session_id();

        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR']; // Set user IP in session for validation
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];// Set User-Agent in session for validation
        $_SESSION['userId'] = $userId;
		$_SESSION['username'] = $username;
        


		echo "<script>alert('login success !!!');
		window.location.href= 'dashboard.php';</script>";

    } else {
        // If the password does not match, reject the login attempt
        echo "<script>alert('wrong password!!!');
		window.location.href= 'login.html';</script>";
    }

} else {
    // If no record was found, reject the login attempt
    echo "<script>alert('Incorrect username or password!!!');
		window.location.href= 'login.html';</script>";
}

// Close the connection
$conn->close();


?>