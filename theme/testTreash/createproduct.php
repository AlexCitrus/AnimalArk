<!-- <?php
// session_start();
?> -->
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

$productName = $productDescription = $productCategory = $productPetTarget = "";
$categories = array();

$host = "localhost";
$user = "root";
$pass = "";
$db = "animalark_db";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());

$categories = getCategories($con);

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $productName = $_POST['productName'];
    $productDescription = $_POST['productDescription'];
    $productCategory = $_POST['productCategory'];
    // $productPetTarget = $_POST['productTarget'];
    $catCheckbox = $_POST['catCheckbox'];
    $dogCheckbox = $_POST['dogCheckbox'];

    if($catCheckbox == "on" && $dogCheckbox == "on")
        $productPetTarget = "CD";
    elseif ($catCheckbox == "on" && $dogCheckbox != "on")
        $productPetTarget = "C";
    else
        $productPetTarget = "D";

    $qry = "INSERT INTO products (name, description, category_id, intended_for) VALUES(?, ?, ?, ?)";

    if($sql = $con->prepare($qry)) 
    {
        $sql->bind_param("ssis", $parameter_name, $parameter_description, $parameter_category, $parameter_intendedFor);
        $parameter_name = $productName;
        $parameter_description = $productDescription;
        $parameter_category = $productCategory;
        $parameter_intendedFor = $productPetTarget;

        if ($sql->execute() != "")
            header("location: createproduct.php");
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
        <form action="" method="post">
            <table>
                <tr>
                    <td>Product Name:</td>
                    <td><input type="text" name="productName"></td>
                </tr>
                <tr>
                    <td>Product Description:</td>
                    <td><textarea name="productDescription" rows="10" cols="50"></textarea></td>
                </tr>
                <tr>
                    <td>Product Category:</td>
                    <!-- <td><input type="text" name="productCategory"></td> -->
                    <td><select name="productCategory">
                        <option hidden disabled selected></option>
                	
                    <?php
                        for($i=1; $i<=sizeof($categories); $i++)
                        {
                        echo "
                            <option value=\"$i\">$categories[$i]</option>
                            ";
                        }
                    ?>

                    </select></td>
                </tr>
                <tr>
                    <td>Product Intended for:</td>
                    <td>
                        <label for="catCheckbox">Cats: </label>
                        <input type="checkbox" name="catCheckbox">
                        <label for="dogCheckbox">Dogs: </label>
                        <input type="checkbox" name="dogCheckbox">
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="submitbtn"></td>
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
    <th>Product Description</th>
    <th>Product Category</th>
    <th>Target Pets</th>
    <th> </th>
</tr>
";

//retrieving products from db
$qry = "SELECT * FROM products";
$result = $con->query($qry);
$numrows = $result->num_rows;
for ($i = 0; $i < $numrows; $i++) 
{
    $row = $result->fetch_assoc();
    extract($row);

    echo "
    <tr>
        <td>$name</td>
        <td>$description</td>
        <td>$categories[$category_id]</td>
        <td>$intended_for</td>
        <td>
            <a href=\"viewitems.php?id=$id\">View Items</a>
            <a href=\"editproduct.php?id=$id\">Edit Product</a>
            <a href=\"deleteproduct.php?id=$id\">Delete Product</a>
        </td>
    </tr>";
}
?>