<!-- <body class="hold-transition login-page" style="background-color:#343a40"> -->

<body class="hold-transition login-page" style="background-color:#454d55">
  <div class="userlogin" data-flashdata="<?= $this->session->flashdata('userlogin'); ?>"></div>
  <div class="flashrole" data-flashdata="<?= $this->session->flashdata('flashrole'); ?>"></div>
  <div class="userlogout" data-flashdata="<?= $this->session->flashdata('userlogout'); ?>"></div>
  <div class="wrongdata" data-flashdata="<?= $this->session->flashdata('wrongdata'); ?>"></div>
  <div class="login-box">
    <div class="login-logo">
      <img src="<?= base_url('assets/dist/img/logo-white.png') ?>" alt="Logo Hira" width="143" height="75">
    </div>
    <div class="card">
      <div class="card-body login-card-body" style="border-radius:10px;">
        <p class="login-box-msg">--Silahkan masuk dahulu--</p>

        <form action="<?= base_url('auth') ?>" method="post">
          <div class="form-group">
            <label for="username">Username</label>
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="username" placeholder="Username Anda.." autofocus required oninvalid="this.setCustomValidity('Username wajib di isi!')" oninput="setCustomValidity('')">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-id-card"></span>
                  <!-- <i class="fas fa-id-card"></i> -->
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="pass">Password</label>
            <div class="input-group mb-3">
              <input type="password" class="form-control" name="pass" placeholder="Password Anda.." required oninvalid="this.setCustomValidity('Password wajib di isi!')" oninput="setCustomValidity('')">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-4">
            <button type="submit" class="btn btn-dark btn-block">Masuk</button>
          </div>
        </form>
        <div class="mt-4 text-center">
          <span class="text-secondary">Belum punya akun ?<br> Hubungi Admin Cabang Anda</span>
          <hr>
          <p>
            <strong>
              <a class="text-dark" href="https://hira-express.com">Hira Express</a>
              Made With 💖
            </strong>
          </p>
        </div>
      </div>
    </div>
  </div>