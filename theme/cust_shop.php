<!DOCTYPE html>

<?php
include('./functions.php');
if (!isLoggedIn()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: login.html');
}
?>

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
                <a href="logout.php" class="btn btn-solid-border"
                  >Log-out <i class="fa fa-angle-right ml-2"></i
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
                      <a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                        Cat Shop
                      </a>
                    </h4>
                  </div>
                  <div id="sportswear" class="panel-collapse collapse">
                    <div class="panel-body">
                      <ul>
                        <li><a href="">Cat Food </a></li>
                        <li><a href="">Cat Care and Health Supplies</a></li>
                        <li><a href="">Treats </a></li>
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
                  <div id="mens" class="panel-collapse collapse">
                    <div class="panel-body">
                      <ul>
                        <li><a href="">Dog Food</a></li>
                        <li><a href="">Dog Care and Health Supplies</a></li>
                        <li><a href="">Treats</a></li>

                      </ul>
                    </div>
                  </div>
                </div>
 
              </div><!--/category-productsr-->

              
            </div>
          </div>
          
          <div class="col-sm-9 padding-right">
            <div class="features_items"><!--features_items-->
              <h2 class="title text-center">All Products</h2>
              
              
              <div class="col-sm-4">
                <div class="product-image-wrapper">
                  <div class="single-products">
                    <div class="productinfo text-center">
                      <img src="images/shop/product12.jpg" alt="" />
                      <h2>₱ 56</h2>
                      <p>Item</p>
                    </div>
                    <div class="product-overlay">
                      <div class="overlay-content">
                        <h2>In Stock: </h2>
                        <p>123</p>
                        <a href="cust_proddetails.html" class="btn btn-default add-to-cart"></i>View</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              
              <div class="col-sm-4">
                <div class="product-image-wrapper">
                  <div class="single-products">
                    <div class="productinfo text-center">
                      <img src="images/shop/product12.jpg" alt="" />
                      <h2>₱ 56</h2>
                      <p>Item</p>
                    </div>
                    <div class="product-overlay">
                      <div class="overlay-content">
                        <h2>In Stock: </h2>
                        <p>123</p>
                        <a href="cust_proddetails.html" class="btn btn-default add-to-cart"></i>View</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


              <div class="col-sm-4">
                <div class="product-image-wrapper">
                  <div class="single-products">
                    <div class="productinfo text-center">
                      <img src="images/shop/product12.jpg" alt="" />
                      <h2>₱ 56</h2>
                      <p>Item</p>
                    </div>
                    <div class="product-overlay">
                      <div class="overlay-content">
                        <h2>In Stock: </h2>
                        <p>123</p>
                        <a href="cust_proddetails.html" class="btn btn-default add-to-cart"></i>View</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="product-image-wrapper">
                  <div class="single-products">
                    <div class="productinfo text-center">
                      <img src="images/shop/product12.jpg" alt="" />
                      <h2>₱ 56</h2>
                      <p>Item</p>
                    </div>
                    <div class="product-overlay">
                      <div class="overlay-content">
                        <h2>In Stock: </h2>
                        <p>123</p>
                        <a href="cust_proddetails.html" class="btn btn-default add-to-cart"></i>View</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="product-image-wrapper">
                  <div class="single-products">
                    <div class="productinfo text-center">
                      <img src="images/shop/product12.jpg" alt="" />
                      <h2>₱ 56</h2>
                      <p>Item</p>
                    </div>
                    <div class="product-overlay">
                      <div class="overlay-content">
                        <h2>In Stock: </h2>
                        <p>123</p>
                        <a href="cust_proddetails.html" class="btn btn-default add-to-cart"></i>View</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="product-image-wrapper">
                  <div class="single-products">
                    <div class="productinfo text-center">
                      <img src="images/shop/product12.jpg" alt="" />
                      <h2>₱ 56</h2>
                      <p>Item</p>
                    </div>
                    <div class="product-overlay">
                      <div class="overlay-content">
                        <h2>In Stock: </h2>
                        <p>123</p>
                        <a href="cust_proddetails.html" class="btn btn-default add-to-cart"></i>View</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              

              

              
              <ul class="pagination">
                <li class="active"><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">&raquo;</a></li>
              </ul>
            </div><!--features_items-->
          </div>
        </div>
      </div>
    </section>

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
                Tempora dolorem voluptatum nam vero assumenda voluptate, facilis
                ad eos obcaecati tenetur veritatis eveniet distinctio.
              </p>
            </div>
          </div>
          <div class="column is-2-widescreen is-6-desktop is-6-tablet ml-auto">
            <div class="widget">
              <h4 class="is-capitalize mb-4">Company</h4>

              <ul class="list-unstyled footer-menu lh-35">
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Team</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
          </div>
          <div class="column is-3-widescreen is-6-desktop is-6-tablet">
            <div class="widget">
              <h4 class="is-capitalize mb-4">Support</h4>

              <ul class="list-unstyled footer-menu lh-35">
                <li><a href="#">Terms & Conditions</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Support</a></li>
                <li><a href="#">FAQ</a></li>
              </ul>
            </div>
          </div>
          <div class="column is-3-widescreen is-6-desktop is-6-tablet">
            <div class="widget widget-contact">
              <h4 class="is-capitalize mb-4">Get in Touch</h4>
              <h6>
                <a href="tel:+23-345-67890">
                  <i class="ti-headphone-alt mr-3"></i>Support@megakit.com</a
                >
              </h6>
              <h6>
                <a href="mailto:support@gmail.com">
                  <i class="ti-mobile mr-3"></i>+23-456-6588</a
                >
              </h6>

              <ul class="list-inline footer-socials mt-5">
                <li class="list-inline-item">
                  <a href="https://www.facebook.com/themefisher"
                    ><i class="ti-facebook mr-2"></i
                  ></a>
                </li>
                <li class="list-inline-item">
                  <a href="https://twitter.com/themefisher"
                    ><i class="ti-twitter mr-2"></i
                  ></a>
                </li>
                <li class="list-inline-item">
                  <a href="https://www.pinterest.com/themefisher/"
                    ><i class="ti-linkedin mr-2"></i
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
                  >Cheska Mylabs</a
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

    <!-- Messenger API -->
    <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "106217825715524");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v15.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    
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
