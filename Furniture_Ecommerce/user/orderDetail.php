<?php 
require_once "../assets/includes/usernavbar.php";

$qty = 0;
$total = 0;
$subtotal = 0;

if(isset($_GET['id'])) {
    $orderId = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM order_detail JOIN products ON products.product_id = order_detail.product_id JOIN orders ON orders.id = order_detail.order_id  WHERE order_id = ?");
    $stmt->execute([$orderId]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(!$orders) {
        echo "Order Items not found.";
        exit;
    }

    if(isset($_POST['confirm_status'])) {
        $stmt = $pdo->prepare("UPDATE orders SET status='Cancelled' WHERE id=:id");
        $stmt->bindParam(':id', $orderId, PDO::PARAM_STR);
        $stmt->execute();
        header("Location: order.php");
        exit;
    }
} else {
    echo "Order ID not provided.";
    exit;
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
        <a href="./order.php" class="text-gray-600 font-medium">My Orders</a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-medium">Order Details</p>
    </div>
    <!-- ./breadcrumb -->

    <?php if(empty($orders)): ?>
            <p class="text-lg font-bold text-center">Order Id Doesnt Exist.</p>
        <?php else: ?>
            <div class="flex gap-x-5">
            <div class="h-[400px] overflow-y-scroll rounded-lg no-scrollbar md:w-2/3">
            <?php foreach ($orders as $order): ?>
                    <input type="hidden" name="product_id" value="<?= $order['product_id'] ?>">
                    <div class="justify-between p-6 mb-6 bg-white rounded-lg shadow-md sm:flex sm:justify-start">
                        <a href="detail.php?id=<?= $order['product_id'] ?>"><img src="../<?= $order['product_image'] ?>" alt="product-image" class="w-full h-16 rounded-lg sm:w-40" /></a>
                        <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                            <div class="mt-5 sm:mt-0">
                                <h2 class="text-lg font-bold text-gray-900"><?= $order['product_name'] ?></h2>
                                <p class="mt-1 text-xs text-gray-700"><?= $order['product_description'] ?></p>
                            </div>
                            <div class="flex items-center justify-between mt-4 sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                                <p class=" text-xs text-center bg-white  outline-none">Quantity: <?= $order['quantity'] ?></p>
                                <p class="text-sm">$<?= $order['product_price'] ?></p>
                            </div>
                        </div>
                    </div>
            <?php
            $qty += $order['quantity'];
            $subtotal += $order['product_price'] * $order['quantity'];
            endforeach;
            $total = $subtotal + 20;
            ?>
        </div>
        <!-- Subtotal -->
        <div class="h-full p-6 mt-6 bg-white border rounded-lg shadow-md md:mt-0 md:w-1/3">
            <div class="flex justify-between mb-2">
                <p class="text-gray-700">Subtotal</p>
                <p class="text-gray-700">$<?= $subtotal ?></p>
            </div>
            <div class="flex justify-between mb-2">
                <p class="text-gray-700">Quantity</p>
                <p class="text-gray-700"><?= $qty ?></p>
            </div>
            <div class="flex justify-between">
                <p class="text-gray-700">Shipping</p>
                <p class="text-gray-700">$20</p>
            </div>
            <hr class="my-4" />
            <div class="flex justify-between">
                <p class="text-lg font-bold">Total</p>
                <div class="">
                    <p class="mb-1 text-lg font-bold">$<?= $total ?>USD</p>
                    <p class="text-sm text-gray-700">including VAT</p>
                </div>
            </div>
            <?php
                if ($orders[0]['status'] === "Processing") {
                    echo '
                        <button onclick="setAndToggleAlert(' . $order['id'] . ')" class="w-full hover:bg-red-700 transition bg-red-600 py-3 rounded-lg mt-5 text-white">Cancel</button>
                    ';
                }
            ?>

        </div>
            </div>
        <?php endif; ?>
    <!-- ./wrapper -->
</main>

<div id="update_status" class="fixed top-20 right-0 transform -translate-x-1/2 -translate-y-[350px] duration-300 opacity-0 bg-slate-100 shadow-lg rounded-lg p-8 z-30">
            <form method="POST">
                    <input type="hidden" name="proID" id="update_pro_id_input" value="">
                <div class="flex justify-center">
                    <div class="flex justify-center items-center border border-green-500 rounded-full h-12 w-12">
						<i class="fa-solid fa-pen-to-square text-3xl text-green-500"></i>
                    </div>
                </div>

                <h1 class="text-xl text-slate-900 text-center mt-3">Cancel Order?</h1>

                    <div class="w-full mt-5 flex justify-end gap-5 items-center">
					<button type="submit" name="confirm_status" class="bg-green-800 text-white text-md text-center rounded-lg shadow-lg hover:bg-green-950 duration-300 px-3 py-1">
                        Yes
                    </button>
                    <button onclick="toggleAlert('update_status','close')" type="button"
                            class="bg-red-500 text-white text-md text-center rounded-lg shadow-lg hover:bg-red-600 duration-300 px-3 py-1">
                        No
                    </button>
					</div>
                </div>
   			</form>
    </div>

<script>

function setAndToggleAlert(proID, status) {
    document.getElementById('update_pro_id_input').value = proID;
    toggleAlert('update_status', 'show');
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