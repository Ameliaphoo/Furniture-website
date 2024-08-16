<?php 
require_once "../assets/includes/usernavbar.php";

$user_id = $_SESSION['user']['uid'];
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <p class="text-gray-600 font-medium">My Orders</p>
    </div>
    <!-- ./breadcrumb -->

    <div class="w-full rounded-sm  bg-white pt-6 pb-2.5 xl:pb-1">
			<div class="max-w-full overflow-x-auto">
				<table class="w-full table-auto">
				<thead class=" border-y-2 ">
					<tr class="text-center  bg-gray-2 dark:bg-meta-4">
						<td class="py-3 text-center">Order ID</td>
						<td class="py-3 text-center">Payment Type</td>
						<td class="py-3 text-center">Address</td>
						<td class="py-3 text-center">Status</td>
						<td class="py-3 text-center">Action</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($orders as $order) { ?>
					<tr>
						<td class="border-b text-center border-[#eee] py-5  dark:border-strokedark">
							<h5 class="font-medium text-black "><?php echo $order['id']; ?></h5>
						</td>
                        <td class="border-b text-center border-[#eee] py-5  dark:border-strokedark">
							<h5 class="font-medium text-black "><?php echo $order['payment_type']; ?></h5>
						</td>
                        <td class="border-b text-center border-[#eee] py-5  dark:border-strokedark">
							<h5 class="font-medium text-black "><?php echo $order['address']; ?></h5>
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
                        <td class=" border-b border-[#eee] py-5  dark:border-strokedark">
							<div class="flex justify-center items-center space-x-3.5">
                                <a href="orderDetail.php?id=<?= $order['id']; ?>"class="hover:text-emerald-700">
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
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
				</table>
			</div>
			</div>

</main>