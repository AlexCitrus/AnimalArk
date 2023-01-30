<!-- <?php
// session_start();
?> -->
<?php
$productId = $itemVariation = $itemPrice = $itemStocks = $itemVisibility = $itemImage = "";

$host = "localhost";
$user = "root";
$pass = "";
$db = "project";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // $itemProductId = ;
    $itemVariation = $_POST['itemVariation'];
    $itemPrice = $_POST['itemPrice'];
    $itemStocks = $_POST['itemStocks'];
    
    if($_POST['itemVisibility'] == "on")
        $itemVisibility = "Y";
    else
        $itemVisibility = "N";

    $itemImage = file_get_contents($_FILES["itemImage"]["tmp_name"]);

    $qry = "INSERT INTO items (product_id, variation, image, price, stocks, is_visible) VALUES(?, ?, ?, ?, ?, ?)";

    if($sql = $con->prepare($qry)) 
    {
        $sql->bind_param("isssis", $param_productId, $param_variation, $param_image, $param_price, $param_stocks, $param_isVisible);
        $param_productId = $productId;
        $param_variation = $paramVariation;
        $param_image = $itemImage;
        $param_price = $itemPrice;
        $param_stocks = $itemStocks;
        $param_isVisible = $itemVisibility;
        $sql->execute();
    }

    $sql->close();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Practice</title>
    </head>

    <body>
        <form action="viewitems.php" method="post" enctype="multipart/form-data">
            <table>
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
                    <td><input type="text" name="itemStocks"></td>
                </tr>
                <tr>
                    <td>Is Item Visible?</td>
                    <td>
                        <input type="checkbox" name="isVisible" value="on">
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitbtn" value="SUBMIT"></td>
                </tr>
            </table>
        </form>
    </body>
</html>

<?php
echo "
<table>
<tr>
    <th>Product Name</th>
    <th>Item Variation</th>
    <th>Item Image</th>
    <th>Item Price</th>
    <th>Item Stocks</th>
    <th>Item Visibility</th>
    <th> </th>
</tr>
";

//retrieving products from db
$qry = "SELECT * FROM items";
$result = $con->query($qry);
$numrows = $result->num_rows;
for ($i = 0; $i < $numrows; $i++) 
{
    $row = $result->fetch_assoc();
    extract($row);

    echo "
    <tr>
        // <td>$product_id</td>
        <td>$variation</td>
        <td>$image</td>
        <td>$price</td>
        <td>$stocks</td>";

    echo "
        <td>$is_visible</td>
        <td>
            <a href=\"edititem.php?id=$id\">Edit Item</a>
            <a href=\"deleteitem.php?id=$id\">Delete Item</a>
        </td>
    </tr>";
}
?>