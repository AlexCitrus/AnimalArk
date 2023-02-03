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
$db = "animalark_db";

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
            header("location: admin_shop.php");
    }

    $sql->close();
}

else
{
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) 
    {
        $prospectproductid = $_GET['id'];
    }

}
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
            <a class="navbar-item mr-5" href="admin_home_new.html">
              <img src="images/logo.png" width="200" alt="logo" />
            </a>
          </div>

          <div class="navbar-menu" id="navigation">
            <ul class="navbar-start">
              <li class="navbar-item">
                <a class="navbar-link" href="admin_home_new.html">Home</a>
              </li>

              <li class="navbar-item">
                <a class="navbar-link" href="admin_shop.php">Products</a>
              </li>

              <li class="navbar-item">
                <a class="navbar-link" href="FAQs.html">FAQ</a>
              </li>
            </ul>
            <ul class="navbar-end ml-0">
              <li class="navbar-item">
              <a href="logout.php" onclick="return confirm('Are you sure you want to logout?')" class="btn btn-solid-border"
                  >Log-out <i class="fa fa-angle-right ml-2"></i
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
          <form action="create_item.php" method="POST" enctype="multipart/form-data">
            <div class="formbold-form-title">
              <h2 class="">Create Item</h2>
              <p>
                Simply input the necessary details, add a product image, and publish your new item to the site.
                 Start selling and reaching a wider audience in no time!
              </p>
            </div>
            <input type="hidden" name="id" value="<?php echo $prospectproductid; ?>">
            <div class="formbold-mb-3">
              <label for="itemVariation" class="formbold-form-label">Item Variation</label>
              <input type="text" name="itemVariation" id="itemVariation" class="formbold-form-input" required>
            </div>

            <!-- <form action="upload.php" method="post" enctype="multipart/form-data"> -->
                <label for="itemImage" class="formbold-form-label">Item Image</label>
                <div class="image-upload">
                  <img src="#" id="preview" alt="Image placeholder.">
                </div>
                </br>
                <input type="file" accept="image/*" name="itemImage" id="itemImage" required>
              <!-- </form> -->


            <div class="formbold-input-flex">
              <div>
                <label for="itemPrice" class="formbold-form-label">Item Price</label>
                <input type="text" name="itemPrice" id="itemPrice" class="formbold-form-input" placeholder="₱ 0.00" required>
              </div>
              <div>
                <label for="itemStocks" class="formbold-form-label">Item Stocks</label>
                <input type="number" name="itemStocks" id="itemStocks" class="formbold-form-input" required>
              </div>

              
            </div>
      
            <div class="formbold-mb-3" style="color: black;">
                <label for="itemVisibility" class="formbold-form-label">Is item visible?</label>
                <input type="checkbox" name="itemVisibility">
            </div>

            <div class="formbold-checkbox-wrapper">
              </div>
      
            <button class="formbold-btn">Submit</button>
          </form>
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
      const input = document.querySelector("#itemImage");
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
