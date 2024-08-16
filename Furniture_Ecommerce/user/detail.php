<?php 
require_once "../assets/includes/usernavbar.php";

if(isset($_GET['id'])) {
    $productId = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM products JOIN category ON products.category_id = category.category_id WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt= $pdo-> query("SELECT * FROM products JOIN category ON products.category_id = category.category_id ORDER BY RAND() DESC  LIMIT 4;");
	$randoms= $stmt->fetchAll(PDO::FETCH_ASSOC);


    if(!$product) {
        echo "Product not found.";
        exit;
    }

    if(isset($_POST['submit'])){

        if (!isset($_SESSION['cart']['product_id'])) {
            $_SESSION['cart'][$product['product_id']] = $product;
            $_SESSION['cart'][$product['product_id']]["qty"] = $_POST['quantity'];
        } else {
            $_SESSION['cart'][$product['product_id']]["qty"] += $_POST['quantity'];
        }
        header("cart.php");
    }

} else {
    echo "Product ID not provided.";
    exit;
}
?>

<main class="mx-5">
        <!-- breadcrumb -->
        <div class="container py-4 flex items-center gap-3">
        <a href="./" class="text-green-950 text-base">
            <i class="fa-solid fa-house"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-medium">Detail</p>
    </div>
    <!-- ./breadcrumb -->

    <!-- product-detail -->
    <div class="container grid grid-cols-2 gap-6">
        <div>
            <img  src="../<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" class="w-full h-[500px]">
        </div>

        <div>
            <h2 class="text-3xl font-medium uppercase mb-2"><?php echo $product['product_name']; ?></h2>
            <div class="space-y-2">
                <p class="text-gray-800 font-semibold space-x-2">
                    <span>Availability: </span>
                    <span class="text-green-600">In Stock</span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">Brand: </span>
                    <span class="text-gray-600"><?php echo $product['product_brand']; ?></span>
                </p>
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">Category: </span>
                    <span class="text-gray-600"><?php echo $product['category_name']; ?></span>
                </p>
            </div>
            <div class="flex items-baseline mb-1 space-x-2 font-roboto mt-4">
                <p class="text-xl text-green-950 font-semibold">$<?php echo $product['product_price']; ?></p>
            </div>

            <p class="mt-4 text-gray-600"><?php echo $product['product_description']; ?></p>

            <div class="pt-4">
                <h3 class="text-sm text-gray-800 uppercase mb-1">Size</h3>
                <div class="flex items-center gap-2">
                    <div class="size-selector">
                        <input type="radio" name="size" id="size-xs" class="hidden">
                        <label for="size-xs"
                            class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">XS</label>
                    </div>
                    <div class="size-selector">
                        <input type="radio" name="size" id="size-sm" class="hidden">
                        <label for="size-sm"
                            class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">S</label>
                    </div>
                    <div class="size-selector">
                        <input type="radio" name="size" id="size-m" class="hidden">
                        <label for="size-m"
                            class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">M</label>
                    </div>
                    <div class="size-selector">
                        <input type="radio" name="size" id="size-l" class="hidden">
                        <label for="size-l"
                            class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">L</label>
                    </div>
                    <div class="size-selector">
                        <input type="radio" name="size" id="size-xl" class="hidden">
                        <label for="size-xl"
                            class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">XL</label>
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Color</h3>
                <div class="flex items-center gap-2">
                    <div class="color-selector">
                        <input type="radio" name="color" id="red" class="hidden">
                        <label for="red"
                            class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                            style="background-color: #fc3d57;"></label>
                    </div>
                    <div class="color-selector">
                        <input type="radio" name="color" id="black" class="hidden">
                        <label for="black"
                            class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                            style="background-color: #000;"></label>
                    </div>
                    <div class="color-selector">
                        <input type="radio" name="color" id="white" class="hidden">
                        <label for="white"
                            class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                            style="background-color: #fff;"></label>
                    </div>

                </div>
            </div>

            <!-- Quantity Input -->
            <div class="flex justify-between my-4">
            <div class="flex items-center justify-center clip-pentagonlanbg md:h-[62px] h-[40px]">
                <div class="ml-2 text-base font-bold leading-loose text-green-800 font-space">
                    Quantity : <span id="quantity"><?= $product['product_stock'] ?></span>
                </div>
            </div>
            <div class="w-32 h-10 custom-number-input">
                <div class="relative flex flex-row w-full h-10 mt-1 bg-transparent rounded-lg">
                        <button data-action="decrement" class="w-20 h-full text-gray-300 bg-green-900 rounded-l outline-none cursor-pointer hover:text-gray-700 hover:bg-green-950">
                            <span class="m-auto text-2xl font-thin">−</span>
                        </button>
                        <input type="number" min="0" id="custom-input-number" class="flex items-center w-full font-semibold text-center text-gray-300 bg-green-900 outline-none cursor-default focus:outline-none text-md hover:text-black focus:text-black md:text-base" value="1"></input>
                        <button data-action="increment" class="w-20 h-full text-gray-300 bg-green-900 rounded-r cursor-pointer hover:text-gray-700 hover:bg-green-950">
                            <span class="m-auto text-2xl font-thin">+</span>
                        </button>
                    </div>
                </div>
                </div>
                <form   method="POST">
                    <!-- Checkout Button -->
                    <input type="number" min="0" id="hiiden-number" hidden name="quantity" value="1"></input>
                    <button name="submit" class="w-[70%] md:h-[62px] h-[40px] rounded-xl flex items-center justify-center text-base leading-none text-white bg-green-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 hover:bg-green-950">
                        <i class="mr-3 fa-solid fa-cart-shopping"></i>
                        Add to cart
                    </button>
                </form>
            </div>x
    </div>

    <!-- related product -->
    <div class="container pb-16">
        <h2 class="text-2xl font-medium text-gray-800 uppercase mb-6">Related products</h2>
        <div class="grid grid-cols-4 gap-6">
            <?php foreach($randoms as $product){?>
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
    <!-- ./related product -->
</main>
<script>
        let elements = document.querySelectorAll("[data-menu]");
        for (let i = 0; i < elements.length; i++) {
            let main = elements[i];
            main.addEventListener("click", function () {
                let element = main.parentElement.parentElement;
                let andicators = main.querySelectorAll("img");
                let child = main.querySelector("#sect");
                child.classList.toggle("hidden");
                andicators[0].classList.toggle("rotate-180");
            });
        }

    var quantityElement = document.getElementById('quantity');
    var inputElement = document.getElementById('custom-input-number');
    var forminputElement = document.getElementById('hiiden-number');
    var quantity = parseInt(quantityElement.innerText);

    var incrementButton = document.querySelector('[data-action="increment"]');
    var decrementButton = document.querySelector('[data-action="decrement"]');
    
    incrementButton.addEventListener('click', function () {
        var currentQuantity = parseInt(inputElement.value);
        var newQuantity = Math.min(currentQuantity + 1, quantity);
        inputElement.value = newQuantity;
        forminputElement.value =newQuantity
        quantityElement.innerText = quantity - newQuantity;
    });

    decrementButton.addEventListener('click', function () {
        var currentQuantity = parseInt(inputElement.value);
        var newQuantity = Math.max(1, currentQuantity - 1); 
        inputElement.value = newQuantity;
        forminputElement.value =newQuantity
        quantityElement.innerText = quantity - newQuantity;
    });
    
    </script>