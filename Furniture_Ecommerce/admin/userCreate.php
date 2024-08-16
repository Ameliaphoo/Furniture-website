<?php 
	require_once "../assets/includes/navagationside.php";
	require_once "../assets/Database/Connection.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	try {
			$name = $_POST['u_name'];
			$email = $_POST['u_email'];
            $password = $_POST['u_pass'];
			$ph = $_POST['u_ph'];
			$address = $_POST['u_address'];
			$type = $_POST['u_type'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			
			$insert_sql = "INSERT INTO users (uname, upass, uemail, uph, uaddress, utype) VALUES (:name, :pass, :uemail, :uph, :uaddress, :utype);";
			$stmt = $pdo->prepare($insert_sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':pass', $hashedPassword, PDO::PARAM_STR);
			$stmt->bindParam(':uemail', $email, PDO::PARAM_STR);
			$stmt->bindParam(':uph', $ph, PDO::PARAM_STR);
			$stmt->bindParam(':uaddress', $address, PDO::PARAM_STR);
			$stmt->bindParam(':utype', $type, PDO::PARAM_STR);

			$stmt->execute();

			header("Location: userView.php?create=ok");
			exit();
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}
?>
	
		<!---Add Product-->
		<form action="" method="post" enctype="multipart/form-data">
		<div class="form">
			<h1 class="admin_title">Add User</h1>
			<div class="relative w-full">
				<label for="u_name" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Username</label>
				<input type="text" placeholder="Enter Username" name="u_name" id="u_name" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_email" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Email</label>
				<input type="email" placeholder="Enter Email" name="u_email" id="u_email" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_pass" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Password</label>
				<input type="password" placeholder="Enter Password" name="u_pass" id="u_pass" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_ph" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Phone Number</label>
				<input type="text"  placeholder="Enter Phone Number" name="u_ph" id="u_ph" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_address" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Address</label>
				<input type="text" placeholder="Enter Adress" name="u_address" id="u_address" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_type" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Type</label>
				<select id="u_type" name="u_type" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
					<option value="Admin">Admin</option>
					<option value="User">User</option>
				</select>
			</div>
			<div class="btncontainer">
				<button type="submit" class="save">Save</button>
			</div>
		</div>
		</form>
	

 	</div>	
</div>
