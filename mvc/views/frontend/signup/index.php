<?php
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/core/constant.php";
    $redirect = new redirect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $title ?></title>
    <base href="http://localhost/shopping/">
    <!-- Bootstrap -->
    <link href="public/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="public/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- NProgress -->
    <link href="public/vendors/nprogress/nprogress.css" rel="stylesheet" />
    <!-- Animate.css -->
    <link href="public/vendors/animate.css/animate.min.css" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="public/build/css/custom.min.css" rel="stylesheet" />
    <script>
    var strongRegex = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})/;
    var mediumRegex = /((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))/;

    function checkPasswordStrength(password) {
      var indicatorIcon = document.getElementById('password-strength-icon');
      var indicatorText = document.getElementById('password-strength-text');

      var strongRegex = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})/;
      var mediumRegex = /((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))/;

      if (strongRegex.test(password)) {
        indicatorIcon.innerHTML = '✓';
        indicatorIcon.classList.add('strong');
        indicatorIcon.classList.remove('weak');
        indicatorText.textContent = 'Strong Password';
        return true;
      } else if (mediumRegex.test(password)) {
        indicatorIcon.innerHTML = '✓';
        indicatorIcon.classList.add('strong');
        indicatorIcon.classList.remove('weak');
        indicatorText.textContent = 'Medium Password';
        return true;
      } else {
        indicatorIcon.innerHTML = '✗';
        indicatorIcon.classList.add('weak');
        indicatorIcon.classList.remove('strong');
        indicatorText.textContent = 'Weak Password';
        return false;
      }
      return false;
    }

    function validateForm() {
        var password = document.getElementById('password').value;
        if (checkPasswordStrength(password)) {
            return true;
        } else {
            alert('Mật khẩu yếu. Vui lòng chọn mật khẩu mạnh hơn.');
            return false;
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
            <?php if(isset($_SESSION['flash'])){?>
                alert("<?= $redirect->setFlash('flash'); ?>");
            <?php } ?>
            <?php if(isset($_SESSION['errors'])){?>
                alert("<?= $redirect->setFlash('errors'); ?>");
            <?php } ?>
        });
  </script>

</head>

<body class="login">
    <div>
    <?php
        unset($_SESSION['flash']);
        unset($_SESSION['errors']);
        ?>
        <div class="login_wrapper">

            <div class="animate form login_form">
                <section class="login_content">
                    <form action="auth/signup" method="post" onsubmit="return validateForm()">
                        <h1>Sign up</h1>
                        <div>
                            <input type="text" name="data_post[name]" class="form-control" placeholder="Full name"
                                required />
                        </div>
                        <div>
                            <input type="text" name="data_post[username]" class="form-control" placeholder="Username"
                                pattern="[a-zA-Z ]+" required />
                        </div>
                        <div>
                        <input type="password" name="data_post[password]" class="form-control"
                                placeholder="Password" pattern="[a-zA-Z-0-9]+" required oninput="checkPasswordStrength(this.value)"/>
                        </div>
                            <div id="password-strength-indicator">
                            <div id="password-strength-icon" class="icon"></div>
                            <div id="password-strength-text"></div>
                        </div>
                        <div style="display: flex; justify-content: space-between ">
                        <button class="btn btn-primary">Sign up</button>
                        <a href="dang-nhap.html" style="color: blue; text-decoration: underline">Đăng nhập</a>
                         </div>
                        <div class="clearfix"></div>
                        <div>
                            <?php if(isset($_SESSION['errors'])){?>
                            <h4 class="text-danger"><?= $redirect->setFlash('errors');  ?></h4>
                            <?php } ?>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>

</html>