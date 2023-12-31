<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <base href="http://localhost/shopping/">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <link rel="stylesheet" href="public/build/css/shopping.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
</head>

<body>
    <section class="heading">
        <div class="container">
            <div class="row">
                <div class="box">
                    <p>Số điện thoại: <span> <i class="fas fa-phone"></i> <a
                                href="tel:113114115">113.114.115</a></span></p>
                </div>
                <div class="box">
                    <div class="button_sign">
                        <?php if(isset($_SESSION['user']) && $data_index['user'] !== null) {?>
                        <div class="avatar">
                            <div class="images">
                                <img src="./public/uploads/images/avatar.png" alt="">
                            </div>
                            <div class="selection__info">
                                <div><a href="thong-tin-chung.html" target="_blank">Thông tin chung</a></div>
                                <div><a href="doi-mat-khau.html" target="_blank">Đổi mật khẩu</a></div>
                                <div>
                                    <a href="dang-xuat.html">Đăng
                                        xuất</a>
                                </div>
                            </div>
                        </div>
                        <?= ($data_index['user']['username']) ?>

                        <?php } else {?>
                        <a href="dang-ky.html" class="register">Đăng ký</a>
                        <a href="dang-nhap.html" class="login">Đăng nhập</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  -->
    <section class="name__shop">
        <div class="container">
            <div class="row">
                <div class="box">
                    <a href="">
                        <h3>SHOPPING</h3>
                    </a>
                </div>
                <div class="box">
                    <div class="box__search">
                        <input type="search" class="search__input" id="search__input" placeholder="Nhập từ khóa ...">
                        <button id="search"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="search__list">
                        <ul>
                        </ul>
                    </div>
                </div>
                <div class="box">
                    <div class="cart">
                        <a href="javascript:void(0)" class="open__cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="total_qty"><?= count($data_index['cart']); ?></span>
                        </a>
                       
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- nagivation  -->
    <section class="nagivation">
        <div class="container">
            <div class="box menu">
                <nav>
                    <?php if($data_index['menu'] !== NULL){?>
                    <ul>
                        <?php foreach($data_index['menu'] as $key => $val){?>
                        <li><a
                                href="<?= isset($val['children']) && $val['children'] != null ? 'javascript:void(0)': $val['url'] ?>"><?= $val['name'] ?></a>
                            <?php if($val['children'] != null){?>
                            <ul class="nav__children">
                                <?php  foreach($val['children'] as $val_Child){?>
                                <li><a href="<?= $val_Child['url'] ?>"><?= $val_Child['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </nav>
            </div>
            <div class="box social">
                <ul>
                    <li><a href=""><i class="fab fa-facebook"></i></a></li>
                    <li><a href=""><i class="fab fa-twitter"></i></a></li>
                    <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
                </ul>
            </div>
        </div>
    </section>
    <script>
    document.querySelector('#search__input').addEventListener("keyup", (e) => {
        const value = e.target.value;
    })
    document.querySelector('#search__input').addEventListener("click", (e) => {
        const value = e.target.value;

    })
    </script>