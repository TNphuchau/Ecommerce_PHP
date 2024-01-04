<?php
require_once "./mvc/core/redirect.php";
require_once "./mvc/core/constant.php";
$redirect = new redirect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
    <link rel="stylesheet" href="public/build/css/login.css">
    <!-- Custom Theme Style -->
    <link href="public/build/css/custom.min.css" rel="stylesheet" />
    <script>
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

<body>
    <div class="login-container">
        <?php
        unset($_SESSION['flash']);
        unset($_SESSION['errors']);
        ?>
        <form action="dang-nhap.html" class="form-login" method="post">
            <ul class="login-nav">
                <li class="login-nav__item active">
                    <a href="#">Đăng nhập</a>
                </li>
            </ul>
            <label for="login-input-user" class="login__label">
                Username
            </label>
            <input id="login-input-user" class="login__input"  name="data_post[username]" required="" type="text" />
            <label for="login-input-password" class="login__label">
                Password
            </label>
            <input id="login-input-password" class="login__input" name="data_post[password]" required="" type="password" />
            <label for="login-sign-up" class="login__label--checkbox">
                <input id="login-sign-up" type="checkbox" class="login__input--checkbox" />
                Keep me Signed in
            </label>
            <button class="login__submit" type="submit">Đăng nhập</button>
        </form>
        <a href="#" class="login__forgot">Forgot Password?</a>
        <div>
            <?php if(isset($_SESSION['errors'])){?>
            <h4 class="text-danger"><?= $redirect->setFlash('errors');  ?></h4>
            <?php } ?>
        </div>
    </div>
    <!-- partial -->

</body>

</html>
