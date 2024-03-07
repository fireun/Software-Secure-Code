<?php
//https://bcrypt.online/ generate hash password

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
        $_SESSION['userId'] = $userId;
		$_SESSION['username'] = $username;
        $sessionID = session_id();
        //echo "Session ID: $sessionID";
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