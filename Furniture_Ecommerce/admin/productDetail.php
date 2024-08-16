<?php 
    require_once "../assets/includes/navagationside.php";
    require_once "../assets/Database/Connection.php";

    if(isset($_GET['id'])) {
        $productId = $_GET['id'];

        $stmt = $pdo->prepare("SELECT * FROM products JOIN category ON products.category_id = category.category_id WHERE product_id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$product) {
            echo "Product not found.";
            exit;
        }

        if(isset($_POST['delete'])) {
            $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = ?");
            $stmt->execute([$productId]);
            header("Location: productView.php?delete=ok");
            exit;
        }

        if(isset($_POST['update'])) {
            header("Location: productUpdate.php?id=$productId");
            exit;
        }

    } else {
        echo "Product ID not provided.";
        exit;
    }
?>


<div class=" p-5 mt-2">
    <a class="text-decoration-none btn btn-outline-primary  " href="productView.php"><<< Back</a>
    <h1 class="admin_title">Product Details</h1>
    <div class="mt-5 flex gap-x-10">
        <div class="flex flex-col">
            <img src="../<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>" class="img-fluid w-[500px] ">
            <form method="POST" class="d-flex mt-2 justify-content-between">
                <button class="btn btn-outline-danger" name="delete">Delete</button>
                <button class="btn btn-outline-info" name="update">Update</button>
            </form>
        </div>
        <div class="col-md-6">
            <h1 class="font-bold ">Product Name: <?php echo $product['product_name']; ?></h1>
            <p class="text-light"><span>Brand:</span> <?= $product['product_brand']; ?></p>
            <p class="text-light"><span>Price:</span> <?= $product['product_price']; ?></p>
            <h2>Description</h2>
            <p><?php echo $product['product_description']; ?></p>
            <!-- Additional fields -->
            <p><span>In Stock:</span> <?= $product['product_stock']; ?></p>
            <p><span>Category Name:</span> <?= $product['category_name']; ?></p>
        </div>
    </div>
</div>