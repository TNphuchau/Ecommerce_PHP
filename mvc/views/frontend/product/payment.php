<link rel="stylesheet" href="public/build/css/cart.css">
<section class="cart__container">
    <div class="container">
        <div class="cart">
            <h3>Chi tiết đơn hàng</h3>
            <?php if (isset($data_index['cart']) && $data_index !== NULL && count($data_index['cart']) > 0) { ?>
                <div class="list__items">
                    <table>
                        <thead>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Tổng giá</th>
                        </thead>
                        <tbody id="content_cart">
                            <?php foreach ($data_index['cart'] as $key => $val) { ?>
                                <tr>
                                    <td><?= $val['name'] ?></td>
                                    <td><img src="<?= $val['image'] ?>" alt=""></td>
                                    <td><?= number_format((float)$val['price']) ?>đ</td>
                                    <td>
                                        <?= $val['qty'] ?>
                                    </td>
                                    <td>
                                        <?= number_format((float)$val['price'] * $val['qty']) ?>đ
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
        </div>
        <div class="payment" style="height: auto">
            <div class="box" style="width: auto">
                <p><strong>Tổng tiền cần thanh toán:</strong><span id="total_Price">
                        <?php $total = 0;
                        if (isset($data_index['cart']) && $data_index !== NULL) { ?>
                            <?php foreach ($data_index['cart'] as $key => $val) { ?>
                                <?php $total = $total + $val['price'] * $val['qty']; ?>
                            <?php } ?>
                        <?php } ?>
                        <?= number_format($total); ?>
                        đ</span></p>
            </div>
        </div>
        <div class="payment_cart">
            <h3>Thông tin liên hệ</h3>
            <form action="" method="post" enctype="application/x-www-form-urlencoded" id="paymentForm">
                <div class="item">
                    <div>
                        <?php if (!empty($provinces) && is_array($provinces)) { ?>
                            <select name="data_post[province]" id="province" required>
                                <?php foreach ($provinces as $province) { ?>
                                    <option value="<?= $province['code'] ?>"><?= $province['name'] ?></option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <input type="text" name="data_post[province]" class="form-control" placeholder="Tỉnh" required />
                        <?php } ?>
                    </div>
                </div>

                <div class="item">
                    <div>
                        <input type="radio" name="data_post[payment_method]" value="momo" id="momoPayment" required>
                        <label for="momoPayment">Thanh toán Momo QR</label>
                    </div>
                    <div>
                        <input type="radio" name="data_post[payment_method]" value="cash" id="cashOnDelivery" required>
                        <label for="cashOnDelivery">Thanh toán khi nhận hàng</label>
                    </div>
                </div>

                <div class="item">
                    <div>
                        <?php if (count($data_index['user']['address']) > 0) { ?>
                            <select name="data_post[address]" id="">
                                <?php foreach ($data_index['user']['address'] as $key => $value) { ?>
                                    <option value="<?= $value ?>"><?= $value ?></option>
                                <?php } ?>
                            </select>
                        <?php } else { ?>
                            <input type="text" name="data_post[address]" class="form-control" placeholder="Địa chỉ" required />
                        <?php } ?>
                    </div>
                    <div>
                        <input type="text" name="data_post[phone]" value="<?= $data_index['user']['phoneNumber'] ?>" class="form-control" placeholder="Số điện thoại" required />
                    </div>
                </div>
                <div class="item">
                    <div>
                        <input type="email" name="data_post[email]" value="<?= $data_index['user']['email'] ?>" class="form-control" placeholder="email" required />
                    </div>
                </div>
                <div class="item">
                    <div>
                        <textarea type="text" name="data_post[note]" class="form-control" placeholder="Ghi chú" rows="5"></textarea>
                    </div>
                </div>
                <div class="item">
                    <button type="submit">Thanh toán</button>
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="payment">
        <div class="box__left">
            Không có sản phẩm nào ! <a href="#" class="payment__btn">Tiếp tục mua hàng</a>
        </div>
    </div>
<?php } ?>
</div>
</section>
<script>
    document.getElementById('province').addEventListener('change', function() {
        var provinceCode = this.value;
        fetch('/cart/getDistrictsByProvince?provinceCode=' + provinceCode)
            .then(response => response.json())
            .then(districts => {
                var districtDropdown = document.getElementById('district');
                districtDropdown.innerHTML = '';
                districts.forEach(function(district) {
                    var option = document.createElement('option');
                    option.value = district.code;
                    option.textContent = district.name;
                    districtDropdown.appendChild(option);
                });
            }).catch(error => console.error('Error:', error));
    });

    document.getElementById('momoPayment').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('paymentForm').action = 'cart/MomoPayment';
        }
    });

    document.getElementById('cashOnDelivery').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('paymentForm').action = 'cart/payment';
        }
    });
</script>