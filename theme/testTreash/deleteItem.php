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

$item_variation = $item_image = $item_image_filename = $item_price = $item_visibility = "";
$itemVariation = $itemImage = $itemPrice = $itemVisibility = "";
$prospectid = $prospectproductid  = $id = $item_stocks = $itemStocks = 0;

$host = "localhost";
$user = "root";
$pass = "";
$db = "animalark_db";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());

if(isset($_POST["id"]) && !empty($_POST["id"]))
{
    $id = $_POST["id"];
    //deletion process

    $qry = "DELETE FROM items WHERE id = ?";
    
    if($sql = $con->prepare($qry)) 
    {
        $sql->bind_param("i", $param_id);

        $param_id = $id;
        
        if($sql->execute())
            header("location: viewitems.php");
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
            
            $product_name = getProductName($con, $prospectproductid);
        } 
        else
            header("location: viewitems.php");
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
        <form action="deleteItem.php" method="post">
            <p class="prompt">Are you sure you want to delete item with details:</p>
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
                    <td><p><?php echo $item_variation; ?></p></td>
                </tr>
                <tr>
                    <td>Item Image:</td>
                    <td>
                        <?php
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($item_image) . '" height=200"';
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Item Price:</td>
                    <td><p><?php echo $item_price; ?></p></td>
                </tr>
                <tr>
                    <td>Item Stocks:</td>
                    <td><p><?php echo $item_stocks; ?></p></td>
                </tr>
                <tr>
                    <td>Is Item Visible?</td>
                    <td>
                        <?php
                            if($item_visibility == "Y")
                                echo "<input type=\"checkbox\" name=\"itemVisibility\" checked disabled>";
                            else
                                echo "<input type=\"checkbox\" name=\"itemVisibility\" disabled>";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitbtn" value="CONFIRM"></td>
                    <td><a href="viewitems.php">CANCEL</a></td>
                </tr>
            </table>
        </form>
    </body>
</html>