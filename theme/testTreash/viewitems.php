<!-- <?php
// session_start();
?> -->
<?php
function getNumberOfItems($con) 
{
    $final_size = 0;
    $qry = "SELECT * FROM items";
    $result = $con->query($qry);
    $numrows = $result->num_rows;

    if($numrows != "" && $numrows != 0)
    {
        $final_size = $numrows;
        return $final_size;
    }

    return 0;
}

function getProductId($con)
{
    $qry = "SELECT * FROM items";
    $result = $con->query($qry);
    $numrows = $result->num_rows;

    if ($numrows != "" && $numrows != 0) 
    {
        for ($i = 1; $i <= $numrows; $i++)
        {

            $row = $result->fetch_assoc();
            extract($row);

            if($i == $numrows) 
                return $product_id;

            continue;
        }
    }
}

$productId = $itemVariation = $itemPrice = $itemStocks = $itemVisibility = $itemImage = $itemImageFilename = "";
$prospectproductid = $product_name = "";
$items_db_rows = 0;

$host = "localhost";
$user = "root";
$pass = "";
$db = "project";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());

if($_SERVER["REQUEST_METHOD"] == "POST")
{

    $itemProductId = $_POST['id'];
    $itemVariation = $_POST['itemVariation'];
    $itemPrice = $_POST['itemPrice'];
    $itemStocks = $_POST['itemStocks'];
    
    if($_POST['itemVisibility'] == "on")
        $itemVisibility = "Y";
    else
        $itemVisibility = "N";

    $itemImage = file_get_contents($_FILES["itemImage"]["tmp_name"]);
    $itemImageFilename = $_FILES["itemImage"]["name"];

    $qry = "INSERT INTO items (product_id, variation, image, image_filename, price, stocks, is_visible) VALUES(?, ?, ?, ?, ?, ?, ?)";

    if($sql = $con->prepare($qry)) 
    {
        $sql->bind_param("issssis", $param_productId, $param_variation, $param_image, $param_imageFilename, $param_price, $param_stocks, $param_isVisible);
        $param_productId = $itemProductId;
        $param_variation = $itemVariation;
        $param_image = $itemImage;
        $param_imageFilename = $itemImageFilename;
        $param_price = $itemPrice;
        $param_stocks = $itemStocks;
        $param_isVisible = $itemVisibility;

        if ($sql->execute() != "")
            header("location: viewitems.php");
    }

    $sql->close();
}

else
{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) 
    {
        $items_db_rows = getNumberOfItems($con);

        $productId = $_GET["id"];

        //retrieves the info to be displayed in the form fields
        $query = "SELECT * FROM products WHERE id='$productId'";
        $result = $con->query($query);
        $numrows = $result->num_rows;
        
        if($result != "") 
        {
            for($i=0; $i<$numrows; $i++) 
            {
                
                $row = $result->fetch_assoc();
                extract($row);
                
                $prospectproductid = $productId;
                $product_name = $name;

            }
            
        
        } 
        
        else
            header("location: createproduct.php");
    }

    else
    {
        $items_db_rows = getNumberOfItems($con);

        $productId = getProductId($con);

        //retrieves the info to be displayed in the form fields
        $query = "SELECT * FROM products WHERE id='$productId'";
        $result = $con->query($query);
        $numrows = $result->num_rows;
        
        if($result != "") 
        {
            for($i=0; $i<$numrows; $i++) 
            {
                
                $row = $result->fetch_assoc();
                extract($row);
                
                $prospectproductid = $productId;
                $product_name = $name;

            }
            
        
        } 
    }

}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Practice</title>
    </head>

    <body>
        <a href="createproduct.php">BACK</a>
        <form action="viewitems.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
    					<input type="hidden" name="id" value="<?php echo $prospectproductid?>">
    				<td>
                </tr>
                <tr>
                    <td>
    					<h2>Product: <?php echo "$product_name"; ?></h2>
    				<td>
                </tr>
                <tr>
                    <td>Item Variation:</td>
                    <td><input type="text" name="itemVariation"></td>
                </tr>
                <tr>
                    <td>Item Image:</td>
                    <td><input type="file" name="itemImage"></td>
                </tr>
                <tr>
                    <td>Item Price:</td>
                    <td><input type="text" name="itemPrice"></td>
                </tr>
                <tr>
                    <td>Item Stocks:</td>
                    <td><input type="number" name="itemStocks"></td>
                </tr>
                <tr>
                    <td>Is Item Visible?</td>
                    <td>
                        <input type="checkbox" name="itemVisibility" value="on">
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitbtn" value="SUBMIT"></td>
                </tr>
            </table>
        </form>

<?php

echo "
<table>
<tr>
    <th>Item Variation</th>
    <th>Item Image</th>
    <th>Item Price</th>
    <th>Item Stocks</th>
    <th>Item Visibility</th>
    <th> </th>
</tr>
";

//retrieving products from db
$qry = "SELECT * FROM items WHERE product_id='$prospectproductid'";
$result = $con->query($qry);
$numrows = $result->num_rows;

if($numrows != "" && $numrows != 0) 
{
    for ($i = 0; $i < $numrows; $i++) 
    {
        $row = $result->fetch_assoc();
        extract($row);
    
        if($is_visible != "Y")
        {
            echo "
            <tr style='background-color:gray'>";
        }
        else
            echo "
            <tr>";
    
        echo "
        <td>$variation</td>
        <td>";
    
        echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '" height=200"';
        
        echo "
        </td>
        <td>$price</td>
        <td>$stocks</td>
        <td>
            <a href=\"editItem.php?id=$id\">Edit Item</a>
            <a href=\"deleteItem.php?id=$id\">Delete Item</a>
        </td>
        </tr>";
    }
}

$con->close();
?>
</table>
</body>
</html>