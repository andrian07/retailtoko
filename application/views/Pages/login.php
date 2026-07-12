<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <link rel="stylesheet" href="<?php echo base_url();?>dist/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <title>Login – CV. Anugrah Harapan Utama</title>
  <style>
    :root {
      --primary: #842029;
      --primary-dark: #5a1118;
    }

    *, *::before, *::after { box-sizing: border-box; }

    html, body { height: 100%; margin: 0; }

    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #0f3460 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      overflow: hidden;
      position: relative;
    }

    body::before, body::after {
      content: '';
      position: fixed;
      border-radius: 50%;
      opacity: 0.08;
      animation: float 8s ease-in-out infinite;
    }
    body::before {
      width: 500px; height: 500px;
      background: var(--primary);
      top: -150px; right: -150px;
    }
    body::after {
      width: 400px; height: 400px;
      background: #e94560;
      bottom: -100px; left: -100px;
      animation-delay: -4s;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0) scale(1); }
      50%       { transform: translateY(-30px) scale(1.05); }
    }

    /* ── Card wrapper ── */
    .login-wrapper {
      display: flex;
      width: 900px;
      max-width: 96vw;
      min-height: 520px;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 30px 80px rgba(0,0,0,0.5);
      position: relative;
      z-index: 1;
    }

    /* ── Left brand panel ── */
    .login-brand {
      flex: 1;
      background: linear-gradient(160deg, var(--primary) 0%, var(--primary-dark) 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 48px 36px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .login-brand::before {
      content: '';
      position: absolute;
      width: 300px; height: 300px;
      background: rgba(255,255,255,0.06);
      border-radius: 50%;
      top: -80px; right: -80px;
    }
    .login-brand::after {
      content: '';
      position: absolute;
      width: 200px; height: 200px;
      background: rgba(255,255,255,0.06);
      border-radius: 50%;
      bottom: -60px; left: -60px;
    }
    .brand-icon {
      width: 88px; height: 88px;
      background: rgba(255,255,255,0.15);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 24px;
      border: 2px solid rgba(255,255,255,0.25);
      position: relative; z-index: 1;
    }
    .brand-icon i { font-size: 38px; color: #fff; }
    .login-brand h2 {
      color: #fff;
      font-weight: 700;
      font-size: 1.5rem;
      margin-bottom: 10px;
      line-height: 1.3;
      position: relative; z-index: 1;
    }
    .login-brand p {
      color: rgba(255,255,255,0.75);
      font-size: 0.9rem;
      line-height: 1.6;
      position: relative; z-index: 1;
    }
    .brand-badge {
      margin-top: 32px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.2);
      border-radius: 50px;
      padding: 8px 20px;
      color: rgba(255,255,255,0.9);
      font-size: 0.78rem;
      position: relative; z-index: 1;
    }

    /* ── Right form panel ── */
    .login-form-panel {
      flex: 1;
      background: #fff;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 52px 48px;
    }
    .login-form-panel h3 {
      font-weight: 700;
      font-size: 1.75rem;
      color: #1a1a2e;
      margin-bottom: 6px;
    }
    .login-form-panel .subtitle {
      color: #6c757d;
      font-size: 0.9rem;
      margin-bottom: 36px;
    }
    .form-label {
      font-weight: 600;
      font-size: 0.82rem;
      color: #495057;
      letter-spacing: 0.4px;
      text-transform: uppercase;
      margin-bottom: 6px;
    }
    .input-icon-wrap { position: relative; }
    .input-icon-wrap .field-icon {
      position: absolute;
      left: 14px; top: 50%;
      transform: translateY(-50%);
      color: #adb5bd;
      font-size: 15px;
      pointer-events: none;
      transition: color 0.2s;
    }
    .input-icon-wrap .form-control {
      padding-left: 42px;
      height: 48px;
      border: 1.5px solid #dee2e6;
      border-radius: 10px;
      font-size: 0.95rem;
      transition: border-color 0.25s, box-shadow 0.25s;
      background: #f8f9fa;
    }
    .input-icon-wrap .form-control:focus {
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(132,32,41,0.12);
      background: #fff;
      outline: none;
    }
    .input-icon-wrap:focus-within .field-icon { color: var(--primary); }
    .toggle-password {
      position: absolute;
      right: 14px; top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #adb5bd;
      font-size: 15px;
      transition: color 0.2s;
    }
    .toggle-password:hover { color: var(--primary); }
    .form-check-input:checked {
      background-color: var(--primary);
      border-color: var(--primary);
    }
    .form-check-label { font-size: 0.88rem; color: #495057; }

    .btn-login {
      height: 50px;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      border: none;
      border-radius: 10px;
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
      transition: transform 0.15s, box-shadow 0.15s, opacity 0.15s;
      box-shadow: 0 4px 18px rgba(132,32,41,0.35);
    }
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 24px rgba(132,32,41,0.45);
      opacity: 0.95;
      color: #fff;
    }
    .btn-login:active { transform: translateY(0); }
    .btn-login .spinner-border { width: 1.1rem; height: 1.1rem; border-width: 2px; }

    .login-footer {
      text-align: center;
      font-size: 0.78rem;
      color: #adb5bd;
      margin-top: 28px;
    }

    @media (max-width: 680px) {
      .login-brand { display: none; }
      .login-form-panel { padding: 40px 28px; }
      .login-wrapper { border-radius: 16px; }
    }
  </style>
</head>
<body>

  <div class="login-wrapper">

    <!-- Left brand panel -->
    <div class="login-brand">
      <div class="brand-icon">
        <i class="fas fa-store"></i>
      </div>
      <h2>CV. Anugrah<br>Harapan Utama</h2>
      <p>Sistem Manajemen Retail</p>
      <div class="brand-badge">
        <i class="fas fa-shield-alt"></i>&nbsp;Inventory Stok &amp; System Penjualan
      </div>
    </div>

    <!-- Right form panel -->
    <div class="login-form-panel">
      <h3>Selamat Datang</h3>
      <p class="subtitle">Masuk ke akun Anda untuk melanjutkan</p>

      <form autocomplete="off">
        <div class="mb-4">
          <label class="form-label" for="username">Username</label>
          <div class="input-icon-wrap">
            <input type="text" class="form-control" id="username"
                   placeholder="Masukkan username" autocomplete="username">
            <i class="fas fa-user field-icon"></i>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label" for="password">Password</label>
          <div class="input-icon-wrap">
            <input type="password" class="form-control" id="password"
                   placeholder="Masukkan password" autocomplete="current-password">
            <i class="fas fa-lock field-icon"></i>
            <i class="fas fa-eye toggle-password" id="togglePassword"></i>
          </div>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
          <div class="form-check mb-0">
            <input class="form-check-input" type="checkbox" id="remember_me">
            <label class="form-check-label" for="remember_me">Ingat saya</label>
          </div>
        </div>

        <div class="d-grid">
          <button type="button" id="login" class="btn btn-login">
            <span id="btn-text"><i class="fas fa-sign-in-alt me-2"></i>Masuk</span>
            <span id="btn-loading" class="d-none">
              <span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...
            </span>
          </button>
        </div>
      </form>

      <div class="login-footer">
        &copy; <?php echo date('Y'); ?> All rights reserved.
      </div>
    </div>

  </div>

  <script src="<?php echo base_url(); ?>dist/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>dist/sweetalert2.js"></script>
  <script>
    // Toggle password visibility
    $('#togglePassword').on('click', function () {
      var isPassword = $('#password').attr('type') === 'password';
      $('#password').attr('type', isPassword ? 'text' : 'password');
      $(this).toggleClass('fa-eye fa-eye-slash');
    });

    // Login submit
    $('#login').on('click', function (e) {
      e.preventDefault();

      var username = $('#username').val().trim();
      var password = $('#password').val();
      var remember = $('#remember_me').is(':checked') ? 1 : 0;

      if (!username || !password) {
        Swal.fire({
          icon: 'warning',
          title: 'Perhatian',
          text: 'Username dan password tidak boleh kosong.',
          confirmButtonColor: '#842029'
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
              confirmButtonColor: '#842029'
            });
            resetBtn();
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Kesalahan Jaringan',
            text: 'Tidak dapat terhubung ke server. Silakan coba lagi.',
            confirmButtonColor: '#842029'
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

    // Enter key submit
    $(document).on('keypress', function (e) {
      if (e.which === 13) { $('#login').trigger('click'); }
    });
  </script>
</body>
</html>