<!-- 
<?php
if (isset($_GET['x'])) {
    echo "<script>alert('Nilai x: " . $_GET['x'] . "');</script>";
} else {
    echo "<script>alert('Parameter x tidak ada!');</script>";
}

if (isset($_SESSION['level_decafe'])) {
    echo "<script>alert('Level Decafe: " . $_SESSION['level_decafe'] . "');</script>";
} else {
    echo "<script>alert('Session level_decafe tidak ada!');</script>";
}
?> -->

<!-- ini content -->
<?php
session_start();
if (isset($_GET['x']) && $_GET['x'] == 'home'){
  $page = "home.php";
include "main.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'order'){
  $page = "order.php";
include "main.php";
} elseif (isset($_GET['x']) && $_GET['x'] == 'user'){
  if($_SESSION['level_decafe'] == 1){
    $page = "user.php";
    include "main.php";
    } else {
      $page = "home.php";
      include "main.php";
    }
} elseif (isset($_GET['x']) && $_GET['x'] == 'customer'){
  $page = "customer.php";
  include "main.php";
  } elseif (isset($_GET['x']) && $_GET['x'] == 'product'){
    $page = "product.php";
    include "main.php";
    } elseif (isset($_GET['x']) && $_GET['x'] == 'report'){
      if($_SESSION['level_decafe']==1){
      $page = "report.php";
      include "main.php";
      } else {
        $page = "home.php";
        include "main.php";
      }
      } elseif (isset($_GET['x']) && $_GET['x'] == 'menu'){
        $page = "menu.php";
        include "main.php";
      } elseif (isset($_GET['x']) && $_GET['x'] == 'login'){
        include "login.php";
        } elseif (isset($_GET['x']) && $_GET['x'] == 'logout'){
          include "proses/proses_logout.php";
          } elseif (isset($_GET['x']) && $_GET['x'] == 'katmenu'){
            $page = "katmenu.php";
            include "main.php";
          } elseif (isset($_GET['x']) && $_GET['x'] == 'orderitem'){
            $page = "order_item.php";
            include "main.php";
            }  else{
            $page = "home.php";
            include "main.php";
      }
?>
<!-- End Content -->
