<!-- <?php
// session_start();
?> -->
<?php
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
$db = "animalark_db";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());

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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Practice</title>
    </head>

    <body>
        <a href="createproduct.php">BACK</a>
        <form action="viewallitems.php" method="post" enctype="multipart/form-data">
            <table>
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