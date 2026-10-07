<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url();?>dist/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
  <title>Login – <?php echo company; ?></title>
  <style>
    :root {
      --green: #0f8a5f;
      --green-dark: #0b6b4a;
      --green-light: #6ee7b7;
      --text: #111827;
      --muted: #6b7280;
      --border: #e5e7eb;
    }

    *, *::before, *::after { box-sizing: border-box; }
    html, body { height: 100%; margin: 0; }

    body {
      font-family: 'Nunito', 'Segoe UI', Arial, sans-serif;
      color: var(--text);
      background: #0b4a36 url('<?php echo base_url(); ?>assets/bg_login.png') no-repeat left bottom / cover;
      min-height: 100vh;
    }

    .login-wrap {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 40px;
      padding: 36px 7vw 36px 11vw;
    }

    /* ===== KIRI: branding ===== */
    .brand-side {
      align-self: flex-start;
      max-width: 540px;
      color: #fff;
      padding-top: 0;
      text-shadow: 0 2px 10px rgba(0,0,0,.25);
    }

    .brand-logo { display: flex; align-items: center; gap: 16px; margin-bottom: 26px; }
    .logo-box {
      width: 72px; height: 72px; border-radius: 16px;
      background: linear-gradient(145deg, #16a870, #0f8a5f);
      display: flex; align-items: center; justify-content: center;
      color: #fff; font-size: 2rem;
      box-shadow: 0 8px 20px rgba(0,0,0,.25);
    }
    .brand-logo b { display: block; font-size: 2.3rem; font-weight: 900; line-height: 1; }
    .brand-logo span { display: block; font-size: 1.35rem; opacity: .9; }

    .brand-side h1 { font-size: 2.8rem; font-weight: 900; line-height: 1.08; margin: 0 0 16px; }
    .brand-side h1 em { font-style: normal; color: var(--green-light); display: block; }
    .brand-side .lead-text { font-size: 1.15rem; line-height: 1.45; opacity: .95; margin-bottom: 20px; max-width: 500px; }

    .features { display: grid; grid-template-columns: 1fr 1fr; gap: 14px 34px; max-width: 500px; }
    .feature { display: flex; align-items: center; gap: 16px; }
    .feature-icon {
      width: 56px; height: 56px; border-radius: 14px; flex-shrink: 0;
      background: linear-gradient(145deg, #16a870, #0f8a5f);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.45rem; color: #fff;
      box-shadow: 0 6px 16px rgba(0,0,0,.2);
    }
    .feature b { display: block; font-size: 1.1rem; }
    .feature span { display: block; font-size: 1.05rem; opacity: .88; }

    /* ===== KANAN: kartu login ===== */
    .login-card {
      width: 100%; max-width: 560px; min-width: 0;
      background: rgba(255,255,255,.97);
      border-radius: 26px;
      padding: 34px 50px 30px;
      box-shadow: 0 24px 60px rgba(0,0,0,.18);
      flex-shrink: 1;
    }

    .card-logo { text-align: center; margin-bottom: 18px; }
    .card-logo .logo-box { width: 96px; height: 90px; border-radius: 18px; margin: 0 auto 6px; font-size: 2.6rem; }
    .card-logo b { display: block; font-size: 2.1rem; font-weight: 900; line-height: 1.05; }
    .card-logo span { display: block; font-size: 1.15rem; color: var(--muted); }

    .welcome { text-align: center; margin-bottom: 30px; }
    .welcome h2 { font-size: 1.9rem; font-weight: 800; margin: 0 0 6px; }
    .welcome p { color: var(--muted); margin: 0; font-size: 1.02rem; }

    .form-label { font-weight: 700; font-size: .98rem; margin-bottom: 8px; }
    .input-icon { position: relative; margin-bottom: 20px; }
    .input-icon .lead-icon { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #6b7280; font-size: 1.05rem; }
    .input-icon .form-control {
      height: 50px; border-radius: 10px; border: 1px solid var(--border);
      background: #f9fafb; padding-left: 54px; padding-right: 50px; font-size: 1rem;
    }
    .input-icon .form-control:focus { border-color: var(--green); background: #fff; box-shadow: 0 0 0 3px rgba(15,138,95,.15); }
    .toggle-password { position: absolute; right: 18px; top: 50%; transform: translateY(-50%); color: #4b5563; cursor: pointer; font-size: 1.1rem; }
    .toggle-password:hover { color: var(--green); }

    .form-row-extra { display: flex; justify-content: space-between; align-items: center; margin: -4px 0 20px; }
    .form-check-input { width: 1.2em; height: 1.2em; margin-top: .15em; border-color: #9ca3af; }
    .form-check-input:checked { background-color: var(--green); border-color: var(--green); }
    .form-check-label { font-weight: 600; margin-left: 4px; }

    .btn-login {
      width: 100%; height: 56px; border: none; border-radius: 10px;
      background: linear-gradient(90deg, #0b6b4a, #0f8a5f);
      color: #fff; font-size: 1.3rem; font-weight: 800;
      box-shadow: 0 8px 20px rgba(15,138,95,.3);
      transition: filter .15s, transform .15s;
    }
    .btn-login:hover { filter: brightness(1.08); color: #fff; }
    .btn-login:active { transform: translateY(1px); }
    .btn-login:disabled { opacity: .75; }

    .copyright { text-align: center; color: var(--muted); font-size: .9rem; margin: 22px 0 0; }

    /* ===== Responsive ===== */
    /* layar pendek (laptop 768px): blok kiri diringkas supaya tidak menimpa gambar kasir */
    @media (max-height: 820px) and (min-width: 992px) {
      .login-wrap { padding-top: 24px; padding-bottom: 24px; }
      .brand-logo { margin-bottom: 16px; }
      .brand-logo .logo-box { width: 54px; height: 54px; font-size: 1.5rem; }
      .brand-logo b { font-size: 1.8rem; }
      .brand-logo span { font-size: 1.1rem; }
      .brand-side h1 { font-size: 2.15rem; margin-bottom: 10px; }
      .brand-side .lead-text { font-size: 1rem; margin-bottom: 14px; max-width: 440px; }
      .features { gap: 10px 26px; max-width: 440px; }
      .feature-icon { width: 44px; height: 44px; font-size: 1.1rem; border-radius: 12px; }
      .feature b, .feature span { font-size: .95rem; }
      .login-card { padding-top: 26px; padding-bottom: 22px; }
      .card-logo .logo-box { width: 78px; height: 72px; font-size: 2.1rem; }
      .welcome { margin-bottom: 20px; }
    }
    @media (max-width: 1280px) {
      .login-wrap { padding: 32px 4vw; }
      .brand-side h1 { font-size: 2.5rem; }
      .login-card { max-width: 480px; padding: 30px 36px; }
    }
    @media (max-width: 991px) {
      body { background-position: 30% bottom; }
      .login-wrap { justify-content: center; padding: 24px 16px; }
      .brand-side { display: none; }
      .login-card { padding: 28px 22px; }
    }
  </style>
</head>
<body>

  <div class="login-wrap">

    <!-- ===== Kiri ===== -->
    <div class="brand-side">
      <div class="brand-logo">
        <div class="logo-box"><i class="fas fa-cart-shopping"></i></div>
        <div><b>POS</b><span>Point of Sale</span></div>
      </div>

      <h1>Kelola Penjualan<em>Lebih Mudah</em><em>dan Efisien</em></h1>
      <p class="lead-text">Solusi lengkap untuk mengelola stok, transaksi, pelanggan dan laporan penjualan dalam satu sistem.</p>

      <div class="features">
        <div class="feature">
          <div class="feature-icon"><i class="fas fa-cube"></i></div>
          <div><b>Manajemen</b><span>Stok Produk</span></div>
        </div>
        <div class="feature">
          <div class="feature-icon"><i class="fas fa-cart-shopping"></i></div>
          <div><b>Transaksi</b><span>Lebih Cepat</span></div>
        </div>
        <div class="feature">
          <div class="feature-icon"><i class="fas fa-chart-simple"></i></div>
          <div><b>Laporan</b><span>Real-time</span></div>
        </div>
        <div class="feature">
          <div class="feature-icon"><i class="fas fa-users"></i></div>
          <div><b>Data Pelanggan</b><span>Terintegrasi</span></div>
        </div>
      </div>
    </div>

    <!-- ===== Kanan: form login ===== -->
    <div class="login-card">
      <div class="card-logo">
        <div class="logo-box"><i class="fas fa-cart-shopping"></i></div>
        <b>POS</b>
        <span>Point of Sale</span>
      </div>

      <div class="welcome">
        <h2>Selamat Datang</h2>
        <p>Masuk ke akun Anda untuk melanjutkan</p>
      </div>

      <form id="login-form" autocomplete="on" onsubmit="return false;">
        <label class="form-label" for="username">Username</label>
        <div class="input-icon">
          <i class="fas fa-user lead-icon"></i>
          <input type="text" class="form-control" id="username" placeholder="Masukkan username" autocomplete="username" autofocus>
        </div>

        <label class="form-label" for="password">Password</label>
        <div class="input-icon">
          <i class="fas fa-lock lead-icon"></i>
          <input type="password" class="form-control" id="password" placeholder="Masukkan password" autocomplete="current-password">
          <i class="fas fa-eye toggle-password" id="togglePassword" title="Tampilkan password"></i>
        </div>

        <div class="form-row-extra">
          <div class="form-check m-0">
            <input class="form-check-input" type="checkbox" id="remember_me">
            <label class="form-check-label" for="remember_me">Ingat saya</label>
          </div>
        </div>

        <button type="submit" class="btn-login" id="login">
          <span id="btn-text"><i class="fas fa-right-to-bracket me-2"></i>Masuk</span>
          <span id="btn-loading" class="d-none"><span class="spinner-border spinner-border-sm me-2"></span>Memproses...</span>
        </button>
      </form>

      <p class="copyright">&copy; <?php echo date('Y'); ?> POS - Point of Sale. All rights reserved.</p>
    </div>

  </div>

  <script src="<?php echo base_url(); ?>dist/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>dist/sweetalert2.js"></script>
  <script>
    // Tampilkan / sembunyikan password
    $('#togglePassword').on('click', function () {
      var isPassword = $('#password').attr('type') === 'password';
      $('#password').attr('type', isPassword ? 'text' : 'password');
      $(this).toggleClass('fa-eye fa-eye-slash');
    });

    // Proses login
    $('#login-form').on('submit', function (e) {
      e.preventDefault();

      var username = $('#username').val().trim();
      var password = $('#password').val();
      var remember = $('#remember_me').is(':checked') ? 1 : 0;

      if (!username || !password) {
        Swal.fire({
          icon: 'warning',
          title: 'Perhatian',
          text: 'Username dan password tidak boleh kosong.',
          confirmButtonColor: '#0f8a5f'
        });
        return;
      }

      $('#btn-text').addClass('d-none');
      $('#btn-loading').removeClass('d-none');
      $('#login').prop('disabled', true);

      $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>Auth/processlogin',
        dataType: 'json',
        data: { username: username, password: password, remember: remember },
        success: function (data) {
          if (data.code == '200' || data.code == 200) {
            window.location.href = '<?php echo base_url(); ?>Dashboard';
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Login Gagal',
              text: data.msg,
              confirmButtonColor: '#0f8a5f'
            });
            resetBtn();
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Kesalahan Jaringan',
            text: 'Tidak dapat terhubung ke server. Silakan coba lagi.',
            confirmButtonColor: '#0f8a5f'
          });
          resetBtn();
        }
      });
    });

    function resetBtn() {
      $('#btn-text').removeClass('d-none');
      $('#btn-loading').addClass('d-none');
      $('#login').prop('disabled', false);
    }
  </script>
</body>
</html>
