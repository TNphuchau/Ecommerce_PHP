<?php 
require_once('../Controller/UserController.php');
require_once('../../config/DbConnection.php');
$userController = new UserController($conn);
$error = 'null';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'register') {
            $result = $userController->registerUser(
                $_POST['username'],
                $_POST['email'],
                $_POST['password'],
                $_POST['confirmPassword']
            );

            if ($result == "success") {
              header('Location: loginRegister.php?success=true');
              exit();
          } else {
              $_SESSION['error'] = $result;
              header('Location: loginRegister.php');
              exit();
          }
        } elseif ($_POST['action'] == 'login') {
            $result = $userController->loginUser($_POST['emailLogin'], $_POST['passwordLogin']);
            if ($result == "success") {
              header('Location: ../../index.php');
              exit();
          } else {
              $_SESSION['error'] = $result;
              header('Location: loginRegister.php');
              exit();
          }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>CodePen - Login/Registration Form Transition</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans" />
  <link rel="stylesheet" href="../../public/styles/login.css" />
  <style>
    #password-strength-indicator {
      display: flex;
      align-items: center;
    }

    #password-strength-indicator .icon {
      margin-right: 5px;
    }

    #password-strength-indicator .strong {
      color: green;
    }

    #password-strength-indicator .weak {
      color: red;
    }

    .match {
      color: green;
    }

    .mismatch {
      color: red;
    }
  </style>
</head>

<body>
  <br><br><br>
  <div class="cont">
    <form method="POST" action="loginRegister.php" class="form sign-in">
      <h2>Welcome back,</h2>
      <label>
        <span>Email or username</span>
        <input type="text" name="emailLogin" required />
      </label>
      <label>
        <span>Password</span>
        <input type="password" name="passwordLogin" required />
      </label>
      <p class="forgot-pass">Forgot password?</p>
      <button type="submit" name="action" value="login" class="submit">Sign In</button>
      <button type="button" class="fb-btn">
        Connect with <span>facebook</span>
      </button>
    </form>
    <div class="sub-cont">
      <div class="img">
        <div class="img__text m--up">
          <h2>New here?</h2>
          <p>Sign up and discover great amount of new opportunities!</p>
        </div>
        <div class="img__text m--in">
          <h2>One of us?</h2>
          <p>
            If you already has an account, just sign in. We've missed you!      

          </p>
        </div>
        <div class="img__btn">
          <span class="m--up">Sign Up</span>
          <span class="m--in">Sign In</span>
        </div>
      </div>


      <form method="POST" class="form sign-up" action="loginRegister.php" onsubmit="return validateForm();">
        <h2>Time to feel like home,</h2>
        <label>
          <span>Username</span>
          <input type="text" name="username" class="form-control form-control-xl" placeholder="Username" required>
        </label>
        <label>
          <span>Email</span>
          <input type="email" name="email" placeholder="Email" required>
        </label>
        <label>
          <span>Password</span>
          <input type="password" name="password" id="password" class="form-control form-control-xl" required placeholder="Password" oninput="checkPasswordStrength(this.value)">
          <div id="password-strength-indicator">
            <div id="password-strength-icon" class="icon"></div>
            <div id="password-strength-text"></div>
          </div>
        </label>
        <label>
          <span>Confirm Password</span>
          <input type="password" id="confirmPassword" name="confirmPassword" class="form-control form-control-xl" required placeholder="confirmPassword">
        </label>

        <button type="submit" class="submit" name="action" value="register" >Sign Up</button>
        <button type="button" class="fb-btn">
          Join with <span>facebook</span>
        </button>
      </form>
    </div>
  </div>
  <script src="../../public/js/login.js"></script>
  <script>
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
      var confirmPassword = document.getElementById('confirmPassword').value;
      if (confirmPassword.localeCompare(password) != 0) {
        alert('Confirm password must be equal password!');
        return false;
      }
      if (checkPasswordStrength(password)) {
        return true;
      } else {
        alert('Mật khẩu yếu. Vui lòng chọn mật khẩu mạnh hơn.');
        return false;
      }
    }
  </script>
<script>
    <?php if (!empty($_SESSION['error'])) : ?>
        var errorMessage = <?php echo json_encode($_SESSION['error']); ?>;
        alert(errorMessage);
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'true') : ?>
        var successMessage = "Registration successful!";
        alert(successMessage);
    <?php endif; ?>
</script>

</body>

</html>