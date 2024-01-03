<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sarah</title>
    <link rel="icon" href="hoa.png" />
    <link rel="stylesheet" href="public/build/css/orderDetail.css">
</head>

<body>
    <!-- Print Button -->
    <div style="display: flex">
        <a href="./home/index" class="print-button">Tiếp tục mua hàng</a>
        <a href="javascript:window.print()" class="print-button">In hoá đơn mua hàng</a>
    </div>

    <!-- Invoice -->
    <div id="invoice">
        <!-- Header -->
        <div class="row">
            <div class="col-md-6">
                <div id="logo">
                    <img src="hoa.png" alt="" />
                </div>
            </div>
            <div class="col-md-6">
                <p id="details">
                    <strong>Mã đơn hàng: </strong>
                    <i><?php echo $order['id']?></i>
                    <br />
                    <strong>Ngày đặt: </strong>
                    <i><?php echo $order['created_at'] ?></i>
            <br />
          </p>
        </div>
      </div>
      <!-- Client & Supplier -->
      <div class="row">
        <div class="col-md-12">
          <h2>Hoá đơn</h2>
        </div>

        <div class="col-md-6">
          <strong class="margin-bottom-5">Chi nhánh</strong>
          <p>
            NF <br />
           47/21 Lù Lo<br />TP.Thủ Đức - TP.Hồ Chí
            Minh <br />
          </p>
        </div>

        <div class="col-md-6">
          <strong class="margin-bottom-5">Khách hàng</strong>
          <p>
            <i text="${order.fullname}"></i> <br />
            <i text="'SĐT: ' + ${order.phone}"></i> <br />
            <i text="'Email: ' + ${order.email}"></i> <br />
          </p>
        </div>
      </div>
      <!-- Invoice -->
      <div class="row">
        <div class="col-md-12">
          <table class="margin-top-20">
            <tr>
              <th>Tên sản phẩm</th>
              <th>Số lượng</th>
              <th>Giá</th>
            </tr>
            <?php foreach ($groupedOrderDetails as $product) : ?>
              <tr>
                <td><?php echo $product['productName']; ?></td>
                <td><?php echo $product['qty']; ?></td>
                <td><?php echo number_format($product['price'] * $product['qty']); ?>  VNĐ</td>
              </tr>
              <?php endforeach; ?>
          </table>

          <p>
            <strong class="margin-bottom-5">Địa chỉ: </strong>
            <i text="Cái này là địa chỉ"></i><br />
            <strong class="margin-bottom-5">Phương thức thanh toán: </strong>
            <i><?php echo $order['payment_method'] ?></i>
          </p>
        </div>

        <div class="col-md-4 col-md-offset-8">
          <table id="totals">
            <tr>
              <th>Tổng tiền</th>
              <th>
                <span><?php echo number_format($order['total']); ?>  VNĐ</span>
              </th>
            </tr>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <ul id="footer">
            <li><span>www.sarah.com</span></li>
            <li>tn0909pph@gmail.com</li>
            <li>0707396920</li>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>