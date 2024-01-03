<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.min.css'>


<br><br><br><br><br><br>
<div class="blog-slider">
    <div class="blog-slider__wrp swiper-wrapper">
        <div class="blog-slider__item swiper-slide">
            <div class="blog-slider__img">

                <img src="//images.samsung.com/vn/smartphones/galaxy-z-fold5/buy/kv_hero_PC.jpg" alt="">
            </div>
            <div class="blog-slider__content">
                <span class="blog-slider__code">26 December 2019</span>
                <div class="blog-slider__title">Samsung</div>
                <div class="blog-slider__text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi? </div>
                <a href="#" class="blog-slider__button">MUA NGAY</a>
            </div>
        </div>
        <div class="blog-slider__item swiper-slide">
            <div class="blog-slider__img">
                <img src="//i01.appmifile.com/v1/MI_18455B3E4DA706226CF7535A58E875F0267/pms_1666344481.20013313.png?thumb=1&w=500&q=85" alt="">
            </div>
            <div class="blog-slider__content">
                <span class="blog-slider__code">26 December 2019</span>
                <div class="blog-slider__title">Xiaomi</div>
                <div class="blog-slider__text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi?</div>
                <a href="#" class="blog-slider__button">MUA NGAY</a>
            </div>
        </div>

        <div class="blog-slider__item swiper-slide">
            <div class="blog-slider__img">
                <img src="https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/iphone-card-40-iphone15hero-202309?wid=680&hei=528&fmt=p-jpg&qlt=95&.v=1693086290559" alt="">
            </div>
            <div class="blog-slider__content">
                <span class="blog-slider__code">26 December 2019</span>
                <div class="blog-slider__title">Iphone</div>
                <div class="blog-slider__text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Recusandae voluptate repellendus magni illo ea animi?</div>
                <a href="#" class="blog-slider__button">MUA NGAY</a>
            </div>
        </div>

    </div>
    <div class="blog-slider__pagination"></div>
</div>
<br><br><br><br><br><br>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/js/swiper.min.js'></script>
<script>
    var swiper = new Swiper('.blog-slider', {
      spaceBetween: 30,
      effect: 'fade',
      loop: true,
      mousewheel: {
        invert: false,
      },
      // autoHeight: true,
      pagination: {
        el: '.blog-slider__pagination',
        clickable: true,
      }
    });
</script>