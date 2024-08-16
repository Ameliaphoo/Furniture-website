<?php 
require_once "../assets/includes/navagationside.php";
require_once "../assets/Database/Connection.php";

if(isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT orders.id AS id, order_detail.quantity, orders.id AS order_id, users.uname, orders.payment_type, orders.address, products.product_id, products.product_name, products.product_price, products.product_brand, products.product_image, orders.status 
        FROM order_detail 
        JOIN orders ON orders.id = order_detail.order_id 
        JOIN products ON products.product_id = order_detail.product_id 
        JOIN users ON users.uid = orders.user_id 
        WHERE orders.id = :orderId");
    $stmt->execute(['orderId' => $orderId]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(!$orders) {
        echo "Order Items not found.";
        exit;
    }

    // Query to calculate the total price
    $totalPriceStmt = $pdo->prepare("SELECT SUM(order_detail.quantity * products.product_price) AS total_price 
                                     FROM order_detail 
                                     JOIN products ON products.product_id = order_detail.product_id 
                                     WHERE order_detail.order_id = :orderId");
    $totalPriceStmt->execute(['orderId' => $orderId]);
    $totalPrice = $totalPriceStmt->fetch(PDO::FETCH_ASSOC)['total_price'];
} else {
    echo "No order ID provided.";
    exit;
}

if (isset($_POST['confirm_status'])) {
    $status  = $_POST['statusSelect'];
    $id = $_POST['proID'];
    $stmt = $pdo->prepare("UPDATE orders SET status=:status WHERE id=:id");
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();
    header("Location: order.php?status=ok");
    exit;
}
?>

<div class="p-5 mt-2">
    <a class="text-decoration-none btn btn-outline-primary" href="order.php"><<< Back</a>
    <h1 class="admin_title">Order Details</h1>
  
    <div class="product block">
        <h1 class="font-bold"><label for="order_id" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Order ID</label></h1>
        <input value="<?= $orders[0]['order_id'] ?>" type="text" placeholder="Order ID" name="order_id" id="order_id" class="block w-30 px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
    </div>
    <div class="product block">
        <h1 class="font-bold"><label for="uname" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Customer Name</label></h1>
        <input value="<?= $orders[0]['uname']; ?>" type="text" placeholder="Customer Name" name="uname" id="uname" class="block w-30 px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
    </div>
    <div class="product block">
        <h1 class="font-bold"><label for="payment_type" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Payment Type</label></h1>
        <input value="<?= $orders[0]['payment_type']; ?>" type="text" placeholder="Payment Type" name="payment_type" id="payment_type" class="block w-30 px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
    </div>
    <div class="product block">
        <h1 class="font-bold"><label for="total_price" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Total Price</label></h1>
        <input value="$<?= number_format($totalPrice, 2); ?>" type="text" placeholder="Total Price" name="total_price" id="total_price" class="block w-30 px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
    </div>
    <div class="product block">
        <h1 class="font-bold"><label for="address" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Address</label></h1>
        <input value="<?= $orders[0]['address'] ;?>" type="text" placeholder="Address" name="address" id="address" class="block w-30 px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
    </div>
</div>
<div class="px-5">
    <div class="cardHeader p-10">
        <h1 class="admin_title"></h1>
    </div>

    <div class="w-full rounded-sm bg-white px-5 pt-6 pb-2.5 sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="border-y-2">
                    <tr class="text-center bg-gray-2 dark:bg-meta-4">
                        <td class="py-3 text-center">Image</td>
                        <td class="py-3 text-center">Product Name</td>
                        <td class="py-3 text-center">Brand</td>
                        <td class="py-3 text-center">Quantity</td>
                        <td class="py-3 text-center">Price</td>
                        <td class="py-3 text-center">Status</td>
                        <td class="py-3 text-center">Action</td>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <img src="../<?= $order['product_image']; ?>" alt="<?= $order['product_name']; ?>" class="h-16 rounded-lg" />
                        </td>
                        <td class="border-b w-12 text-center border-[#eee] py-5 dark:border-strokedark">
                            <h5 class="font-medium text-black"><?= $order['product_name']; ?></h5>
                        </td>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <h5 class="font-medium text-black"><?= $order['product_brand']; ?></h5>
                        </td>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <h5 class="font-medium text-black"><?= $order['quantity']; ?></h5>
                        </td>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <h5 class="font-medium text-black"><?= $order['product_price']; ?></h5>
                        </td>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <?php
                            $status = $order['status'];
                            $color_class = '';
                            switch ($status) {
                                case 'Pending':
                                    $color_class = 'text-blue-500';
                                    break;
                                case 'Processing':
                                    $color_class = 'text-yellow-500';
                                    break;
                                case 'Shipped':
                                    $color_class = 'text-green-500';
                                    break;
                                case 'Delivered':
                                    $color_class = 'text-gray-500';
                                    break;
                                case 'Cancelled':
                                    $color_class = 'text-red-500';
                                    break;
                                default:
                                    $color_class = 'text-black';
                                    break;
                            }
                            ?>
                            <h5 class="font-medium <?= $color_class; ?>"><?= $status; ?></h5>
                        </td>
                        <td class="border-b border-[#eee] py-5 dark:border-strokedark">
                            <div class="flex justify-center items-center space-x-3.5">
                                <button name="update" class="hover:text-green-700" onclick="setAndToggleAlert(<?= $order['order_id']; ?>, '<?= $status; ?>')">
                                    <svg class="feather feather-edit" fill="none" width="18" height="18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="update_status" class="fixed top-20 right-0 transform -translate-x-1/2 -translate-y-[350px] duration-300 opacity-0 bg-slate-100 shadow-lg rounded-lg p-8 z-30">
    <form method="POST">
        <input type="hidden" name="proID" id="update_pro_id_input" value="">
        <div class="flex justify-center">
            <div class="flex justify-center items-center border border-green-500 rounded-full h-12 w-12">
                <i class="fa-solid fa-pen-to-square text-3xl text-green-500"></i>
            </div>
        </div>
        <h1 class="text-xl text-slate-900 text-center mt-3">Update Order Status?</h1>
        <select id="statusSelect" name="statusSelect" class="block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
            <option value="Pending">Pending</option>
            <option value="Processing">Processing</option>
            <option value="Shipped">Shipped</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>
        </select>
        <div class="w-full mt-5 flex justify-end gap-5 items-center">
            <button type="submit" name="confirm_status" class="bg-green-800 text-white text-md text-center rounded-lg shadow-lg hover:bg-green-950 duration-300 px-3 py-1">Yes</button>
            <button type="button" onclick="toggleAlert('update_status','close')" class="bg-red-500 text-white text-md text-center rounded-lg shadow-lg hover:bg-red-600 duration-300 px-3 py-1">No</button>
        </div>
    </form>
</div>

<script>
function setAndToggleAlert(proID, status) {
    document.getElementById('update_pro_id_input').value = proID;
    document.getElementById('statusSelect').value = status;
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
