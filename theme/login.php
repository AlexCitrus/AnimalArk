<?php
session_start();
if (isset($_POST['email']) && isset($_POST['pass'])) {
    $email = ($_POST['email']);
    $pass = ($_POST['pass']);

    $db_name = "id20237149_animalark_db";
    $db_username = "id20237149_animalark";
    $db_pass = "P@ssw0rd!123";
    $db_host = "localhost";

    $con = mysqli_connect("$db_host", "$db_username", "$db_pass", "$db_name") or die(mysqli_error()); //Connect to server

    if (empty($email)) {

        header("Location: login.html?error=User Name is required");

        exit();

    }else if(empty($pass)){

        header("Location: login.html?error=Password is required");

        exit();

    } else {
        $query = "SELECT user_type from users WHERE email='$email' AND pass='$pass'";
        $qyr = "SELECT * from users WHERE email='$email' AND pass='$pass'";
        $results = mysqli_query($con, $query);

        if (mysqli_num_rows($results) === 1) {
            
            $row = mysqli_fetch_assoc($results);
                if($row['user_type']=="admin"){
                    $_SESSION['user'] = $email;
                    print '<script>alert("Welcome Admin!");</script>'; // Prompts the user
                    print '<script>window.location.assign("admin_home_new.html");</script>'; // redirects to login.php
                }
                
                else if($row['user_type']=="user"){
                    $_SESSION['user'] = $email;
                    print '<script>alert("Successfully Logged In!");</script>'; // Prompts the user
                    print '<script>window.location.assign("cust_shop.php");</script>'; // redirects to login.php
                } 
        } else {
            print '<script>alert("This account does not exist!");</script>'; //Prompts the user
            print '<script>window.location.assign("login.html");</script>'; // redirects to login.php
        }
    }
}
?>