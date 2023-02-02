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

  $qry = "SELECT * FROM items WHERE product_id='$product_id' AND is_visible='Y'";
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

function displayProductVariations($product, $forNavigation) 
{
  $items = $product->variations;
  $product_id = $product->productId;
  
  foreach($items as $item) 
  {
    $item_id = $item->itemId;
    $item_variation = $item->itemVariation;
    $item_image = $item->itemImage;
    $item_price = $item->itemPrice;
    $item_stocks = $item->itemStocks;

    $base64Image = base64_encode($item_image);

    echo "
    <a href=\"cust_proddetails.php?id=$product_id&item_id=$item_id&navigation=$forNavigation\">
      <img src=\"data:image/jpeg;base64,$base64Image\" height=\"85\" width=\"85\"/></a>
    ";
  }
}

function imageDisplay($image) {
  echo '<img src="data:image/jpeg;base64,' . base64_encode($image) . '"/>';
}

$host = "localhost";
$user = "root";
$pass = "";
$db = "animalark_db";

$con = new mysqli($host, $user, $pass, $db);
if($con === false) 
    die('Couldn\'t connect: ' . $con->connect_errno());

// if(isset($_GET["category_id"]) && !empty(trim($_GET["category_id"])))
// {
    $productId = $_GET['id'];
    $itemId = $_GET['item_id'];
    $forNavigation = $_GET['navigation'];
