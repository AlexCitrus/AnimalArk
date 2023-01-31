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
$name = $description = $category = $targetPets = "";
$categories = array();

$host = "localhost";
$user = "root";
$pass = "";
$db = "animalark_db";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());

$categories = getCategories($con);

if(isset($_POST["id"]) && !empty($_POST["id"]))
{
    $id = $_POST["id"];
    
    $name = $_POST['productName'];
    $description = $_POST['productDescription'];
    $category = $_POST['productCategory'];
    
    if($catCheckbox == "on" && $dogCheckbox == "on")
        $petTarget = "CD";
    elseif ($catCheckbox == "on" && $dogCheckbox != "on")
        $petTarget = "C";
    else
        $petTarget = "D";

    //updates the db
    $qry = "UPDATE products SET name=?, description=?, category_id=?, intended_for=? WHERE id=?";
    
    if($sql = $con->prepare($qry)) 
    {
        $sql->bind_param("ssisi", $param_name, $param_description, $param_category, $param_target, $param_id);
        
        $param_name = $name;
        $param_description = $description;
        $param_category = $category;
        $param_target = $petTarget;
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
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) 
    {
        $id = $_GET["id"];
        //retrieves the info to be displayed in the form fields
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
        <form action="editproduct.php" method="post">
            <table>
                <tr>
                    <td>
    					<input type="hidden" name="id" value="<?php echo $prospectid?>">
    				<td>
                </tr>
                <tr>
                    <td>Product Name:</td>
                    <td><input type="text" name="productName" value="<?php echo $product_name ?>"></td>
                </tr>
                <tr>
                    <td>Product Description:</td>
                    <td><textarea name="productDescription" rows="10" cols="50"><?php echo $product_description ?></textarea></td>
                </tr>
                <tr>
                    <td>Product Category:</td>
                    <td><select name="productCategory">
                	
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
                                    <input type=\"checkbox\" name=\"catCheckbox\" checked>
                                    <label for=\"dogCheckbox\">Dogs: </label>
                                    <input type=\"checkbox\" name=\"dogCheckbox\" checked>
                                ";
                            }

                            elseif($product_targets == "C")
                            {
                                echo "
                                    <label for=\"catCheckbox\">Cats: </label>
                                    <input type=\"checkbox\" name=\"catCheckbox\" checked>
                                    <label for=\"dogCheckbox\">Dogs: </label>
                                    <input type=\"checkbox\" name=\"dogCheckbox\">
                                ";
                            }

                            else
                            {
                                echo "
                                    <label for=\"catCheckbox\">Cats: </label>
                                    <input type=\"checkbox\" name=\"catCheckbox\">
                                    <label for=\"dogCheckbox\">Dogs: </label>
                                    <input type=\"checkbox\" name=\"dogCheckbox\" checked>
                                ";
                            }
                                
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitbtn" value="SUBMIT"></td>
                    <td><a href="createproduct.php">BACK</a></td>
                </tr>
            </table>
        </form>
    </body>
</html>