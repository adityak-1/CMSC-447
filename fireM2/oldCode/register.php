<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
      
// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM userAccount WHERE email='$email'") or die($mysqli->error());

// We know user email exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    
    $_SESSION['message'] = 'User with this email already exists!';
    header("location: error.php");
    
}
else { // Email doesn't already exist in a database, proceed...
    // active is 0 by DEFAULT (no need to include it here)
    $sql = "INSERT INTO userAccount (email, firstName, lastName, loginPass, hashVal, role) " . "VALUES ('$email','$first_name','$last_name','$password','$hash', 'MM')";

    // Add user to the database
    if ( $mysqli->query($sql) ){
        $_SESSION['active'] = 0; //initialize active session variable as false
        $_SESSION['logged_in'] = false; //the user has not actually logged in

        header("location: profile.php");
    } else {
        $_SESSION['message'] = 'Registration failed!';
        header("location: error.php");
    }

}