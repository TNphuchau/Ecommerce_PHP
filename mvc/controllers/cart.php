<?php
require_once 'MyController.php';
require_once "./mvc/core/redirect.php";
require_once "./mvc/helper/momo_helper.php";
class cart extends controller
{

    public $ProductModels;
    public $OrderDetailModels;
    public $MenuModels;
    public $OrderModels;
    public $MyController;
    public $SendMail;
    public $Jwtoken;
    public $ProvinceModels;
    public $DistrictModels;
    public $Authorzation;
    function __construct()
    {
        $this->ProductModels       = $this->models('ProductModels');
        $this->OrderDetailModels   = $this->models('OrderDetailModels');
        $this->OrderModels         = $this->models('OrderModels');
        $this->MyController        = new MyController();
        $this->SendMail            =  $this->helper('SendMail');
        $this->Jwtoken            =  $this->helper('Jwtoken');
        $this->Authorzation        =  $this->helper('Authorzation');
        $this->ProvinceModels        =  $this->helper('Authorzation');
        $this->Authorzation        =  $this->helper('Authorzation');
    }
    function index()
    {
        $provinceModel = new ProvinceModels();
        $provinces = $provinceModel->select_array();
        $data_index = $this->MyController->indexCustomers();
        $data = [
            'page'          => 'product/cart',
            'title'         => 'Giỏ hàng',
            'data_index'    => $data_index,
            'provinces'     => $provinces,
        ];
        $this->viewFrontEnd('frontend/masterlayout', $data);
    }
    function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->ProductModels->select_row('*', ['slug' => $_POST['slug']]);
            if (isset($_SESSION['cart'][$data['id']])) {
                $qty = $_SESSION['cart'][$data['id']]['qty'];
                $array = [
                    'productID' => $data['id'],
                    'name'      => $data['name'],
                    'slug'      => $data['slug'],
                    'image'     => $data['image'],
                    'price'     => $data['price'],
                    'qty'       => 1
                ];
                $cart = $this->cart($array);
                echo json_encode(array_values($cart));
            }
        }
    }
    function deleteproduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->ProductModels->select_row('*', ['slug' => $_POST['slug']]);
            if (isset($_SESSION['cart'][$data['id']])) {
                $qty = $_SESSION['cart'][$data['id']]['qty'];
                $array = [
                    'productID' => $data['id'],
                    'name'      => $data['name'],
                    'slug'      => $data['slug'],
                    'image'     => $data['image'],
                    'price'     => $data['price'],
                    'qty'       => -1
                ];
                $cart = $this->cart($array);
            }
            echo json_encode(array_values($_SESSION['cart']));
        }
    }
    function deleteBlockProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->ProductModels->select_row('*', ['slug' => $_POST['slug']]);
            if (isset($_SESSION['cart'][$data['id']])) {
                $qty = $_SESSION['cart'][$data['id']]['qty'];
                unset($_SESSION['cart'][$data['id']]);
            }
            echo json_encode(array_values($_SESSION['cart']));
        }
    }
    function deleteProductById()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $this->ProductModels->select_row('*', ['id' => $_POST['id']]);
            if (isset($_SESSION['cart'][$_POST['id']])) {
                unset($_SESSION['cart'][$_POST['id']]);
            }
            echo json_encode(array_values($_SESSION['cart']));
        }
    }
    function payment()
    {
        if (isset($_SESSION['user'])) {
            $verify = $this->Jwtoken->decodeToken($_SESSION['user'], KEYS);
            if ($verify != NULL && $verify != 0) {
                $auth = $this->Authorzation->checkAuthUser($verify);
                if (!$auth) {
                    $redirect = new redirect('dang-nhap.html');
                }
            }
        } else {
            $redirect = new redirect('dang-nhap.html');
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data_post = $_POST['data_post'];
            $total = 0;
            foreach ($this->MyController->getCart() as $key => $value) {
                $total += $value['price'] * $value['qty'];
            }

            $arrayOrders = [
                'accountId'     => $this->MyController->getUsers()['id'],
                'address'       => $data_post['address'],
                'phone'         => $data_post['phone'],
                'email'         => $data_post['email'],
                'note'          => $data_post['note'],
                'total'         => $total,
                'created_at'    => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                'payment_method' => $data_post['payment_method'], // Assuming the payment method is in the form data
            ];

            $orderAdd = $this->OrderModels->add($arrayOrders);
            $resultsOrders = json_decode($orderAdd, true);

            if ($resultsOrders['type'] === 'sucessFully') {
                $arrayOrderDetail = [];
                $contents = '<h3>Sản Phẩm đã đặt:</h3></br>';

                foreach ($this->MyController->getCart() as $key => $value) {
                    array_push($arrayOrderDetail, [
                        'orderId'   => $resultsOrders['id'],
                        'productId' => $value['productID'],
                        'price'     => $value['price'],
                        'qty'       => $value['qty']
                    ]);

                    $contents .= '
                    <div>Tên sản phẩm: ' . $value['name'] . '</div></br>
                    <div>Số lượng: ' . $value['qty'] . '</div></br>
                    <div>Đơn giá:' . number_format($value['price']) . 'đ</div></br>
                ';
                }

                $contents .= '<p>Tổng hóa đơn: ' . number_format($total) . 'đ</p>';
                $this->OrderDetailModels->addMultiple($arrayOrderDetail);

                // Check if the selected payment method is Momo, then redirect
               
                    // Continue with other payment methods or processing
                    $mail = $this->SendMail->send('Order', $data_post['email'], $contents, 'transon1023@gmail.com');
                    unset($_SESSION['cart']);

                    if ($mail) {
                        $redirect = new redirect('/');
                        $redirect->setFlash('flash', 'Đặt hàng thành công!');
                    }
                
            }
        }
        $provinceModel = new ProvinceModels();
        $provinces = $provinceModel->select_array();
        $districts = [];

        $data_index = $this->MyController->indexCustomers();
        $data = [
            'page'          => 'product/payment',
            'data_index'    => $data_index,
            'title'        => 'Thanh toán',
            'provinces'     => $provinces,
            'districts'     => $districts,
        ];
        $this->viewFrontEnd('frontend/masterlayout', $data);
    }

    function MomoPayment()
    {
        $data_index = $this->MyController->indexCustomers();
        $data = [
            'data_index'    => $data_index,
            'title'        => 'Thanh toán',
        ];
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $total = 0;
        foreach ($this->MyController->getCart() as $key => $value) {
            $total += $value['price'] * $value['qty'];
        }
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $total;
        $orderId = time() . "";
        $redirectUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
        $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
        $extraData = "";


        if (!empty($_POST)) {
            $partnerCode = $partnerCode;
            $accessKey = $accessKey;
            $secretKey = $secretKey;
            $orderId = time() . ""; 
            $orderInfo = "Đây là thanh toán";
            $amount = $amount;
            $ipnUrl = $ipnUrl;
            $redirectUrl = $redirectUrl;
            $extraData = $extraData;

            $requestId = time() . "";
            $requestType = "captureWallet";
            $extraData = ($extraData ? $extraData : "");
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            $data = array(
                'partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            );
            $result = execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  

            header('Location: ' . $jsonResult['payUrl']);
        }
    }
}
