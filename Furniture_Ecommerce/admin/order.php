<?php 
require_once "../assets/includes/navagationside.php";
require_once "../assets/Database/Connection.php";

// Modify the SQL query to calculate the total price for each order
$stmt = $pdo->prepare("SELECT orders.id AS id, order_detail.quantity, orders.id AS order_id, users.uname, orders.payment_type, orders.address, products.product_id, products.product_name, products.product_price, SUM(order_detail.quantity * products.product_price) AS total_price, orders.status 
FROM order_detail 
JOIN orders ON orders.id = order_detail.order_id 
JOIN products ON products.product_id = order_detail.product_id 
JOIN users ON users.uid = orders.user_id 
GROUP BY orders.id");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<div class="px-5">
    <div class="cardHeader">
        <h1 class="admin_title">Order List</h1>
    </div>
    <div class="w-full rounded-sm bg-white px-5 pt-6 pb-2.5 sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="border-y-2">
                    <tr class="text-center bg-gray-2 dark:bg-meta-4">
                        <td class="py-3 text-center w-12 pr-2">Order Code</td>
                        <td class="py-3 text-center">User</td>
                        <td class="py-3 text-center">Payment Type</td>
                        <td class="py-3 text-center">Total Price</td>
                        <td class="py-3 text-center">Address</td>
                        <td class="py-3 text-center">Status</td>
                        <td class="py-3 text-center">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <h5 class="font-medium text-black"><?php echo $order['id']; ?></h5>
                        </td>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <h5 class="font-medium text-black"><?php echo $order['uname']; ?></h5>
                        </td>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <h5 class="font-medium text-black"><?php echo $order['payment_type']; ?></h5>
                        </td>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <h5 class="font-medium text-black">$<?php echo number_format($order['total_price'], 2); ?></h5>
                        </td>
                        <td class="border-b text-center border-[#eee] py-5 dark:border-strokedark">
                            <h5 class="font-medium text-black"><?php echo $order['address']; ?></h5>
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
                            <h5 class="font-medium <?php echo $color_class; ?>"><?php echo $status; ?></h5>
                        </td>
                        <td class="border-b border-[#eee] py-5 dark:border-strokedark">
                            <div class="flex justify-center items-center space-x-3.5">
							
								<a href="orderdetail.php?id=<?= $order['id']; ?>"class="hover:text-emerald-700">
								<svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none"
									xmlns="http://www.w3.org/2000/svg">
									<path
									d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.20624 8.99981 3.20624C14.5686 3.20624 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.85605 8.99999C2.4748 10.0406 4.89356 13.5562 8.99981 13.5562C13.1061 13.5562 15.5248 10.0406 16.1436 8.99999C15.5248 7.95936 13.1061 4.44374 8.99981 4.44374C4.89356 4.44374 2.4748 7.95936 1.85605 8.99999Z"
									fill="" />
									<path
									d="M9 11.3906C7.67812 11.3906 6.60938 10.3219 6.60938 9C6.60938 7.67813 7.67812 6.60938 9 6.60938C10.3219 6.60938 11.3906 7.67813 11.3906 9C11.3906 10.3219 10.3219 11.3906 9 11.3906ZM9 7.875C8.38125 7.875 7.875 8.38125 7.875 9C7.875 9.61875 8.38125 10.125 9 10.125C9.61875 10.125 10.125 9.61875 10.125 9C10.125 8.38125 9.61875 7.875 9 7.875Z"
									fill="" />
								</svg>
								</a>
								<a href="productUpdate.php?id=<?=  $product['product_id'];  ?>" class="hover:text-amber-600">
                                <button name="update" class="hover:text-green-700" onclick="setAndToggleAlert(<?php echo $order['id']; ?>, '<?php echo $order['status']; ?>')">
                                    <svg class="feather feather-edit" fill="none" width="18" height="18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
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
            <button onclick="toggleAlert('update_status','close')" type="button" class="bg-red-500 text-white text-md text-center rounded-lg shadow-lg hover:bg-red-600 duration-300 px-3 py-1">No</button>
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

<?php
if (isset($_GET['status'])) {
    ?>
        toastr.success('Order Status Update Successful', {
            closeButton: true,
            progressBar: true
        });
    <?php
}
?>
</script>

