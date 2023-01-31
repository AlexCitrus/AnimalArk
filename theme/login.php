<?php
session_start();
if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = ($_POST['email']);
    $pass = ($_POST['pass']);

    $db_name = "id20217626_test";
    $db_username = "id20217626_thea";
    $db_pass = "Pass!1234567";
    $db_host = "localhost";

    $con = mysqli_connect("$db_host", "$db_username", "$db_pass", "$db_name") or die(mysqli_error()); //Connect to server

    if (empty($email)) {

        header("Location: login.html?error=User Name is required");

        exit();

    }else if(empty($pass)){

        header("Location: login.html?error=Password is required");

        exit();

    } else {
        $query = "SELECT * from users WHERE email='$email' AND pass='$pass'";
        $results = mysqli_query($con, $query);

        if (mysqli_num_rows($results) === 1) {
            $row = mysqli_fetch_assoc($results);

            if ($row['email'] === $email && $row['pass'] === $pass) // checks if there are any matching fields
            {
                $_SESSION['email'] = $row['email'];

                $_SESSION['fname'] = $row['fname'];

                $_SESSION['id'] = $row['id'];
                print '<script>alert("Successfully Logged In!");</script>'; // Prompts the user
                print '<script>window.location.assign("cust_shop.php");</script>'; // redirects to login.php
            } else {
                print '<script>alert("Incorrect Password!");</script>'; //Prompts the user
                print '<script>window.location.assign("login.html");</script>'; // redirects to login.php
            }
        } else {
            print '<script>alert("This account does not exist!");</script>'; //Prompts the user
            print '<script>window.location.assign("login.html");</script>'; // redirects to login.php
        }
    }
}
?>