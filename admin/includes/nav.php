<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="sidebar" data-background-color="dark">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <a href="index.php" class="logo">
        <img
          src="http://localhost/ecommerce/img/logo.png" style="background : white; "
          alt="navbar brand"
          class="navbar-brand"
          height="20" />

      </a>
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
          <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
          <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
        <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <ul class="nav nav-secondary">
        <li class="nav-item active">
          <a
            data-bs-toggle="collapse"
            href="#dashboard"
            class="collapsed"
            aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
            <!-- <span class="caret"></span> -->
          </a>

        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">Components</h4>
        </li>
        <li class="nav-item">
          <a href="http://localhost/ecommerce/index.php" target="_blank">
            <i class="fa-solid fa-globe"></i>
            <p>Visit Site</p>
          </a>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="edit_banner.php">
          <i class="fa-brands fa-slideshare"></i>
            <p>Banner</p>

          </a>

        </li>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#">
          <i class="fa-solid fa-book"></i>
            <p>Edit blog</p>

          </a>

        </li>
        <li class="nav-item">
          <a href="form.php">
            <i class="fa-solid fa-table"></i>

            <p>Category</p>

          </a>
          <div class="collapse" id="forms">

        </li>
        <li class="nav-item">
          <a href="add_product.php">
          <i class="fa-solid fa-cart-plus"></i>
            <p>Add Product</p>
          </a>
        </li>

        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#">
            <i class="fas fa-solid fa-gear"></i>
            <p>Setting</p>

          </a>

        </li>


      </ul>
    </div>
  </div>
</div>