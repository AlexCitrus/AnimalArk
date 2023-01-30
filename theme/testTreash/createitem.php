<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $productName = $_POST['itemName'];
    $productDescription = $_POST['itemDescription'];
    $productCategory = $_POST['itemCategory'];
    $productPetTarget = $_POST['itemTarget'];
    $itemVariations = $_POST['itemVariations'];
    $itemPrice = $_POST['itemPrice'];
    $itemStocks = $_POST['itemStocks'];

    if ($_POST['itemVisibility'] != "")
        $itemVisibility = true;

    echo "$productName, $productDescription, $productCategory, $productPetTarget, $itemVariations, $itemPrices, $itemStocks, $itemVisibility";

    // $image = file_get_contents($_FILES["imageFile"]["tmp_name"]);

    $qry = "INSERT INTO products (name, description, category, intended_for) VALUES(?, ?, ?, ?)";

    if($sql = $con->prepare($qry)) 
    {
        // $sql->bind_param("s", $param_image);
        // $param_image = $image;
        // $sql->execute();

        $sql->bind_param("ssss", $parameter_name, $parameter_description, $parameter_category, $parameter_intendedFor);
        $parameter_name = $productName;
        $parameter_description = $productDescription;
        $parameter_category = $productCategory;
        $parameter_intendedFor = $productPetTarget;

        if ($sql->execute() != "")
            echo "Success!";
    }

    $sql->close();

    
}

// Get product ID before creating specific items
$qry = "SELECT * FROM products WHERE name='$parameter_name'";
$result = $con->query($qry);
$row = $result->fetch_assoc();
extract($row);
$itemId = $id;

// Add item variation to items table
$image = file_get_contents($_FILES["imageFile"]["tmp_name"]);

// Get each variation
$variations = explode(',', $itemVariations);

for($i=0; $i<sizeof($variations); $i++)
{
    $qry = "INSERT INTO items (product_id, variation, price, stocks, image) VALUES(?, ?, ?, ?, ?)";

    if($sql = $con->prepare($qry)) 
    {
        // $sql->bind_param("s", $param_image);
        // $param_image = $image;
        // $sql->execute();

        $sql->bind_param("isdis", $parameter_productId, $parameter_variation, $parameter_price, $parameter_stocks, $parameter_image);
        // $parameter_productId = $itemId;
        $parameter_variation = $variations[$i];

        if ($sql->execute() != "")
            echo "Success!";
    }
}   
$sql->close();
?>