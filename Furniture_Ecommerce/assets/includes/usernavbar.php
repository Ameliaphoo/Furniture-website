<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
ob_start();
session_start();

require_once "../assets/includes/header.php";
require_once "../assets/Database/Connection.php";

if(isset($_POST['logout'])){
    unset($_SESSION['user']);
    unset($_SESSION['cart']);
}

if(isset($_POST['addToCart'])) {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("SELECT * FROM products JOIN category ON products.category_id = category.category_id WHERE product_id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!isset($_SESSION['cart']['product_id'])) {
        $_SESSION['cart'][$product['product_id']] = $product;
        $_SESSION['cart'][$product['product_id']]["qty"] = 1;
    } else {
        $_SESSION['cart'][$product['product_id']]["qty"] += 1;
    }
}

?>

<body>
    <!-- header -->
    <header class=" shadow-sm bg-white">
        <div class="container flex items-center justify-between">
            <a href=<?="./"?> class=" text-2xl font-bold ml-5 ">
				<ion-icon name="flower"></ion-icon>
                </span>
                <span class="title">Nova</span>
            </a>

            <form method="GET" action="shop.php">
                <div class="w-full max-w-xl relative flex">
                    <span class="absolute left-4 top-4 text-lg text-gray-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="search" id="search"
                        class="w-full border-b border-primary border-r-0 pl-12 py-3 pr-3 rounded-l-md focus:outline-none hidden md:flex"
                        placeholder="search">
                    <button
                        class=" text-neutral-200 border-b border-primary bg-[#186D4E] px-8 rounded-r-md hover:bg-green-800 hover:text-primary justify-center items-center  transition hidden md:flex">Search
                    </button>
                </div>
            </form>
            <div class="flex items-center space-x-4 pr-3">
                <a href="./cart.php" class="relative text-center text-gray-700 hover:text-primary transition relative">
                    <?php
                        $qty =0;
                        if (isset($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $value) {
                                $qty += $value['qty'];
                            }
                        }
                    ?>
                        <span class=" absolute z-50 -top-3 -right-1"><?php echo $qty ?></span>
                    <div class="text-2xl">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </div>
                    <div class="text-xs leading-3">Cart</div>
                    <div
                        class="absolute -right-3 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-primary text-white text-xs">
                        2</div>
                </a>
            </div>
        </div>
    </header>
    <!-- ./header -->

    <!-- navbar -->
    <nav class="bg-green-900 px-4">
        <div class="container flex">
            <div class="px-8 py-4 bg-primary md:flex items-center cursor-pointer relative group hidden">
                <span class="text-white">
                    <i class="fa-solid fa-bars"></i>
                </span>
                <span class="capitalize ml-2 text-neutral-200 ">All Categories</span>

                <!-- dropdown -->
                <div
                    class="absolute w-full z-50 left-0 top-full bg-white shadow-md py-3 divide-y divide-gray-300 divide-dashed opacity-0 group-hover:opacity-100 transition duration-300 invisible group-hover:visible">
                    <a href="shop.php?category=Sofa" class="flex bg-white items-center px-6 py-3 hover:bg-gray-100 transition">
                        <img src="../assets/img/icons/sofa.svg" alt="sofa" class="w-5 h-5 object-contain">
                        <span class="ml-6 text-gray-600 text-sm">Sofa</span>
                    </a>
                    <a href="shop.php?category=Lamp" class="flex bg-white items-center px-6 py-3 hover:bg-gray-100 transition">
                        <img src="../assets/img/icons/terrace.svg" alt="terrace" class="w-5 h-5 object-contain">
                        <span class="ml-6 text-gray-600 text-sm">Lamp</span>
                    </a>
                    <a href="shop.php?category=Bed" class="flex bg-white items-center px-6 py-3 hover:bg-gray-100 transition">
                        <img src="../assets/img/icons/bed.svg" alt="bed" class="w-5 h-5 object-contain">
                        <span class="ml-6 text-gray-600 text-sm">Bed</span>
                    </a>
                    <a href="shop.php?category=Table" class="flex bg-white items-center px-6 py-3 hover:bg-gray-100 transition">
                        <img src="../assets/img/icons/office.svg" alt="office" class="w-5 h-5 object-contain">
                        <span class="ml-6 text-gray-600 text-sm">Table</span>
                    </a>
                    <a href="shop.php?category=Chair" class="flex bg-white items-center px-6 py-3 hover:bg-gray-100 transition">
                        <img src="../assets/img/icons/outdoor-cafe.svg" alt="outdoor" class="w-5 h-5 object-contain">
                        <span class="ml-6 text-gray-600 text-sm">Chair</span>
                    </a>
                    <a href="shop.php?category=Mattress" class="flex bg-white items-center px-6 py-3 hover:bg-gray-100 transition">
                        <img src="../assets/img/icons/bed-2.svg" alt="Mattress" class="w-5 h-5 object-contain">
                        <span class="ml-6 text-gray-600 text-sm">Mattress</span>
                    </a>
                </div>
            </div>

            <div class="flex items-center justify-between flex-grow md:pl-12 py-5">
                <div class="flex items-center space-x-6 capitalize">
                    <a href="./" class="text-gray-200 hover:text-white transition">Home</a>
                    <a href="./shop.php" class="text-gray-200 hover:text-white transition">Shop</a>
                </div>
                <?php 
                if(isset($_SESSION['user'])){
                    ?>
                    <!-- <h1 class=" font-3xl font-bold text-neutral-200"><?= $_SESSION['user']['uname'] ?></h1> -->
                    <div class="relative user border-4 border-[#186D4E] rounded-full">
                        <img src="../assets/img/customer01.jpg" alt="" class="udropmenu" onclick="toggleDropdown()">
                    </div>
                    <div id="dropdown-menu" class="udropdown-menu hidden absolute top-16 z-50 bg-black -right-2 bg-white shadow-lg rounded-md py-2">
                        <?php
                        if($_SESSION['user']['utype'] == "Admin"){
                        ?>
                        <p class="block px-4  text-center py-2 text-gray-800 hover:bg-gray-200"><?= $_SESSION['user']['uname'] ?></p>
                        <a href="../admin/home.php" class="block px-4  text-center py-2 text-gray-800 hover:bg-gray-200">Admin</a>
                        <?php } ?>
                        <a href="order.php" class="block px-4  text-center py-2 text-gray-800 hover:bg-gray-200">My Orders</a>
                        <form method="post">
                            <button name="logout" class="block w-full px-4 py-2 text-gray-800 hover:bg-gray-200">Sign Out</buttonref=>
                        </form>
                    </div>
                <?php }else{ ?>
                <a href="./login.php" class="text-gray-200 hover:text-white transition">Login</a>
                <?php }?>
            </div>
        </div>
    </nav>
    <!-- ./navbar -->
    <script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('hidden');
    }
</script>
    