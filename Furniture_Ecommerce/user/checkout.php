<?php 
require_once "../assets/includes/usernavbar.php";

$qty = 0;
$total = 0;
$subtotal = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    
    $productId = $_POST['product_id'];

    if (isset($_POST['increase_quantity'])) {
       
        $_SESSION['cart'][$productId]['qty'] += 1;
    } elseif (isset($_POST['decrease_quantity'])) {

        if ($_SESSION['cart'][$productId]['qty'] > 1) {
            $_SESSION['cart'][$productId]['qty'] -= 1;
        } else {
            unset($_SESSION['cart'][$productId]);
        }
    } elseif (isset($_POST['remove_item'])) {
        unset($_SESSION['cart'][$productId]);
    }

    header("Location: Cart.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addOrder'])) {
    $userId = $_SESSION['user']['uid'];
    $address = $_POST['address'];
    $paymentType = $_POST['c_payment'];

    $insertOrderQuery = "INSERT INTO orders (user_id, payment_type, address) VALUES (:userId, :paymentType, :address)";
    $stmt = $pdo->prepare($insertOrderQuery);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':paymentType', $paymentType, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->execute();

    $orderId = $pdo->lastInsertId();

    foreach ($_SESSION['cart'] as $product) {
        $productId = $product['product_id'];
        $quantity = $product['qty'];

        $insertOrderItemQuery = "INSERT INTO order_detail (order_id, product_id, quantity) VALUES (:orderId, :productId, :quantity)";
        $stmt = $pdo->prepare($insertOrderItemQuery);
        $stmt->bindParam(':orderId', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    unset($_SESSION['cart']);

    header("Location: index.php?checkout=successfull");
    exit();
}
?>

<main class="px-5">

    <!-- breadcrumb -->
    <div class="container py-4 flex items-center gap-3">
        <a href="./" class="text-green-900 text-base">
            <i class="fa-solid fa-house"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-medium">Checkout</p>
    </div>
    <!-- ./breadcrumb -->

    <!-- wrapper -->
    <form method="POST">
        <div class="container grid grid-cols-12 items-start pb-16 pt-4 gap-6">
        <div class="col-span-8 border border-gray-200 p-4 rounded">
            <h3 class="text-lg font-medium capitalize mb-4">Checkout</h3>
            <div class="space-y-4">
                <div>
                    <label for="first-name" class="text-gray-600">Username <span
                            class="text-green-900">*</span></label>
                    <p class=" block w-full px-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
                        <?= $_SESSION['user']['uname'] ?>
                    </p>
                </div>
                <div>
                    <label for="first-name" class="text-gray-600">Email <span
                            class="text-green-900">*</span></label>
                    <p class=" block w-full px-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
                        <?= $_SESSION['user']['uemail'] ?>
                    </p>
                </div>
                <div>
                    <label for="address" class="text-gray-600">Street address</label>
                    <input value="<?= $_SESSION['user']['uaddress']?>" autofocus class=" block w-full px-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" type="text" name="address" id="address" class="input-box">
                </div>
                <div>
                    <label for="c_payment" class="text-gray-600">Payment Type</label>
                    <select id="c_payment" name="c_payment" class=" block w-full px-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
                            <option value="Cash">
                                Cash
                            </option>
                            <option value="MPU">
                                MPU
                            </option>
                            <option value="Visa">
                                Visa
                            </option>
                    </select>
                </div>
            </div>

        </div>

        <div class="col-span-4 border border-gray-200 p-4 rounded">
            <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">order summary</h4>
            <div class="space-y-2">
            <?php foreach ($_SESSION['cart'] as $product): ?>
                <div class="flex justify-between">
                    <div>
                        <h5 class="text-gray-800 font-medium w-60"><?= $product['product_name'] ?></h5>
                        <p class="text-sm text-gray-600">Brand: <?= $product['product_brand'] ?></p>
                    </div>
                    <p class="text-gray-600">
                        x<?= $product['qty'] ?>
                    </p>
                    <p class="text-gray-800 font-medium">$<?= $product['product_price'] ?></p>
                </div>
                <?php
            $qty += $product['qty'];
            $subtotal += $product['product_price'] * $product['qty'];
            endforeach;
            $total = $subtotal + 20;
            ?>
        </div>

            <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                <p>subtotal</p>
                <p>$<?= $subtotal ?></p>
            </div>

            <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                <p>shipping</p>
                <p>Free</p>
            </div>

            <div class="flex justify-between text-gray-800 font-medium py-3 uppercas">
                <p class="font-semibold">Total</p>
                <p>$<?= $total ?></p>
            </div>
            <button type="button" onclick="setAndToggleAlert()"
                class="block w-full py-3 px-4 text-center text-white bg-green-900 border border-green-900 rounded-md hover:bg-transparent hover:text-green-900 transition font-medium">Place
                order</button>
        </div>

        </div>
        <div id="checkoutAlert" class="fixed top-20 right-0 transform -translate-x-1/2 -translate-y-[350px] duration-300 opacity-0 bg-slate-100 shadow-lg rounded-lg p-8 z-30">
                <div class="flex justify-center">
                    <div class="flex justify-center items-center border border-green-500 rounded-full h-12 w-12">
                        <i class="fas fa-check text-3xl text-green-500"></i>
                    </div>
                </div>

                <h1 class="text-xl text-slate-900 text-center mt-3">Are you sure want to place order?</h1>

                    <button type="submit" name="addOrder" class="bg-green-800 text-white text-md text-center rounded-lg shadow-lg hover:bg-green-950 duration-300 px-3 py-1">
                        Yes
                    </button>
                    <button onclick="toggleAlert('checkoutAlert','close')" type="button"
                            class="bg-red-500 text-white text-md text-center rounded-lg shadow-lg hover:bg-red-600 duration-300 px-3 py-1">
                        No
                    </button>
                </div>
</div>
<!-- Delete alert end  -->
    </form>
    <!-- ./wrapper -->
</main>

<script>

function setAndToggleAlert() {
    toggleAlert('checkoutAlert', 'show');
}

function toggleAlert(alertId, action) {
        var alert = document.getElementById(alertId);
        if (action === 'show') {
            alert.classList.remove('opacity-0');
            alert.classList.remove('-translate-y-[350px]');
        } else if (action === 'close') {
            alert.classList.add('opacity-0');
            alert.classList.add('-translate-y-[350px]');
        }
    }
</script>
