<?php
class Product 
{
  public $productId;
  public $productName;
  public $categoryId;
  public $intendedFor;
  public $description;
  public $variations;

  function __construct($productId, $productName, $category, $intendedFor, $description, $variations)
  {
    $this->productId = $productId;
    $this->productName = $productName;
    $this->categoryId = $category;
    $this->intendedFor = $intendedFor;
    $this->description = $description;
    $this->variations = $variations;
  }
}

class Item
{
  public $itemId;
  public $itemVariation;
  public $itemImage;
  public $itemPrice;
  public $itemStocks;

  function __construct($itemId, $itemVariation, $itemImage, $itemPrice, $itemStocks) 
  {
    $this->itemId = $itemId;
    $this->itemVariation = $itemVariation;
    $this->itemImage = $itemImage;
    $this->itemPrice = $itemPrice;
    $this->itemStocks = $itemStocks;
  }
}

function getProducts($con, $category, $intendedFor)
{
  
  $products = array();
  $variations = array();
  $groupingCondition = "";

  if ($intendedFor == 'C')
    $groupingCondition = "intended_for LIKE 'C%'";
  else
    $groupingCondition = "(intended_for LIKE 'D' OR intended_for LIKE '%D')";
  

  $qry = "SELECT * FROM products WHERE category_id='$category' AND $groupingCondition";
  $result = $con->query($qry);
  $numrows = $result->num_rows;

  if ($numrows != "" && $numrows != 0) 
  {
      for ($i = 1; $i <= $numrows; $i++)
      {

        $row = $result->fetch_assoc();
        extract($row);
        $categoryName = getCategory($con, $category);
        $variations = getItems($con, $id);

        $product = new Product($id, $name, $categoryName, $intended_for, $description, $variations);

        array_push($products, $product);
      }
  }

  return $products;
}

function getCategory($con, $category_id)
{
  $qry = "SELECT * FROM categories WHERE id='$category_id'";
  $result = $con->query($qry);
  $numrows = $result->num_rows;

  if ($numrows != "" && $numrows != 0) 
  {
      for ($i = 1; $i <= $numrows; $i++)
      {

        $row = $result->fetch_assoc();
        extract($row);

        return $category;
      }
  }
}

function getItems($con, $product_id)
{
  $items = array();

  $qry = "SELECT * FROM items WHERE product_id='$product_id'";
  $result = $con->query($qry);
  $numrows = $result->num_rows;
  
  if ($numrows != "" && $numrows != 0) 
  {
      for ($i = 1; $i <= $numrows; $i++)
      {
        $row = $result->fetch_assoc();
        extract($row);

        $item = new Item($id, $variation, $image, $price, $stocks);
        array_push($items, $item);
      }
  }

  return $items;
}

function getItem($con, $item_id)
{
  $qry = "SELECT * FROM items WHERE id='$item_id'";
  $result = $con->query($qry);
  $numrows = $result->num_rows;
  if ($numrows != "" && $numrows != 0) 
  {
      for ($i = 0; $i < $numrows; $i++)
      {
        $item = $result->fetch_assoc();
        return $item;
      }
  }
}

function getProduct($con, $product_id)
{
    $variations = array();
    $qry = "SELECT * FROM products WHERE id='$product_id'";
    $result = $con->query($qry);
    $numrows = $result->num_rows;
    
    if ($numrows != "" && $numrows != 0) 
    {
        for ($i = 1; $i <= $numrows; $i++)
        {
          $row = $result->fetch_assoc();
          extract($row);
        //   $categoryName = getCategory($con, $category_id);
          $variations = getItems($con, $id);
  
          $product = new Product($id, $name, $category_id, $intended_for, $description, $variations);
  
          return $product;
        }
    }
}
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
    //deletion process

    $qry = "DELETE FROM products WHERE id = ?";
    
    if($sql = $con->prepare($qry)) 
    {
        $sql->bind_param("i", $param_id);

        $param_id = $id;
        
        if($sql->execute())
            header("location: admin_shop.php");
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
        //displays the info of to be deleted prospect
        // $query = "SELECT * FROM products WHERE id='$id'";
        // $result = $con->query($query);
        // $numrows = $result->num_rows;
        
        // if($result != "") 
        // {
        //     for($i=0; $i<$numrows; $i++) 
        //     {
        //         $row = $result->fetch_assoc();
        //         extract($row);
                
        //         $prospectid = $id;
        //         $product_name = $name;
        //         $product_description = $description;
        //         $product_category = $category_id;
        //         $product_targets = $intended_for;
        //     }
            
        
        // } 
        // else
        //     header("location: admin_shop.php");
        $product = getProduct($con, $id);
        $prospectid = $product->productId;
        $product_name = $product->productName;
        $product_description = $product->description;
        $product_category = $product->categoryId;
        $product_targets = $product->intendedFor;
        $product_items = $product->variations;
    }
        else
          header("location: admin_shop.php");

}

