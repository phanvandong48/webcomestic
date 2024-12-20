<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="../assets/css2/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css2/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css2/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="../assets/css2/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="../assets/css2/nice-select.css" type="text/css">
    <link rel="stylesheet" href="../assets/css2/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css2/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="../assets/css2/style.css" type="text/css">

</head>

<body>

    <!-- Page Preloder -->

    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <a href="#">Sign in</a>
                <a href="#">FAQs</a>
            </div>
            <div class="offcanvas__top__hover">
                <span>Usd <i class="arrow_carrot-down"></i></span>
                <ul>
                    <li>USD</li>
                    <li>EUR</li>
                    <li>USD</li>
                </ul>
            </div>
        </div>
        <div class="offcanvas__nav__option">
            <a href="#" class="search-switch"><img src="../assets/img/icon/search.png" alt=""></a>
            <a href="#"><img src="../assets/img/icon/heart.png" alt=""></a>
            <a href="#"><img src="../assets/img/icon/cart.png" alt=""> <span>0</span></a>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__text">
            <p>Free shipping, 30-day return or refund guarantee.</p>
        </div>
    </div>
    <!-- Offcanvas Menu End -->
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="../public/index.php">YOBO</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="active"><a href="../public/index.php">Home</a></li>
                        <li><a href="../public/product.php">Shop</a></li>
                        <li><a href="../public/about.php">About</a>
                        </li>
                        <li><a href="../public/contact.php">Contacts</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    <a href="#"><img src="../assets/img/icon/heart.png" alt=""></a>
                    <a href="../public/cart.php"><img src="../assets/img/icon/cart.png" alt=""> <span>0</span></a>
                    <?php
                    if (isset($_COOKIE['username'])) {
                        echo '<a href="logout.php" 
              style="font-size: 16px; font-weight: 600; border-radius: 5px; color: #dc3545; transition: background-color 0.3s ease, color 0.3s ease; position: relative; text-transform: uppercase">
            <i class="fa-solid fa-user-slash""></i>Đăng xuất
          </a>';
                    } else {
                        echo '<a href="login.php" 
              style="font-size: 16px; font-weight: 600; border-radius: 5px; color: #007bff; transition: background-color 0.3s ease, color 0.3s ease; position: relative; text-transform: uppercase">
            Đăng nhập
          </a>';
                    }
                    ?>

                </div>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
    <!-- Header Section End -->
    <!-- Js Plugins -->
    <script src="../assets/js/jquery-3.3.1.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery.nice-select.min.js"></script>
    <script src="../assets/js/jquery.nicescroll.min.js"></script>
    <script src="../assets/js/jquery.magnific-popup.min.js"></script>
    <script src="../assets/js/jquery.countdown.min.js"></script>
    <script src="../assets/js/jquery.slicknav.js"></script>
    <script src="../assets/js/mixitup.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>