// }
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
    <link rel="stylesheet" href="plugins/fontawesome/css/all.css" />
    <link rel="stylesheet" href="plugins/magnific-popup/dist/magnific-popup.css"/>
    <link rel="stylesheet" href="plugins/modal-video/modal-video.css" />
    <link rel="stylesheet" href="plugins/animate-css/animate.css" />

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="css/style.css" />

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	  <link href="css/main.css" rel="stylesheet">
	  <link href="css/responsive.css" rel="stylesheet">
    
  </head>

  <body>
    <!-- navigation -->
    <div id="navbar" class="navigation py-4">
      <div class="container">
        <nav class="navbar">
          <div class="navbar-brand">
            <a class="navbar-item mr-5" href="index.php">
              <img src="images/logo.png" width="200" alt="logo" />
            </a>
            <button
              role="button"
              class="navbar-burger burger"
              data-hidden="true"
              data-target="navigation"
            >
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </button>
          </div>

          <div class="navbar-menu" id="navigation">
            <ul class="navbar-start">
              <li class="navbar-item">
                <a class="navbar-link" href="index.php">Home</a>
              </li>

              <li class="navbar-item">
                <a class="navbar-link" href="about.html">Products</a>
              </li>

              <li class="navbar-item">
                <a class="navbar-link" href="project.html">FAQ</a>
              </li>
            </ul>
            <ul class="navbar-end ml-0">
              
              <li class="navbar-item">
                <a href="login.html" class="btn btn-solid-border"
                  >Log-in <i class="fa fa-angle-right ml-2"></i
                ></a>
              </li>
            </ul>
          </div>
        </nav>
      </div>
    </div>

    </br>
    </br>
    </br>
    </br>
    </br>
    </br>

    <form>
        <input type="text" placeholder="Search...">
        <button type="submit">Search</button>
    </form>



    </br>
    </br>
    </br>

    <section>
      <div class="container">
        <div class="row">
          <div class="col-sm-3">
            <div class="left-sidebar">
              <h2>Category</h2>
              <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a href="cust_shop.php">All Products</a>
                    </h4>
                    <br/>
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                        Cat Shop
                      </a>
                    </h4>
                  </div>
                  <div id="sportswear" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <ul>
                        <li><a href="shop_prodbycategory.php?category_id=1&intendedFor=C">Cat Food and Treats</a></li>
                        <li><a href="shop_prodbycategory.php?category_id=5&intendedFor=C">Cat Vitamins</a></li>
                        <li><a href="shop_prodbycategory.php?category_id=2&intendedFor=C">Cat Medications and Others</a></li>
                        <li><a href="shop_prodbycategory.php?category_id=3&intendedFor=C">Cat Shampoo and Soap</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#accordian" href="#mens">
                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                        Dog Shop
                      </a>
                    </h4>
                  </div>
                  <div id="mens" class="panel-collapse collapse in">
                    <div class="panel-body">
                      <ul>
                        <li><a href="shop_prodbycategory.php?category_id=1&intendedFor=D">Dog Food and Treats</a></li>
                        <li><a href="shop_prodbycategory.php?category_id=5&intendedFor=D">Dog Vitamins</a></li>
                        <li><a href="shop_prodbycategory.php?category_id=2&intendedFor=D">Dog Medications and Others</a></li>
                        <li><a href="shop_prodbycategory.php?category_id=3&intendedFor=D">Dog Shampoo and Soap</a></li>
                      </ul>
                    </div>
                  </div>
                </div>
 
              </div><!--/category-productsr-->

              
            </div>
          </div>
          
          <div class="col-sm-9 padding-right">

            <?php
            $product = getProduct($con, $productId);

            if($forNavigation == "All Products")
            {
                echo "
                <div id=\"breadcrumbs\">
                    <a href=\"cust_shop.php\">$forNavigation</a> >
                    <a>$product->productName</a>
                </div>
                ";
            }

            else
            {
                list($shopGroup, $categoryName) = explode('-', $forNavigation);
                $category_id = $product->categoryId;

                if($category_id == 4)
                    $category_id = 3;

                echo "
                <div id=\"breadcrumbs\">
                    <a href=\"cust_shop.php\">$shopGroup</a> >
                    <a href=\"shop_prodbycategory.php?category_id=$category_id&intendedFor=$shopGroup[0]\">$categoryName</a> > 
                    <a>$product->productName</a>
                </div>
                ";
            }

            $item = getItem($con, $itemId);
            extract($item);
            ?>


            <div class="product-details"><!--product-details-->
                <div class="col-sm-5" style="margin-top: 30px; margin-bottom: 30px; ">
                    <div class="view-product" style="margin-left: 20px;">
                    <!-- <img src="data:image/jpeg;base64, <?php echo base64_encode($image); ?>"/> -->
                    <?php
                    imageDisplay($image);
                    ?>
                    </div>
                    <div id="similar-product" class="carousel slide" data-ride="carousel" style="margin-left: 10px;">
                        
                          <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                  <?php
                                  displayProductVariations($product, $forNavigation);
                                  ?>
                                </div>
                            </div>
    
                          <!-- Controls -->
                          <a class="left item-control" href="#similar-product" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                          </a>
                          <a class="right item-control" href="#similar-product" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                          </a>
                    </div>
    
                </div>
                <div class="col-sm-7">
                    <div class="product-information"><!--/product-information-->
                        <h2 style="font-size: 30px;"><?php echo $product->productName; ?></h2>
                        <span style="font-size: 25px; color: #ff715b;">Price: <?php echo $price; ?></span>
                        <p>Variation: <?php echo $variation; ?></p>
                        <p><b>In Stock: </b> <?php echo $stocks; ?> </p>
                        <hr style="width:91%; height:1px; background-color: rgb(131, 128, 128);"/>
                        <p style="margin-right:25px;"><?php echo $product->description; ?></p>
                    </div><!--/product-information-->
                </div>
            </div><!--/product-details-->
            
            <div class="category-tab shop-details-tab"><!--category-tab-->
                <div class="col-sm-12">

                </div>
                <div class="tab-content">
                    <div class="tab-pane fade" id="details" >
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery1.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery2.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery3.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery4.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="companyprofile" >
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery1.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery3.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery2.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery4.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="tag" >
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery1.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery2.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery3.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="images/home/gallery4.jpg" alt="" />
                                        <h2>$56</h2>
                                        <p>Easy Polo Black Edition</p>
                                        <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div><!--/category-tab-->
            
            
        </div>
            </div><!--features_items-->
          </div>
        </div>
      </div>
    </section>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
    </br>
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



    <script src="js/jquery.js"></script>
    <script src="js/price-range.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>

  </body>
</html>
