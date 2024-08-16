<?php 
	require_once "../assets/includes/navagationside.php";
	require_once "../assets/Database/Connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	try {
			$name = $_POST['c_name'];
			
			$insert_sql = "INSERT INTO category (category_name) VALUES (:name);";

			$stmt = $pdo->prepare($insert_sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);

			$stmt->execute();

			header("Location: categoryView.php?create=ok");
			exit();
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}
?>
	
		<!---Add Product-->
		<form action="" method="post" enctype="multipart/form-data">
		<div class="form">
			<h1 class="admin_title">Add Category</h1>
			<div class="relative w-full">
				<label for="p_name" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Category Name</label>
				<input type="text" placeholder="Enter Category Name" name="c_name" id="c_name" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="btncontainer">
				<button type="submit" class="save">Save</button>
			</div>
		</div>
		</form>
	

 	</div>	
</div>
