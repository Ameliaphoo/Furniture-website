<?php 
    require_once "../assets/includes/navagationside.php";
    require_once "../assets/Database/Connection.php";

    if(isset($_GET['id'])) {
        $stmt = $pdo->query("SELECT * FROM category");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categoryId = $_GET['id'];

        $stmt = $pdo->prepare("SELECT * FROM category WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$category) {
            echo "Category not found.";
            exit;
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['c_name'];

            // Update product details in the database
            $update_sql = "UPDATE category SET category_name = :name  WHERE category_id = :id";

            $stmt = $pdo->prepare($update_sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $categoryId, PDO::PARAM_STR);

            $stmt->execute();

            // Redirect after updating product
            header("Location: categoryView.php?update=ok");
            exit();
        }
    } else {
        echo "Category ID not provided.";
        exit;
    }
?>
		<!---Add Product-->
		<form action="" method="post" enctype="multipart/form-data">
		<div class="form">
			<h1 class="admin_title">Category Update</h1>
			<div class="relative w-full">
				<label for="p_name" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Category Name</label>
				<input value="<?= $category['category_name'] ?>" type="text" placeholder="Enter Category Name" name="c_name" id="c_name" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
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
				preview.style.display = file ? 'block' : 'none'; 
			};

			if (file) {
				reader.readAsDataURL(file);
			} else {
				preview.src = '';
			}
		}
    </script>