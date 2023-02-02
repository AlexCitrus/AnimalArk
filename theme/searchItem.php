<?php   

        $db_name = "id20237149_animalark_db";
        $db_username = "id20237149_animalark";
        $db_pass = "P@ssw0rd!123";
        $db_host = "localhost";
        $con = mysqli_connect("$db_host", "$db_username", "$db_pass", "$db_name") or die(mysqli_error()); //Connect to server

        $search = $_POST['search']; // gets value sent over search form
        
        $min_length = 3;
        // you can set minimum length of the query if you want
        
        if(strlen($search) >= $min_length){ // if query length is more or equal minimum length then
            
            $search = htmlspecialchars($search); 
            // changes characters used in html to their equivalents, for example: < to &gt;
            
            // $query = mysql_real_escape_string($query);
            // // makes sure nobody uses SQL injection

            $qry = "SELECT * FROM products WHERE `name` LIKE '%" . $search . "%'";
            $con = mysqli_connect("$db_host", "$db_username", "$db_pass", "$db_name") or die(mysqli_error()); //Connect to server
            $raw_results = mysqli_query($con, $qry);
            
            if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
                
                while($results = mysqli_fetch_array($raw_results)){
                    $row = mysqli_fetch_assoc($raw_results);
                
                echo "
                <div class=\"col-sm-4\">
                <div class=\"product-image-wrapper\">
                  <div class=\"single-products\">
                    <div class=\"productinfo text-center\">
                      <p> " . $row['name'] . "</p>
                    </div>
                    </div>
                  </div>
                </div>
                </div>
              ";
                }
                
            }
            else{ // if there is no matching rows do following
                echo "No results";
            }
            
        }
        else{ // if query length is less than minimum
            echo "Minimum length is ".$min_length;
        }
?>