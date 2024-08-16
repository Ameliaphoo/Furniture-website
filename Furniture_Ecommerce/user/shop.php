<?php 
require_once "../assets/includes/usernavbar.php";

// Fetch categories
$stmt = $pdo->query("SELECT * FROM category;");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize products
$products = [];

$search = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $conditions = [];
    $params = [];

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];
        $conditions[] = "product_name LIKE :search";
        $params[':search'] = "%$search%";
    }

    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $cat = $_GET['category'];
        $conditions[] = "category_name = :category";
        $params[':category'] = $cat;
    }

    if (isset($_GET['min']) && isset($_GET['max']) && is_numeric($_GET['min']) && is_numeric($_GET['max'])) {
        $min = $_GET['min'];
        $max = $_GET['max'];
        $conditions[] = "product_price BETWEEN :min AND :max";
        $params[':min'] = $min;
        $params[':max'] = $max;
    }

    $whereClause = (!empty($conditions)) ? "WHERE " . implode(" AND ", $conditions) : "";

    $sql = "SELECT * FROM products JOIN category ON products.category_id = category.category_id $whereClause";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
}
?>

<main class="px-5">
    <!-- breadcrumb -->
    <div class="container py-4 flex items-center gap-3">
        <a href="./" class="text-primary text-base">
            <i class="fa-solid fa-house"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-medium">Shop</p>
    </div>
    <!-- ./breadcrumb -->

    <!-- shop wrapper -->
    <div class="container grid md:grid-cols-4 grid-cols-2 gap-6 pt-4 pb-16 items-start">
        <!-- sidebar -->
        <!-- drawer init and toggle -->
        <div class="text-center md:hidden">
            <button
                class="text-white hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800 block md:hidden"
                type="button" data-drawer-target="drawer-example" data-drawer-show="drawer-example"
                aria-controls="drawer-example">
                <ion-icon name="grid-outline"></ion-icon>
            </button>
        </div>

        <!-- drawer component -->
        <div id="drawer-example" class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-80" tabindex="-1" aria-labelledby="drawer-label">
            <h5 id="drawer-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400"><svg class="w-5 h-5 mr-2" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>Search</h5>
            <button type="button" data-drawer-hide="drawer-example" aria-controls="drawer-example" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
               <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
               <span class="sr-only">Close menu</span>
            </button>
            <div class="divide-y divide-gray-200 space-y-5">
                <form method="GET">
                    <div class="pt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Product Name</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="text" placeholder="Enter Product Name" name="search" id="search" class="block w-full px-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Brands</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <select id="category" name="category" class="block w-full px-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category['category_name']; ?>">
                                            <?php echo $category['category_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Price</h3>
                        <div class="mt-4 flex items-center">
                            <input type="text" name="min" id="min" class="w-full border-b border-gray-300 px-3 py-1 text-gray-600 shadow-sm" placeholder="min">
                            <span class="mx-3 text-gray-500">-</span>
                            <input type="text" name="max" id="max" class="w-full border-b border-gray-300 px-3 py-1 text-gray-600 shadow-sm" placeholder="max">
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="block w-full py-3 px-4 text-center text-white bg-green-900 border border-green-900 rounded-md hover:bg-transparent hover:text-green-900 transition font-medium">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ./sidebar -->
        <div class="col-span-1 bg-white px-4 pb-6 shadow rounded overflow-hidden hidden md:block">
            <div class="divide-y divide-gray-200 space-y-5">
                <form method="GET">
                    <div class="pt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Product Name</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="text" placeholder="Enter Product Name" name="search" id="search" class="block w-full px-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Brands</h3>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <select id="category" name="category" class="block w-full px-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
                                    <?php foreach ($categories as $category) { ?>
                                        <option value="<?php echo $category['category_name']; ?>">
                                            <?php echo $category['category_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Price</h3>
                        <div class="mt-4 flex items-center">
                            <input type="text" name="min" id="min" class="w-full border-gray-300 rounded px-3 py-1 text-gray-600 shadow-sm" placeholder="min">
                            <span class="mx-3 text-gray-500">-</span>
                            <input type="text" name="max" id="max" class="w-full border-gray-300 rounded px-3 py-1 text-gray-600 shadow-sm" placeholder="max">
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="block w-full py-3 px-4 text-center text-white bg-green-900 border border-green-900 rounded-md hover:bg-transparent hover:text-green-900 transition font-medium">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- products -->
        <div class="col-span-3">
            <?php if (!empty($products)) { ?>
                <div class="grid md:grid-cols-3 grid-cols-2 gap-6">
                    <?php foreach ($products as $product) { ?>
                        <!-- Product Card -->
                        <div class="bg-white shadow rounded overflow-hidden group">
                            <!-- Product Image -->
                            <div class="relative">
                                <a href="./detail.php?id=<?php echo $product['product_id']; ?>">
                                    <img src="../<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" class="w-full h-60">
                                </a>
                            </div>
                            <!-- Product Details -->
                            <div class="pt-4 pb-3 px-4">
                                <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-primary transition"><?= $product['product_name']; ?></h4>
                                <div class="items-baseline mb-1">
                                    <p class="text-xl text-primary font-semibold">$<?= $product['product_price'] ?></p>
                                    <p class="text-sm text-gray-400">Stock: <?= $product['product_stock'] ?></p>
                                </div>
                            </div>
                            <!-- Add to Cart Button -->
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $product['product_id']; ?>" />
                                <button type="submit" name="addToCart" class="block w-full py-1 text-center text-white bg-green-800 border border-primary rounded-b hover:bg-green-950 hover:text-primary transition">Add to cart</button>
                            </form>
                        </div>
                        <!-- End of Product Card -->
                    <?php } ?>
                </div>
            <?php } else { ?>
                <!-- No products found -->
                <div class="flex justify-center items-center mt-8">
                    <p class="text-gray-600">No products found.</p>
                    <a href="shop.php" class="ml-4 px-4 py-2 text-sm font-medium text-center text-white bg-green-900 border border-green-900 rounded-md hover:bg-transparent hover:text-green-900 transition font-medium">Back to Shop</a>
                </div>
            <?php } ?>
        </div>
        <!-- ./products -->

    </div>
    <!-- ./shop wrapper -->
</main>
