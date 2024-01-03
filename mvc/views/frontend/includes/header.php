<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?></title>
  <style>

  </style>
  <base href="http://localhost/shopping/">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <link rel="stylesheet" href="public/build/css/shopping.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
</head>

<body>
  <header class="header">
    <div class="main_nav_container">
      <div class="container">
        <div class="row">
          <div class="head_center">
            <img src="https://seotrends.com.vn/wp-content/uploads/2023/06/anh-naruto-chibi.jpg" alt="" class="logo_image" />
            <nav class="navbar">
              <ul class="navbar_menu">
                <li><a href="">Trang chủ</a></li>
                <li><a href="">Sản phẩm</a></li>
                <li><a href="">Liên hệ</a></li>
              </ul>

              <?php if (isset($_SESSION['user']) && $data_index['user'] !== null) { ?>
                <div>
                  <nav>
                    <div class="profile">
                      <img src="" alt="" style="width: 80px; height: 40px" />
                      <ul class="profile-link">
                        <li>
                          <img src="" style="
                                    width: 60px;
                                    height: 60px;
                                    border: 1px solid red;
                                " />
                          <p class="mb-1 mt-3 font-weight-semibold" text=""></p>
                          <p class="fw-light text-muted mb-0" text=""></p>
                        </li>
                        <li>
                          <a href=""><i class="fa fa-shopping-cart fa-history"></i>Lịch sử mua hàng</a>
                        </li>
                        <li>
                          <a href="thong-tin-chung.html"><i class="fa fa-user"></i>Hồ sơ</a>
                        </li>
                        <li>
                          <a href="doi-mat-khau.html"><i class="fa-solid fa-key"></i>Đổi mật khẩu</a>
                        </li>
                        <li>
                          <a href="dang-xuat.html"><i class="fa fa-sign-out"></i>Đăng xuất</a>
                        </li>
                      </ul>
                    </div>
                  </nav>
                </div>
                <?= ($data_index['user']['username']) ?>
              <?php } else { ?>
                <div class="contact-account">
                  <div class="contact-account__create">
                    <i class="fa fa-user" aria-hidden="true"></i>
                  </div>
                  <div class="contact-account__log" style="z-index: 10">
                    <a href="" class="contact-account__login">
                      <span>Đăng nhập</span>
                    </a>
                    <a href="" class="contact-account__signup">
                      <span>Đăng ký</span>
                    </a>
                  </div>
                <?php } ?>

                <ul class="navbar_user">
                  <li class="checkout">
                    <a href="gio-hang.html">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                      <span class="total_qty"><?= count($data_index['cart']); ?></span>
                    </a>
                  </li>
                </ul>
            </nav>

          </div>
        </div>
      </div>
    </div>
  </header>
</body>
<script>
  const profile = document.querySelector("nav .profile");
  const imgProfile = profile.querySelector("img");
  const dropdownProfile = profile.querySelector(".profile-link");

  imgProfile.addEventListener("click", function() {
    dropdownProfile.classList.toggle("show");
  });
  
</script>