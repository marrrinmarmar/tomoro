<?php
if (isset($_SESSION['username_decafe']) && !empty($_SESSION['username_decafe'])) {
  header('Location: home');
  exit();
}
?>

<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login page for KAFFEin POS system">
    <meta name="author" content="marin">
    <title>Login KAFFEin</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="favicon.png">

    <!-- Bootstrap CSS (gunakan salah satu, disarankan pakai CDN agar cepat) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link href="assets/css/login.css" rel="stylesheet">
    <script src="assets/js/color-modes.js"></script>

    <style>
      .btn-bd-primary {
        --bd-violet-bg: rgb(80, 60, 46);
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: rgb(53, 38, 27);
        --bs-btn-hover-border-color: rgb(68, 51, 38);
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: rgb(102, 76, 58);
        --bs-btn-active-border-color: rgb(80, 60, 46);
      }
    </style>
  </head>

  <body class="d-flex align-items-center py-4 bg-body-tertiary">

    <main class="form-signin w-100 m-auto">
      <form class="needs-validation" novalidate action="proses/proses_login.php" method="POST">
        <img class="mb-4" src="kefein.png" alt="KAFFEin Logo" width="150" height="50">

        <h1 class="h3 mb-3 fw-normal">Please login</h1>

        <div class="form-floating">
          <input name="username" type="text" required class="form-control" id="floatingInput" placeholder="Enter username">
          <label for="floatingInput">Username</label>
          <div class="invalid-feedback">
            Please input username!
          </div>
        </div>

        <div class="form-floating">
          <input name="password" type="password" required class="form-control" id="floatingPassword" placeholder="Password">
          <label for="floatingPassword">Password</label>
          <div class="invalid-feedback">
            Please input password!
          </div>
        </div>

        <div class="form-check text-start my-3">
          <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
          <label class="form-check-label" for="flexCheckDefault">
            Remember me
          </label>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit" name="submit_validate" value="abc">Login</button>
        <p class="mt-5 mb-3 text-body-secondary text-center">&copy; marin <?= date("Y") ?></p>
      </form>
    </main>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
          form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      })();
    </script>
  </body>
</html>
