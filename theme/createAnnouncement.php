<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
 {
    //intiializes the variables
    $subject = ($_POST['subject']);
    $description = ($_POST['description']);
    $date_posted = (now());

    $bool = true;
    $db_name = "id20217626_test";
    $db_username = "id20217626_thea";
    $db_pass = "Pass!1234567";
    $db_host = "localhost";
    $con = mysqli_connect("$db_host","$db_username","$db_pass", "$db_name") or die(mysqli_error()); //Connect to server
    $query = "SELECT * from announcements";
    $results = mysqli_query($con, $query); //Query the users table

    while($row = mysqli_fetch_array($results)) //display all rows from query
    {
        $table_announcements = $row['subject']; // the first username row is passed on to $table_users, and so on until the query is finished
        if($subject == $table_announcements) // checks if there are any matching fields
        {
            $bool = false; // sets bool to false
            Print '<script>alert("Announcement Posted!");</script>'; //Prompts the user
            Print '<script>window.location.assign("createAnnouncement.html");</script>'; // redirects to register.php
        }
    }

    //adds teh newly inputted user data to the users db
    if($bool) // checks if bool is true
    {
        mysqli_query($con, "INSERT INTO announcements (subject, date_posted, description) VALUES
        ('$subject', '$date_posted', '$description')"); //Inserts the value to table users
        Print '<script>alert("Announcement Posted!");</script>'; // Prompts the user
        Print '<script>window.location.assign("createAnnouncement.html");</script>'; // redirects to register.php
    }
 }
?>