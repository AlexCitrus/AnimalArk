<?php
session_start();
    $email = ($_POST['email']);
    $pass = ($_POST['pass']);

    $db_name = "id20217626_test";
    $db_username = "id20217626_thea";
    $db_pass = "Pass!1234567";
    $db_host = "localhost";


    $con = mysqli_connect("$db_host","$db_username","$db_pass", "$db_name") or die(mysqli_error()); //Connect to server
    $query = "SELECT * from users WHERE email='$email' AND pass='$pass'";
    $results = mysqli_query($con, $query);
    
    $table_users = "";
    $table_password = "";

    if($results) //IF there are no returning rows or no existing username
    {
        $row = mysqli_fetch_assoc($results); //display all rows from query
        
            $table_users = $row['email'];
            $table_password = $row['pass'];
        
        if (($email == $table_users) && ($pass == $table_password)) // checks if there are any matching fields
        {
            $_SESSION['user'] = $email; //set the username in a session. This serves as a global variable
            Print '<script>alert("Successfully Logged In!");</script>'; // Prompts the user
            Print '<script>window.location.assign("cust_shop.php");</script>'; // redirects to login.php
        }
        else
        {
            Print '<script>alert("Incorrect Password!");</script>'; //Prompts the user
            Print '<script>window.location.assign("login.html");</script>'; // redirects to login.php
        }
    }
    else {
        Print '<script>alert("Error!");</script>'; //Prompts the user
        Print '<script>window.location.assign("login.html");</script>'; // redirects to login.php
    }
?>