$con->close();
?>

<!DOCTYPE html>
<html lang="zxx">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta
      name="description"
      content="Orbitor,business,company,agency,modern,bootstrap4,tech,software"
    />
    <meta name="author" content="themefisher.com" />

    <!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, maximum-scale=1"
    />

    <!-- theme meta -->
    <meta name="theme-name" content="orbitor-bulma" />

    <title>Animal Ark</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

    <!-- bootstrap.min css -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.4/css/bulma.min.css"
      integrity="sha512-HqxHUkJM0SYcbvxUw5P60SzdOTy/QVwA1JJrvaXJv4q7lmbDZCmZaqz01UPOaQveoxfYRv1tHozWGPMcuTBuvQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- Icon Font Css -->
    <link rel="stylesheet" href="plugins/themify/css/themify-icons.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
      integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      rel="stylesheet"
      href="plugins/magnific-popup/dist/magnific-popup.css"
    />
    <link rel="stylesheet" href="plugins/modal-video/modal-video.css" />
    <link rel="stylesheet" href="plugins/animate-css/animate.css" />
    <!-- Slick Slider  CSS -->
    <link rel="stylesheet" href="plugins/slick-carousel/slick/slick.css" />
    <link
      rel="stylesheet"
      href="plugins/slick-carousel/slick/slick-theme.css"
    />

    <!-- Main Stylesheet -->
    <!-- <link rel="stylesheet" href="css/style.css" /> -->
    <link rel="stylesheet" href="css/edit_item.css" />
  </head>

  <body>
    <!-- navigation -->
    <div id="navbar" class="navigation py-4">
      <div class="container">
        <nav class="navbar">
          <div class="navbar-brand">
            <a class="navbar-item mr-5" href="admin_home.html">
              <img src="images/logo.png" width="200" alt="logo" />
            </a>
          </div>

          <div class="navbar-menu" id="navigation">
            <ul class="navbar-start">
              <li class="navbar-item">
                <a class="navbar-link" href="admin_home.html">Home</a>
              </li>

              <li class="navbar-item">
                <a class="navbar-link" href="ani_shop.html">Products</a>
              </li>

              <li class="navbar-item">
                <a class="navbar-link" href="">FAQ</a>
              </li>
            </ul>
            <ul class="navbar-end ml-0">
              <li class="navbar-item">
                <a href="./login.html" class="btn btn-solid-border"
                  >Log-in <i class="fa fa-angle-right ml-2"></i
                ></a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>
    <br>
    <br>


    <div class="formbold-main-wrapper">
        <div class="formbold-form-wrapper">    
          <!-- <form action="https://formbold.com/s/FORM_ID" method="POST"> -->
            <form action="delete_prod.php" method="POST">
            <div class="formbold-form-title">
              <h2 class="">Delete Product</h2>
              <p class="prompt">Are you sure you want to delete product with details:</p>
            </div>
            <input type="hidden" name="id" value="<?php echo $prospectid; ?>">
            <div class="formbold-mb-3">
              <label for="productName" class="formbold-form-label">Product Name</label>
              <input type="text" name="productName" id="productName" class="formbold-form-input" value="<?php echo $product_name; ?>" disabled>
            </div>
      
            <div class="formbold-mb-3"> 
              <label for="productDescription" class="formbold-form-label">Product Description</label>
              <textarea  class="formbold-form-prod_desc" id="productDescription" name="productDescription" rows="10" cols="50" disabled><?php echo $product_description; ?></textarea>
            </div>

            <div class="formbold-mb-3"> 
              <label for="productVariants" class="formbold-form-label">Product Variants</label>
              <?php
                foreach($product_items as $item) 
                {
                  $item_id = $item->itemId;
                  $item_variation = $item->itemVariation;
              
                  echo "
                      <a href=\"delete_item.php?id=$item_id\" class=\"btn btn-solid-border\">$item_variation</a>
                  ";
                }
              ?>
            </div>

            <div class="formbold-mb-3">
                <label for="productCategory" class="formbold-form-label">Category</label>
                <select name="productCategory" id="productCategory" class="formbold-form-input" disabled>
                    <option hidden disabled selected></option>
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
                </select>
              </div>

            <div class="formbold-mb-3" style="color: black;">
                <label for="checkboxes" class="formbold-form-label">Product Intended for:</label>
                <?php
                    if($product_targets == "CD")
                    {
                        echo "
                            <input type=\"checkbox\" name=\"catCheckbox\" checked disabled> Cats
                            <input type=\"checkbox\" name=\"dogCheckbox\" checked disabled> Dogs
                        ";
                    }

                    elseif($product_targets == "C")
                    {
                        echo "
                            <input type=\"checkbox\" name=\"catCheckbox\" checked disabled> Cats
                            <input type=\"checkbox\" name=\"dogCheckbox\" disabled> Dogs
                        ";
                    }

                    else
                    {
                        echo "
                            <input type=\"checkbox\" name=\"catCheckbox\" disabled> Cats
                            <input type=\"checkbox\" name=\"dogCheckbox\" checked disabled> Dogs
                        ";
                    }
                        
                ?>
            </div>

            <div class="formbold-checkbox-wrapper">
              </div>
    
            <!-- <input type="submit" name="submitbtn" class="formbold-btn" value="Submit"> -->
            <!-- <button class="formbold-btn"disabled>Submit</button> -->
            <!-- <?php
              if(sizeof($product_items) > 0)
                echo "<button class=\"formbold-btn\" disabled>Submit</button>";
              else
                echo "<button class=\"formbold-btn\">Submit</button>";
            ?> -->
          </form>
          <br/>
          <br/>
          <a href="admin_shop.php"> <button type="submit">Cancel</button> </a>
        </div>
      </div>



    <br>
    <br>
    <br>
    <br>
    <br>
    <!-- footer Start -->
    <footer class="footer section">
      <div class="container">
        <div class="columns is-multiline">
          <div class="column is-3-widescreen is-6-tablet">
            <div class="widget">
              <div class="logo mb-4">
                <h3>Animal Ark</h3>
              </div>
              <p>
                Animal Ark Pet Care Center is a one-stop shop for all your pet needs.
                We offer a wide variety of pet supplies as well as a full range of services
                veterinary care.
              </p>
            </div>
          </div>
          <div class="column is-2-widescreen is-6-desktop is-6-tablet ml-auto">
            <div class="widget">
              <h4 class="is-capitalize mb-4">Company</h4>

              <ul class="list-unstyled footer-menu lh-35">
                <a href="#">About</a>
              </ul>
            </div>
          </div>
          <div class="column is-3-widescreen is-6-desktop is-6-tablet">
            <div class="widget">
              <h4 class="is-capitalize mb-4">Support</h4>

              <ul class="list-unstyled footer-menu lh-35">
                <li><a href="FAQs.html">FAQ</a></li>
              </ul>
            </div>
          </div>
          <div class="column is-3-widescreen is-6-desktop is-6-tablet">
            <div class="widget widget-contact">
              <h4 class="is-capitalize mb-4">Get in Touch</h4>
              <h6>
                <a href="animalarkpetcenter@gmail.com">
                  <i class="ti-headphone-alt mr-3"></i>animalarkpetcenter@gmail.com</a
                >
              </h6>


              <ul class="list-inline footer-socials mt-5">
                <li class="list-inline-item">
                  <a href="https://www.facebook.com/animalarkpetcarecenter"
                    ><i class="ti-facebook mr-2"></i
                  ></a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="footer-btm py-4 mt-6">
          <div class="columns">
            <div class="column is-6-widescreen">
              <div class="copyright">
                &copy; Copyright Reserved to
                <span class="text-color">Animal Ark</span> by
                <a href="https://themefisher.com/" target="_blank"
                  >Kenya</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- 
    Essential Scripts
    =====================================-->

    <!-- Main jQuery -->
    <script src="plugins/jquery/jquery.js"></script>
    <script src="js/contact.js"></script>
    <!--  Magnific Popup-->
    <script src="plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
    <!-- Slick Slider -->
    <script src="plugins/slick-carousel/slick/slick.min.js"></script>
    <!-- Counterup -->
    <script src="plugins/counterup/jquery.waypoints.min.js"></script>
    <script src="plugins/counterup/jquery.counterup.min.js"></script>

    <script src="plugins/modal-video/modal-video.js"></script>
    <!-- Google Map -->
    <script src="plugins/google-map/map.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAkeLMlsiwzp6b3Gnaxd86lvakimwGA6UA&callback=initMap"></script>

    <script src="js/script.js"></script>


      <!-- Script for image -->
    <script>
      const input = document.querySelector("#image");
      const preview = document.querySelector("#preview");

      input.addEventListener("change", function() {
        const file = this.files[0];

        if (file) {
          const reader = new FileReader();

          reader.addEventListener("load", function() {
            preview.src = reader.result;
          });

          reader.readAsDataURL(file);
        } else {
          preview.src = "#";
        }
      });
    </script>







  </body>
</html>
