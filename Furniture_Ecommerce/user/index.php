<?php 
require_once "../assets/includes/usernavbar.php";

	$stmt= $pdo-> query("SELECT * FROM products JOIN category ON products.category_id = category.category_id ORDER BY RAND() DESC  LIMIT 4;");
	$Topproducts= $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt= $pdo-> query("SELECT * FROM category");
	$categories= $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

    <!-- banner -->
    <div class="px-5 bg-cover bg-no-repeat bg-center py-36" style="background-image: url('../assets/img/banner-bg.jpg');">
        <div class="container">
            <h1 class="text-6xl text-gray-800 font-medium mb-4 capitalize">
                best collection for <br> home decoration
            </h1>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Aperiam <br>
                accusantium perspiciatis, sapiente
                magni eos dolorum ex quos dolores odio</p>
            <div class="mt-12">
                <a href="./shop.php" class="bg-green-950 border border-primary text-white px-8 py-3 font-medium 
                    rounded-md hover:bg-transparent hover:text-green-950 transition">Shop Now</a>
            </div>
        </div>
    </div>
    <!-- ./banner -->

    <!-- features -->
    <div class="container py-16">
        <div class="w-10/12 grid grid-cols-1 md:grid-cols-3 gap-6 mx-auto justify-center">
            <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                <img src="../assets/img/icons/delivery-van.svg" alt="Delivery" class="w-12 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">Free Shipping</h4>
                    <p class="text-gray-500 text-sm">Order over $200</p>
                </div>
            </div>
            <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                <img src="../assets/img/icons/money-back.svg" alt="Delivery" class="w-12 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">Money Rturns</h4>
                    <p class="text-gray-500 text-sm">30 days money returs</p>
                </div>
            </div>
            <div class="border border-primary rounded-sm px-3 py-6 flex justify-center items-center gap-5">
                <img src="../assets/img/icons/service-hours.svg" alt="Delivery" class="w-12 h-12 object-contain">
                <div>
                    <h4 class="font-medium capitalize text-lg">24/7 Support</h4>
                    <p class="text-gray-500 text-sm">Customer support</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ./features -->

    <!-- categories -->
    <div class="container py-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">shop by category</h2>
        <div class="grid grid-cols-3 gap-3">
            <div class="relative rounded-sm overflow-hidden group">
                <img src="../assets/img/category/category-1.jpg" alt="category 1" class="w-full">
                <a href="shop.php?category=Bed"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Bedroom</a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="../assets/img/category/category-2.jpg" alt="category 1" class="w-full">
                <a href="shop.php?category=Mattress"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Mattrass</a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="../assets/img/category/category-3.jpg" alt="category 1" class="w-full">
                <a href="shop.php?category=Lamp"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Lamp
                </a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="../assets/img/category/category-4.jpg" alt="category 1" class="w-full">
                <a href="shop.php?category=Sofa"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Sofa</a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="../assets/img/category/category-5.jpg" alt="category 1" class="w-full">
                <a href="shop.php?category=Chair"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Chair</a>
            </div>
            <div class="relative rounded-sm overflow-hidden group">
                <img src="../assets/img/category/category-6.jpg" alt="category 1" class="w-full">
                <a href="shop.php?category=Table"
                    class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">Table</a>
            </div>
        </div>
    </div>
    <!-- ./categories -->

    <!-- new arrival -->
    <div class="container px-5 pb-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">Top new arrival</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <?php foreach($Topproducts as $product){?>
                <div class="bg-white shadow rounded overflow-hidden group">
                        <div class="relative">
                            <a href="./detail.php?id=<?php echo $product['product_id']; ?>">
                                <img src="../<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>"  class="w-full h-60">
                            </a>
                        </div>
                        <div class="pt-4 pb-3 px-4">
                                <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-primary transition"><?= $product['product_name']; ?></h4>
                            <div class="items-baseline mb-1">
                                <p class="text-xl text-primary font-semibold">$<?= $product['product_price'] ?></p>
                                <p class="text-sm text-gray-400">Stock: <?= $product['product_stock'] ?></p>
                            </div>
                        </div>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?= $product['product_id']; ?>" />
                            <button type="submit" name="addToCart"
                            class="block w-full py-1 text-center text-white bg-green-800 border border-primary rounded-b hover:bg-green-950 hover:text-primary transition">Add
                            to cart</a>
                            </button>
                        </form>
                    </div>
            <?php } ?>
        </div>
    </div>
    <!-- ./new arrival -->

    <?php require_once "../assets/includes/footer.php"; ?>
    <script>
    <?php
        if (isset($_GET['success'])) {
            ?>
                toastr.success('Login Successfull', 'Welcome User : <?php echo $_SESSION['user']['uname'] ?>', {
                    closeButton: true,
                    progressBar: true
                });
            <?php
        }
        if (isset($_GET['checkout'])) {
            ?>
                toastr.success('Order Successfull', {
                    closeButton: true,
                    progressBar: true
                });
            <?php
        }
    ?>
</script>
