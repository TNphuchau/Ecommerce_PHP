<?php
    require_once "./mvc/core/redirect.php";
    require_once "./mvc/core/constant.php";
    $redirect = new redirect();
?>
<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <ul class="social">
                    <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                    <li><a href="#"><i class="fa fa-rss"></i></a></li>
                    <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="copyright">Sarah &copy; 2023&emsp; Hỗ trợ&emsp; Quyền riêng tư&emsp; Liên hệ</p>
            </div>
        </div>
    </div>
</section>
<div class="message">
    <p class="text-success"><?= $redirect->setFlash('flash');  ?></p>
</div>
<?php ?>

<footer>
    <div class="container">
        <p>@NF TEAM</p>
    </div>
</footer>
<!-- <div class="rings__phone">
    <div class="b1 box__phone"></div>
    <div class="b2 box__phone"></div>
    <div class="box__phone phone">
        <a href="tel:0982824398" title="0982824398"><i class="fas fa-phone-alt"></i></a>
    </div>
</div> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<!-- <script>
$('.slick_slide').slick({
    arrows: false,
    fade: true,
    centerMode: true,
    focusOnSelect: true,
    cssEase: 'linear',
    autoplay: true,
    autoplaySpeed: 2000,
});
window.addEventListener('scroll', (e) => {
    if (document.documentElement.scrollTop > 120) {
        document.querySelector('.nagivation').classList.add('active');
    } else {
        document.querySelector('.nagivation').classList.remove('active');
    }
});
const heightWindow = document.documentElement.offsetHeight;
window.addEventListener('scroll', (e) => {
    document.querySelector('.show__cart').style.height = heightWindow - document.querySelector('footer')
        .offsetHeight + 'px';
});
document.querySelector('.close__cart').addEventListener("click", (e) => {
    document.querySelector('.show__cart').classList.remove('open')
});
document.querySelector('.open__cart').addEventListener("click", (e) => {
    document.querySelector('.show__cart').classList.add('open')
});

function deleteItem(id) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'cart/deleteProductById');
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    let total__Price = 0;
    xhr.onload = function(e) {
        if (this.responseText) {
            const data = JSON.parse(this.responseText);
            let list__items_cart = document.querySelector('.list__items_cart');
            let element2 = '';
            data.map((v) => {
                if (v.qty <= 0) return;
                total__Price += parseInt(v.qty * v.price)
                element2 += `
                     <div class="item">
                        <div class="box__one">
                            <div class="image">
                                <img src="${v.image}" alt="">
                            </div>
                            <div class="name__product">
                                <p>${v.name} </p>
                                <p>${formatMoney(v.price)} đ</p>
                            </div>
                        </div>
                        <div class="box__two">
                            <p>Số lượng:  <span>${v.qty}</span></p>
                        </div>
                        <div class="box__tree">
                            <a href="javascript:void(0)" onClick="deleteItem(${v.productID})"><i  data-id="${v.productID}" class="fa-solid fa-trash"></i></a>
                        </div>
                    </div>
                    `
            });
            list__items_cart.innerHTML = element2;
            document.querySelector('.total_qty').innerHTML = data.length;
            document.getElementById('total_Price_header').innerHTML = total__Price.format(0)
        }
    }
    xhr.send(`id=${id}`);
}

function formatMoney(__this) {
    let val = __this;
    // let num = val.replace(/[^\d]/g,"");
    let arr = val.split('.');
    let val_num = arr[0];
    let len = val_num.length;
    let result = '';
    let j = 0;
    for (let index = len; index > 0; index--) {
        j++;
        if (j % 3 == 1 && j != 1) {
            result = val_num.substr(index - 1, 1) + ',' + result;
        } else {
            result = val_num.substr(index - 1, 1) + result;
        }
    }
    return result
}
Number.prototype.format = function(n, x) {
    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
}
</script> -->
</body>

</html>