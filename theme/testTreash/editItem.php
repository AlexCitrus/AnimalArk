<?php

function getProductName($con, $product_id)
{
    $query = "SELECT * FROM products WHERE id='$product_id'";
    $result = $con->query($query);
    $numrows = $result->num_rows;
    
    if($result != "") 
    {
        for($i=0; $i<$numrows; $i++) 
        {
            $row = $result->fetch_assoc();
            extract($row);

            return $name;
        }
    } 
}

function getItemImage($con, $id)
{
    $query = "SELECT * FROM items WHERE id='$id'";
    $result = $con->query($query);
    $numrows = $result->num_rows;
    
    if($result != "") 
    {
        for($i=0; $i<$numrows; $i++) 
        {
            $row = $result->fetch_assoc();
            extract($row);

            return $image;
        }
    } 
}

function getItemImageFilename($con, $id)
{
    $query = "SELECT * FROM items WHERE id='$id'";
    $result = $con->query($query);
    $numrows = $result->num_rows;
    
    if($result != "") 
    {
        for($i=0; $i<$numrows; $i++) 
        {
            $row = $result->fetch_assoc();
            extract($row);

            return $image_filename;
        }
    } 
}

// $productId = $itemVariation = $itemPrice = $itemStocks = $itemVisibility = $itemImage = "";
// $product_id = $variation = $price = $stocks = $visibility = $image = "";
$item_variation = $item_image = $item_image_filename = $item_price = $item_visibility = "";
$itemVariation = $itemImage = $itemPrice = $itemVisibility = "";
$prospectid = $prospectproductid  = $id = $item_stocks = $itemStocks = 0;

$host = "localhost";
$user = "root";
$pass = "";
$db = "project";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());

if(isset($_POST["id"]) && !empty($_POST["id"]))
{
    echo "debug";
    echo $item_image_filename;

    $itemId = $_POST['id'];
    $itemVariation = $_POST['itemVariation'];
    $itemPrice = $_POST['itemPrice'];
    $itemStocks = $_POST['itemStocks'];

    echo "before visibility";

    if($_POST['itemVisibility'] == "on")
        $itemVisibility = "Y";
    else
        $itemVisibility = "N";

    // if($_FILES['itemImage']['error'] > 0)
    if(empty($_FILES['itemImage']))
    {
        echo "empty file";

        $itemImage = getItemImage($con, $itemId);
        $itemImageFilename = getItemImageFilename($con, $itemId);
    }

    else
    {
        echo "file is not empty";
        $itemImage = file_get_contents($_FILES["itemImage"]["tmp_name"]);
        echo "after file_get_contents";
        $itemImageFilename = $_FILES["itemImage"]["name"];

    }

    echo $itemImageFilename;

    echo "before query";
    //updates the db
    $qry = "UPDATE items SET variation=?, image=?, image_filename=?, price=?, stocks=?, is_visible=? WHERE id=?";

    echo $qry;
    if ($sql = $con->prepare($qry)) {
        echo "test";
        $sql->bind_param("ssssisi", $param_variation, $param_image, $param_image_filename, $param_price, $param_stocks, $param_visibility, $param_id);

        $param_variation = $itemVariation;
        $param_image = $itemImage;
        $param_image_filename = $itemImageFilename;
        $param_price = $itemPrice;
        $param_stocks = $itemStocks;
        $param_visibility = $itemVisibility;
        $param_id = $itemId;

        if ($sql->execute())
            header("location: viewitems.php");
        else
            echo "Oops! Something went wrong. Please try again later.";

    }
    $sql->close();
    
} 

else
{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) 
    {
        $id = $_GET["id"];
        //retrieves the info to be displayed in the form fields
        $query = "SELECT * FROM items WHERE id='$id'";
        $result = $con->query($query);
        $numrows = $result->num_rows;
        
        if($result != "") 
        {
            for($i=0; $i<$numrows; $i++) 
            {
                
                $row = $result->fetch_assoc();
                extract($row);
                
                $prospectid = $id;
                $prospectproductid = $product_id;
                $item_variation = $variation;
                $item_image = $image;
                $item_image_filename = $image_filename;
                $item_price = $price;
                $item_stocks = $stocks;
                $item_visibility = $is_visible;

            }
            
        
        } 
        
        else
            header("location: viewitems.php");

        $product_name = getProductName($con, $prospectproductid);
    }

}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Practice</title>
    </head>

    <body>
        <form action="editItem.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
    					<input type="hidden" name="id" value="<?php echo $prospectid; ?>">
    				<td>
                </tr>
                <tr>
                    <td><h2>Product Name: </h2></td>
                    <td><h2><?php echo $product_name; ?></h2></td>
                </tr>
                <tr>
                    <td>Item Variation:</td>
                    <td><input type="text" name="itemVariation" value="<?php echo $item_variation; ?>"></td>
                </tr>
                <tr>
                    <td>Item Image:</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Current Image:</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <?php
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($item_image) . '" height=200"';
                        ?>
                    </td>
                    <td><p><?php echo $item_image_filename; ?></p></td>
                </tr>
                <tr>
                    <td></td>
                    <td>New Image:</td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="file" name="itemImage"></td>
                </tr>
                <tr>
                    <td>Item Price:</td>
                    <td><input type="text" name="itemPrice" value="<?php echo $item_price; ?>"></td>
                </tr>
                <tr>
                    <td>Item Stocks:</td>
                    <td><input type="number" name="itemStocks" value="<?php echo $item_stocks; ?>"></td>
                </tr>
                <tr>
                    <td>Is Item Visible?</td>
                    <td>
                        <?php
                            if($item_visibility == "Y")
                                echo "<input type=\"checkbox\" name=\"itemVisibility\" checked>";
                            else
                                echo "<input type=\"checkbox\" name=\"itemVisibility\">";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitbtn" value="SUBMIT"></td>
                    <td><a href="viewitems.php">BACK</a></td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php
$con->close();
?>