<?php 
error_reporting(E_ALL); ini_set('display_errors', 1);
ob_start();
session_start();

require_once "../assets/includes/header.php";
    if ($_SESSION['user']['utype'] !== "Admin" || !isset($_SESSION['user'])) {
        header("Location: ../user/");
        exit;
    }
?>

<body>
    <!-- =============== Navigation ================ -->
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href=<?=".../admin/home.php"?>>
                        <span class="icon">
						<ion-icon name="flower"></ion-icon>
                        </span>
                        <span class="title">Nova</span>
                    </a>
                </li>

                <li>
                    <a href="./home.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href=<?="../admin/productView.php"?>>
                        <span class="icon">
                        <ion-icon name="layers-outline"></ion-icon>
                        </span>
                        <span class="title">Products</span>
                    </a>
                </li>

                <li>
                    <a href=<?="../admin/categoryView.php"?>>
                        <span class="icon">
                        <ion-icon name="apps-outline"></ion-icon>
                        </span>
                        <span class="title">Categories</span>
                    </a>
                </li>

                <li>
                    <a href=<?="../admin/order.php"?>>
                        <span class="icon">
                        <ion-icon name="bag-outline"></ion-icon>
                        </span>
                        <span class="title">Orders</span>
                    </a>
                </li>

                <li>
                    <a href=<?="../admin/userView.php"?>>
                        <span class="icon">
                        <ion-icon name="person-outline"></ion-icon>
                        </span>
                        <span class="title">Customers</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <div class="user border-4 border-[#186D4E] rounded-full">
                    <img src="../assets/img/customer01.jpg" alt="" class="dropmenu">
                </div>
                <div class="dropdown-menu hidden absolute top-14 z-50 bg-black right-2 bg-white shadow-lg rounded-md py-2">
                    <p class="block px-4  text-center py-2 text-gray-800 hover:bg-gray-200"><?= $_SESSION['user']['uname'] ?></p>
                    <a href="../user" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">User Site</a>
                    <form method="post" action="../user/">
                            <button name="logout" class="block w-full px-4 py-2 text-gray-800 hover:bg-gray-200">Sign Out</buttonref=>
                    </form>
                </div>
            </div>
        
<?php require_once "../assets/includes/footer.php"; ?>
