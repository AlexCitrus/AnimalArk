<?php
session_start();
$email = ($_POST['email']);
$pass = ($_POST['pass']);
$db_name = "id20217626_test";
$db_username = "id20217626_thea";
$db_pass = "Pass!1234567";
$db_host = "localhost";
$con = mysqli_connect("$db_host","$db_username","$db_pass", "$db_name") 
or die(mysqli_error()); //Connect to server
$query = "SELECT * from users WHERE email='$email'";
$results = mysqli_query($con, $query); //Query the users table if there are matching rows equal to $username
$exists = mysqli_num_rows($results); //Checks if username exists

$table_users = "";
$table_pass = "";
if($results != "") //IF there are no returning rows or no existing username
{
    while($row = mysqli_fetch_assoc($results)) //display all rows from query
    {
        $table_users = $row['email']; // the first username ro is passed on to $table_users, and so on until the query is finished
        $table_pass = $row['pass']; // the first password row is passed on to $table_users, and so on until the query is finished
    }
    if(($email == $table_users) && ($pass == $table_pass)) // checks if there are any matching fields
    {
        if($pass == $table_pass)
        {
        $_SESSION['user'] = $email; //set the username in a session. This serves as a global variable
        Print '<script>alert("Successfully Logged In!");</script>'; // Prompts the user
        Print '<script>window.location.assign("cust_shop.html");</script>'; // redirects to register.php
        }
    }
    else
    {
        Print '<script>alert("Incorrect Password!");</script>'; //Prompts the user
        Print '<script>window.location.assign("cust_shop.html");</script>'; // redirects to login.php
    }
}
else {
    Print '<script>alert("Incorrect Email!");</script>'; //Prompts the user
    Print '<script>window.location.assign("cust_shop.html");</script>'; // redirects to login.php
    }
?>