<?php 
 $page = "home.php";
 $p = "home";
 $slider = true;
 $banner = true;
 $category = true;
 $blog = true;
 if (isset($_GET['p'])) {
    $p = $_GET['p'];
    switch ($p) {
        case 'shop':
            $page = "shop.php";
            $slider = false;
            $banner = false;
            $category = false;
            $blog = false;
            break;
        case 'pages':
            $page = "pages.php";
            break;
        case 'blog1':
            $page = "blog1.php";
            $slider = false;
            $banner = false;
            $category = false;
            $blog = false;
            break;
        case 'contact':
            $page = "contact.php";
            $banner = false;
            $slider = false;
            $category = false;
            $blog = false;
            break;
        case 'about':
            $page = "about.php";
            $slider = false;
            $banner = false;
            $category = false;
            $blog = false;
            break;
        case 'shop-details':
            $page = "shop-details.php";
            $slider = false;
            $banner = false;
            $category = false;
            $blog = false;
            break;
        // case 'shopping-cart':
        //     $page = "shopping-cart.php";
        //     $slider = false;
        //     $banner = false;
        //     $category = false;
        //     $blog = false;
        //     break;
        case 'checkout':
            $page = "checkout.php";
            $slider = false;
            $banner = false;
            $category = false;
            $blog = false;
            break;
        case 'blog-details':
            $page = "blog-details.php";
            $slider = false;
            $banner = false;
            $category = false;
            $blog = false;
            break;
        default:
            $page = "home.php";
            break;
    }
 }
?>

<!DOCTYPE html>
<html lang="zxx">

<?php include "includes/head.php" ?>

<body>
    
    <!-- Header Section Begin -->
    
        
            <?php include "includes/header.php" ?>
           
    

    <!-- Hero Section Begin -->
     
    
        <?php if ($slider) include "includes/slider.php" ?>
    


    <!-- Banner Section Begin -->
    
        <?php if ($banner) include "includes/banner.php" ?>
    
    

    <!-- Product Section Begin -->
    <section class="product spad">
        <?php include $page ?>
    </section>


    <!-- Categories Section Begin -->
    <?php if ($category) include "includes/category.php" ?>

    <!-- Latest Blog Section Begin -->
    
        <?php if ($blog) include "includes/blog-detail.php" ?>
    
    <!-- Footer Section Begin -->
    
        <?php include "includes/footer.php" ?>
    
    <!-- Footer Section End -->

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>


    <!-- Js Plugins -->
    <?php include "includes/script.php"?>
</body>

</html>