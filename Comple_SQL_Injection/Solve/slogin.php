<?php

//anything' OR '1' = '1
//https://bcrypt.online/ generate hash password

session_start();
include('../database/db_connection.php');


// Store the username and password provided by the user
$input_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

// Sanitize and filter the 'password' POST input
$input_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
//hash password = $2y$10$IBOPk9shxa4qeGsHAlvOUu5nqAgfU0GSWqpSCQYFwuFaTBqdDskIy 
//Algorithm by hash password is BCRYPT 

// Retrieve the hashed password from the database using the provided username
$sql = "SELECT User_password FROM user WHERE User_Name = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $input_username);
$stmt->execute();
$result = $stmt->get_result();

// If a record was found, validate the provided password
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['User_password'];

    // Use password_verify() to check if the provided password matches the stored hashed password
    if (password_verify($input_password, $hashed_password)) {
        // If the password matches, log the user in
        echo "Logged in successfully";
        echo "Username: " . $input_username;
        echo "Password: " . $input_password;
    } else {
        // If the password does not match, reject the login attempt
        echo "wrong password";
    }
} else {
    // If no record was found, reject the login attempt
    echo "Incorrect username or password";
}

// Close the connection
$conn->close();

// if (mysqli_num_rows($result) > 0) {
    
//     $row = mysqli_fetch_assoc($result);
//     echo 'Username: ' . $row['User_Name'] . "\n";
//     echo 'Password: ' . $row['User_password'];

    
// } else {
//     echo "Invalid username or password.";
// }

// mysqli_close($conn);
?>