<?php
// Classes
class Product
{
    private $productId;
    private $productName;
    private $productDescription;
    private $productBrand;

    function __construct($productId, $productName, $productDescription, $productBrand) 
    {
        $this->productId = $productId;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->productBrand = $productBrand;
    }

    function getId() 
    {
        return $this->productId;
    }

    function getName() 
    {
        return $this->productName;
    }

    function getDescription() 
    {
        return $this->productDescription;
    }

    function getBrand() 
    {
        return $this->productBrand;
    }
}

class Item extends Product
{
    private $itemId;
    private $itemName;
    private $itemPrice;
    private $itemSize;
    private $itemStocks;

    function __construct($itemId, $itemName, $itemPrice, $itemSize, $itemStocks) 
    {
        $this->itemId = $itemId;
        $this->itemName = $itemName;
        $this->itemPrice = $itemPrice;
        $this->itemSize = $itemSize;
        $this->itemStocks = $itemStocks;
    }

    function getId() 
    {
        return $this->itemId;
    }

    function getName() 
    {
        return $this->itemName;
    }

    function getPrice() 
    {
        return $this->itemPrice;
    }

    function getStocks() 
    {
        return $this->itemStocks;
    }
}

// Code for connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "test_blob1";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());


// Code for add
// add for info
$qry = "INSERT INTO prospects (firstname, lastname, birthday, zodiac, linkedto) VALUES (?, ?, ?, ?, ?)";
    
if($sql = $con->prepare($qry)) 
{
    $sql->bind_param("sssss", $param_firstname, $param_lastname, $param_birthday, $param_zodiac, $param_linkedto);
    
    $param_firstname = $firstname;
    $param_lastname = $lastname;
    $param_birthday = $person->birthday;
    $param_zodiac = $person->zodiac->sign;
    $param_linkedto = $user;
    
    if($sql->execute()) 
        header("location: prospects.php");
    else 
    {
        print '<script>alert("Oops something went wrong! Please try again later.");</script>';
        print '<script>window.location.assign("home.php");</script>';
    }
    
}
$sql->close();

// add for images
$image = file_get_contents($_FILES["f1"]["tmp_name"]);

$qry = "INSERT INTO table2 VALUES(?)";

if($sql = $con->prepare($qry)) 
{
    $sql->bind_param("s", $param_image);
    $param_image = $image;
    $sql->execute();
}

$sql->close();


// Code for retrieval
// display details
$qry = "SELECT * FROM prospects WHERE linkedto='$user'";
$result = $con->query($qry);
$numrows = $result->num_rows;
for($i=0; $i<$numrows; $i++) {
    $row = $result->fetch_assoc();
    extract($row);

    echo "
    <tr>
        <td class=\"dbtable\"></td>
        <td class=\"dbtable\"></td>
        <td class=\"dbtable\"></td>
        <td class=\"dbtable\"></td>
        <td class=\"dbtable\">
            <a class=\"action\" href=\"read.php?id=\">View</a>
            <a class=\"action\" href=\"edit.php?id=\">Edit</a>
            <a class=\"action\" href=\"delete.php?id=\">Delete</a>
        </td>
    </tr>";
}

// display images
$qry = "SELECT * FROM table2";
    
$result = $con->query($qry);
$numrows = $result->num_rows;

echo " <table>
            <tr>";

for($i=0; $i<$numrows; $i++) 
{
    $row = $result->fetch_row();
    echo "<td>";
    echo '<img src="data:image/jpeg;base64,' . base64_encode($row[0]) . '" height="300"';
    echo "</td>";
}

echo "      </tr>
        </table>";


// Code for update
// if(isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
//     $id = $_GET["id"];

$query = "SELECT * FROM prospects WHERE id=''";
$result = $con->query($query);
$numrows = $result->num_rows;

if($result != "") 
{
    for($i=0; $i<$numrows; $i++) 
    {
        $row = $result->fetch_assoc();
        extract($row);
        
        $prospectid = $id;
        $fname = $firstname;
        $lname = $lastname;
        $bday = $birthday;
    }
} 

else
    header("location: prospects.php");


$qry = "UPDATE prospects SET firstname=?, lastname=?, birthday=?, zodiac=? WHERE id=?";
    
if($sql = $con->prepare($qry)) 
{
    $sql->bind_param("ssssi", $param_firstname, $param_lastname, $param_birthday, $param_zodiac, $param_id);
    
    $param_firstname = $firstname;
    $param_lastname = $lastname;
    $param_birthday = $person->birthday;
    $param_zodiac = $person->zodiac->sign;
    $param_id = $id;
    
    
    if($sql->execute())
        header("location: prospects.php");
    else 
        echo "Oops! Something went wrong. Please try again later.";

    $sql->close();  
}


// Code for delete
$qry = "DELETE FROM prospects WHERE id = ?";

if ($sql = $con->prepare($qry)) 
{
    $sql->bind_param("i", $param_id);

    $param_id = $id;

    if ($sql->execute())
        header("location: prospects.php");
    else
        echo "Oops! Something went wrong. Please try again later.";

    $sql->close();
}
?>