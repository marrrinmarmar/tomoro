<?php
//session_start();
if (!isset($_SESSION['username_decafe'])) {
  header('Location: login.php');
  exit();
}

include "proses/connect.php";
$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '{$_SESSION['username_decafe']}'");
$hasil = mysqli_fetch_array($query);

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KAFFEin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="height: 3000px">
  <!-- ini HEADER -->
  <?php include "header.php"; ?>
  <!-- end Header -->
<div class="containel-lg">
  <div class="row mb-5">
  <!-- ini sidebar -->
  <?php include "sidebar.php"; ?>
  <!-- end sidebar -->

  <!-- ini content -->
  <?php
  include $page;
  ?>
  <!-- End Content -->
  </div>


  <div class="fixed-bottom text-center mb-2 bg-light py-2">
    Copyright marin
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      const forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }

          form.classList.add('was-validated')
        }, false)
      })
    })()
  </script>
</div>

</body>

</html>