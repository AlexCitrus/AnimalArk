<?php
function getCategories($con) 
{
    $categories = array();
    $qry = "SELECT * FROM categories";
    $result = $con->query($qry);
    $numrows = $result->num_rows;

    for($i=0; $i<$numrows; $i++)
    {
        $row = $result->fetch_assoc();
        extract($row);
        $categories[$id] = $category;
    }

    return $categories;
}

$prospectid = $product_name = $product_description = $product_category = $product_targets = "";
$categories = array();

$host = "localhost";
$user = "root";
$pass = "";
$db = "project";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());

$categories = getCategories($con);

if(isset($_POST["id"]) && !empty($_POST["id"]))
{
    $id = $_POST["id"];
    //deletion process

    $qry = "DELETE FROM products WHERE id = ?";
    
    if($sql = $con->prepare($qry)) 
    {
        $sql->bind_param("i", $param_id);

        $param_id = $id;
        
        if($sql->execute())
            header("location: createproduct.php");
        else
            echo "Oops! Something went wrong. Please try again later.";
    
    
    $sql->close();
    
    }
    
} 

else
{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        
        $id = $_GET["id"];
        //displays the info of to be deleted prospect
        $query = "SELECT * FROM products WHERE id='$id'";
        $result = $con->query($query);
        $numrows = $result->num_rows;
        
        if($result != "") 
        {
            for($i=0; $i<$numrows; $i++) 
            {
                $row = $result->fetch_assoc();
                extract($row);
                
                $prospectid = $id;
                $product_name = $name;
                $product_description = $description;
                $product_category = $category_id;
                $product_targets = $intended_for;
            }
            
        
        } 
        else
            header("location: createproduct.php");
    } 
}
$con->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Practice</title>
    </head>

    <body>
        <form action="deleteproduct.php" method="post">
            <p class="prompt">Are you sure you want to delete product with details:</p>
            <table>
                <tr>
                    <td>
    					<input type="hidden" name="id" value="<?php echo $prospectid?>">
    				<td>
                </tr>
                <tr>
                    <td>Product Name:</td>
                    <td><p><?php echo $product_name ?></p></td>
                </tr>
                <tr>
                    <td>Product Description:</td>
                    <td><p><?php echo $product_description ?></p></td>
                </tr>
                <tr>
                    <td>Product Category:</td>
                    <td><select name="productCategory" disabled>
                	
                    <?php

                        for($i=1; $i<=sizeof($categories); $i++)
                        {
                            if ($i == $product_category) 
                            {
                                echo "<option value=\"$i\" selected=\"selected\">$categories[$i]</option>";
                                continue;
                            }

                            echo "<option value=\"$i\">$categories[$i]</option>";
                        }
                    ?>

                    </select></td>
                </tr>
                <tr>
                    <td>Product Intended for:</td>
                    <td>
                        <?php
                            if($product_targets == "CD")
                            {
                                echo "
                                    <label for=\"catCheckbox\">Cats: </label>
                                    <input type=\"checkbox\" name=\"catCheckbox\" checked disabled>
                                    <label for=\"dogCheckbox\">Dogs: </label>
                                    <input type=\"checkbox\" name=\"dogCheckbox\" checked disabled>
                                ";
                            }

                            elseif($product_targets == "C")
                            {
                                echo "
                                    <label for=\"catCheckbox\">Cats: </label>
                                    <input type=\"checkbox\" name=\"catCheckbox\" checked disabled>
                                    <label for=\"dogCheckbox\">Dogs: </label>
                                    <input type=\"checkbox\" name=\"dogCheckbox\" disabled>
                                ";
                            }

                            else
                            {
                                echo "
                                    <label for=\"catCheckbox\">Cats: </label>
                                    <input type=\"checkbox\" name=\"catCheckbox\" disabled>
                                    <label for=\"dogCheckbox\">Dogs: </label>
                                    <input type=\"checkbox\" name=\"dogCheckbox\" checked disabled>
                                ";
                            }
                                    
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitbtn" value="CONFIRM"></td>
                    <td><a href="createproduct.php">CANCEL</a></td>
                </tr>
            </table>
        </form>
    </body>
</html>