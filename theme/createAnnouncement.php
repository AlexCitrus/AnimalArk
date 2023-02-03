<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
 {
    //intiializes the variables
    date_default_timezone_set('Asia/Hong_Kong'); 
    $subject = ($_POST['subject']);
    $description = ($_POST['description']);
    $tempDate = date('Y-m-d h:i:s A');

    $month = date("F", strtotime($tempDate));
    $day = date("d", strtotime($tempDate));
    $year = date("Y", strtotime($tempDate));
    $hour = date("h", strtotime($tempDate));
    $mins = date("i", strtotime($tempDate));
    $a = date("a", strtotime($tempDate));

    $date_posted = $month . " " . $day . ", " . $year . " " . $hour . ":" . $mins . " " . $a;

    $bool = true;
    $db_name = "id20237149_animalark_db";
    $db_username = "id20237149_animalark";
    $db_pass = "P@ssw0rd!123";
    $db_host = "localhost";

    $con = mysqli_connect("$db_host","$db_username","$db_pass", "$db_name") or die(mysqli_error()); //Connect to server
    
    $query = "SELECT * from announcements";
    $results = mysqli_query($con, $query); //Query the users table

    while($row = mysqli_fetch_array($results)) //display all rows from query
    {
        mysqli_query($con, "DELETE FROM announcements"); // deletes the current announcement
        $table_announcements = $row['subject'];
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