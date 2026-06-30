<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD authentication page">
  <title>Login | adminHMD</title>

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="auth-body">
  <button class="icon-button theme-toggle auth-theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
    <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
  </button>
  <main class="auth-page">
    <section class="auth-card">
      <a class="auth-brand" href="index.html"><span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span><span><strong>adminHMD</strong><small>Sign in to your admin workspace.</small></span></a>
      <div class="auth-visual"><img src="{{ asset('assets/images/png/dasher-ui-bootstrap-5.jpg') }}" alt="adminHMD dashboard interface"></div>
      <form class="needs-validation" novalidate method="POST" id="loginFrm">
        <div class="mb-4">
          <p class="eyebrow mb-1">Secure Access</p>
          <h1 class="h3 mb-1">Login</h1>
          <p class="text-muted mb-0">Sign in to your admin workspace.</p>
        </div>
        <div class="mb-3">          
          <label class="form-label" for="user_name">User Name</label>
          <input class="form-control" id="user_name" name="user_name" type="text" required>
          <div class="invalid-feedback">Enter a valid User Name.</div>
        </div>
        <div class="mb-3">
          <div class="d-flex justify-content-between">
            <label class="form-label" for="loginPassword">Password</label>
            <a class="small fw-semibold" href="forgot-password.html">Forgot?</a>
          </div>
          <input class="form-control" id="loginPassword" type="password" required>
          <div class="invalid-feedback">Enter Valid Password.</div>
        </div>
        <div class="form-check mb-4"><input class="form-check-input" type="checkbox" id="rememberMe"><label class="form-check-label" for="rememberMe">Remember me</label></div>
        <button class="btn btn-primary w-100" type="button" onclick="submitLoginForm()">
            <i class="bi bi-box-arrow-in-right" aria-hidden="true"></i>
             Sign In
        </button>
      </form>
      
      <div class="auth-footer">New here? <a href="register.html">Create an account</a></div>
    </section>
  </main>

  <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

  <script>

    $("#loginFrm").validate({
        rules: {
            user_name: {
                required: true
            },
            loginPassword: {
                required: true
            }
        },
        messages: {
            user_name: {
                required: "Please enter your user name"
            },
            loginPassword: {
                required: "Please enter your password"
            }
        }   
    });

    function submitLoginForm() {
        if ($("#loginFrm").valid()) {
            var user_name = $("#user_name").val();
            var loginPassword = $("#loginPassword").val();

            $.ajax({
                url: "{{ route('login') }}",
                type: "POST",
                data: {
                    user_name: user_name,
                    password: loginPassword,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(response) {
                    console.log("AJAX Response:", response);
                    if (response.success) {
                        window.location.href = "{{ route('dashboard') }}";
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        }
    }

    </script>
</body>
</html>
