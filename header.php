<!-- Bootstrap JS (pastikan ini sebelum </body>) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand bg-body-tertiary sticky-top">
  <div class="container-lg">
    <img class="navbar-brand" src="kefein.png" width="150px" href="#"></img>
    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle nav-menu-end" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $hasil['username']; ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end mt-2">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ModalUbahPassword"><i class="bi bi-key"></i>Ubah Password</a></li>
            <li><a class="dropdown-item" href="logout">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Modal Edit-->
<div class="modal fade" id="ModalUbahPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-fullscreen-md-down">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" novalidate action="proses/proses_ubah_password.php" method="POST">
          <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <input  type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="username" value="<?php echo $_SESSION['username_decafe'] ?>">
                <label for="floatingInput">Username</label>
                <div class="invalid-feedback">
                  masukkan username
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <input  type="password" class="form-control" id="floatingPassword" name="passwordlama" required>
                <label for="floatingInput">Password lama</label>
                <div class="invalid-feedback">
                  masukkan password lama
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <input  type="email" class="form-control" id="floatingInput" name="passwordbaru">
                <label for="floatingInput">Password Baru</label>
                <div class="invalid-feedback">
                  password baru
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-floating mb-3">
                <input  type="password" class="form-control" id="floatingPassword" name="repasswordbaru" required>
                <label for="floatingInput">Ulangi Password Baru</label>
                <div class="invalid-feedback">
                  ulangi password baru
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-primary" name="ubah_password_validate" value="1234">Save changes</button>
    </div>
    </form>
  </div>
</div>
</div>
</div>
<!-- end edit modal -->