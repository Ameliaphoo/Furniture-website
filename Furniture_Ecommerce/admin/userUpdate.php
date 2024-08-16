<?php 
	require_once "../assets/includes/navagationside.php";
	require_once "../assets/Database/Connection.php";

	if(isset($_GET['id'])) {

        $userId = $_GET['id'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE uid = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user) {
            echo "User not found.";
            exit;
        }
	}else {
        echo "User ID not provided.";
        exit;
    }


if($_SERVER["REQUEST_METHOD"] == "POST") {
	try {
			$name = $_POST['u_name'];
			$email = $_POST['u_email'];
            $password = $_POST['u_pass'];
			$ph = $_POST['u_ph'];
			$address = $_POST['u_address'];
			$type = $_POST['u_type'];

			if($password !== $user['upass']){
				$password = password_hash($password, PASSWORD_DEFAULT);
			}
			
			$update_sql = "UPDATE users 
               SET uname = :name, 
                   upass = :pass, 
                   uemail = :uemail, 
                   uph = :uph, 
                   uaddress = :uaddress, 
                   utype = :utype 
               WHERE uid = :user_id";
			$stmt = $pdo->prepare($update_sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':pass', $password, PDO::PARAM_STR);
			$stmt->bindParam(':uemail', $email, PDO::PARAM_STR);
			$stmt->bindParam(':uph', $ph, PDO::PARAM_STR);
			$stmt->bindParam(':uaddress', $address, PDO::PARAM_STR);
			$stmt->bindParam(':utype', $type, PDO::PARAM_STR);
			$stmt->bindParam(':user_id', $userId, PDO::PARAM_STR);

			$stmt->execute();

			header("Location: userView.php?update=ok");
			exit();
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}
?>
	
		<!---Add Product-->
		<form action="" method="post" enctype="multipart/form-data">
		<div class="form">
			<h1 class="admin_title">User Update</h1>
			<div class="relative w-full">
				<label for="u_name" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Username</label>
				<input value="<?= $user['uname'] ?>" type="text"  placeholder="Enter Username" name="u_name" id="u_name" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_email" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Email</label>
				<input value="<?= $user['uemail'] ?>" type="email" placeholder="Enter Email" name="u_email" id="u_email" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_pass" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Password</label>
				<input value="<?= $user['upass'] ?>" type="password" placeholder="Enter Password" name="u_pass" id="u_pass" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_ph" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Phone Number</label>
				<input value="<?= $user['uph'] ?>" type="text"  placeholder="Enter Phone Number" name="u_ph" id="u_ph" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_address" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Address</label>
				<input value="<?= $user['uaddress'] ?>" type="text" placeholder="Enter Adress" name="u_address" id="u_address" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer" required>
			</div>
			<div class="relative w-full">
				<label for="u_type" class="absolute text-md text-zinc-800 duration-150 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3">Type</label>
				<select value="<?= $user['utype'] ?>" id="u_type" name="u_type" class=" block w-full px-6 pt-6 pb-1 text-gray-800 appearance-none text-md bg-transparent border-b-2 border-gray-800 focus:outline-none focus:ring-0 peer">
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
