<?php 
	require_once "../assets/includes/navagationside.php";
	require_once "../assets/Database/Connection.php";

	$stmt = $pdo->query("SELECT * FROM category");
	$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"] == "POST") {
	try {
		if(isset($_FILES['pImg'])) {
			$productImage = '';

            $uploadDir = '../assets/img/'; 
            $uploadFile = $uploadDir . basename($_FILES['pImg']['name']);

            if (move_uploaded_file($_FILES['pImg']['tmp_name'], $uploadFile)) {
                $productImage = 'assets/img/' . basename($_FILES['pImg']['name']);
            } else {
                echo 'Error uploading file.';
            }

			$name = $_POST['p_name'];
			$brand = $_POST['p_brand'];
			$description = $_POST['p_description'];
			$price = $_POST['p_price'];
			$category = $_POST['p_category'];
			$stock = $_POST['p_stock'];
			
			$insert_sql = "INSERT INTO products (product_name,product_brand,product_description,product_price,category_id ,product_stock,product_image)
			VALUES (:name,:brand,:description,:price,:category,:stock,:imgBox)";

			$stmt = $pdo->prepare($insert_sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
			$stmt->bindParam(':description', $description, PDO::PARAM_STR);
			$stmt->bindParam(':price', $price, PDO::PARAM_INT);
			$stmt->bindParam(':category', $category, PDO::PARAM_STR);
			$stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
			$stmt->bindParam(':imgBox', $productImage, PDO::PARAM_STR);

			$stmt->execute();

			header("Location:productView.php?create=ok");
			exit();
		} else {
			echo "File is not uploaded";
		}
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}
?>
	
		<!---Add Product-->
		<form action="" method="post" enctype="multipart/form-data">
		<div class="form">
			<h1 class="admin_title">Add Product</h1>
			<div class="relative w-full">
				<label for="p_name" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Product Name</label>
				<input type="text" placeholder="Enter Product Name" name="p_name" id="p_name" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="product">
				<label for="p_brand" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Product Brand</label>
				<input type="text" placeholder="Enter Product Brand" name="p_brand" id="p_brand" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="product">
				<label for="p_description"  class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Description</label>
				<textarea placeholder="Enter Prodcut Description" name="p_description" id="p_description" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer"></textarea>
			</div>
			<div class="product">
				<label for="p_price"   class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Price</label>
				<input type="number" min="10" value="10" placeholder="Enter Product Price" name="p_price" id="p_price" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
			</div>
			<div class="product">
				<label for="p_category"  class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Category</label>
				<select id="p_category" name="p_category" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
					<?php foreach ($categories as $category) { ?>
						<option value="<?php echo $category['category_id']; ?>">
							<?php echo $category['category_name']; ?>
						</option>
					<?php } ?>
				</select>
			</div>
			<div class="product">
				<label for="p_stock"  class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Stock</label>
				<input type="number"  min="1" value="1" name="p_stock" id="p_stock" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
			</div>
			<div class="product">
				<label for="pImg"  class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Image</label>
				<img src="" alt="" name="imgBox" width="150px" height="150px" style="border: 1px solid;" id="previewImg">
				<input type="file" id="pImg" name="pImg" accept="image/*" required onchange="previewFile()" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
			</div>
			<div class="btncontainer">
				<button type="submit" class="save">Save</button>
			</div>
		</div>
		</form>
	

 	</div>	
</div>
<script>
       function previewFile() {
			var preview = document.getElementById('previewImg');
			var fileInput = document.getElementById('pImg');
			var file = fileInput.files[0];
			var reader = new FileReader();

			reader.onloadend = function () {
				preview.src = reader.result;
				preview.style.display = file ? 'block' : 'none'; // Toggle image display
			};

			if (file) {
				reader.readAsDataURL(file);
			} else {
				preview.src = '';
				preview.style.display = 'none'; // Hide image when no file selected
			}
		}
		previewFile();
    </script>
