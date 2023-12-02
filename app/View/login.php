<?php
require_once('../../validation/regex_patterns.php');
require_once('../../config/DbConnection.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  if (isUsernameTaken($conn, $username)) {
    $error = "Username đã tồn tại. Vui lòng chọn username khác.";
  } elseif (isEmailTaken($conn, $email)) {
    $error = "Email đã được sử dụng. Vui lòng chọn email khác.";
  }
  elseif (!preg_match($strongRegex, $password) && !preg_match($mediumRegex, $password)) {
    $error = "Mật khẩu yếu. Vui lòng chọn mật khẩu mạnh hơn.";
  } elseif ($password !== $confirmPassword) {
    $error = "Mật khẩu và mật khẩu xác nhận không khớp";
  } else {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$hashedPassword')";
    
    if ($conn->query($sql) === TRUE) {
      header('Location: login.php?success=true');
      exit();
    } else {
      $error = "Đã có lỗi xảy ra: " . $conn->error;
    }
  }
  $conn->close();
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
    <div class="form sign-in">
      <h2>Welcome back,</h2>
      <label>
        <span>Email</span>
        <input type="email" />
      </label>
      <label>
        <span>Password</span>
        <input type="password" />
      </label>
      <p class="forgot-pass">Forgot password?</p>
      <button type="button" class="submit">Sign In</button>
      <button type="button" class="fb-btn">
        Connect with <span>facebook</span>
      </button>
    </div>
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


      <form method="POST" class="form sign-up" action="login.php" onsubmit="return validateForm();">
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

        <button type="submit" class="submit">Sign Up</button>
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
    var urlParams = new URLSearchParams(window.location.search);
    var successParam = urlParams.get('success');
    var error = "<?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>";

  </script>
  <?php if (!empty($error)) : ?>
    <script>
        var errorMessage = <?php echo json_encode($error); ?>;
        alert(errorMessage);
    </script>
<?php endif  ?>

</body>

</html>