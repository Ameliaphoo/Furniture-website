<?php 
require_once "../assets/includes/usernavbar.php";
require_once "../assets/Database/Connection.php";

if (isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	try {
			$name = $_POST['u_name'];
			$email = $_POST['u_email'];
            $password = $_POST['u_pass'];
            $confirm_password = $_POST['u_confirmpass']; 
			$ph = $_POST['u_ph'];
			$address = $_POST['u_address'];
            

            if ($password !== $confirm_password) {
                header("Location: register.php?error=password_mismatch");
                exit();
            }

            $check_sql = "SELECT COUNT(*) FROM users WHERE uemail = :uemail";
            $check_stmt = $pdo->prepare($check_sql);
            $check_stmt->bindParam(':uemail', $email, PDO::PARAM_STR);
            $check_stmt->execute();
            $user_count = $check_stmt->fetchColumn();

            if ($user_count > 0) {
                    header("Location: register.php?error=email_exists");
                    exit();
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			
			$insert_sql = "INSERT INTO users (uname, upass, uemail, uph, uaddress, utype) VALUES (:name, :pass, :uemail, :uph, :uaddress, 'User');";
			$stmt = $pdo->prepare($insert_sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':pass', $hashedPassword, PDO::PARAM_STR);
			$stmt->bindParam(':uemail', $email, PDO::PARAM_STR);
			$stmt->bindParam(':uph', $ph, PDO::PARAM_STR);
			$stmt->bindParam(':uaddress', $address, PDO::PARAM_STR);
			$stmt->execute();

			header("Location: login.php?success=ok");
			exit();
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}
?>
   <!-- register  -->
   <div class="contain py-16">
        <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
            <h2 class="text-2xl uppercase font-medium mb-1">Create an account</h2>
            <p class="text-gray-600 mb-6 text-sm">
                Register for new cosutumer
            </p>
            <form action="#" method="post" autocomplete="off">
                <div class="space-y-2">
                    <div>
                        <label for="u_name" class="text-gray-600 mb-2 block">User Name</label>
                        <input type="text" name="u_name" id=u_"name"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="fulan fulana">
                    </div>
                    <div>
                        <label for="u_email" class="text-gray-600 mb-2 block">Email address</label>
                        <input type="email" name="u_email" id="u_email"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="youremail.@domain.com">
                    </div>
                    <div>
                        <label for="password" class="text-gray-600 mb-2 block">Password</label>
                        <input type="password" name="u_pass" id="u_pass"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="*******">
                    </div>
                    <div>
                        <label for="confirm" class="text-gray-600 mb-2 block">Confirm password</label>
                        <input type="password" name="u_confirmpass" id="u_confirmpass"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="*******">
                    </div>
                    <div>
                        <label for="u_ph" class="text-gray-600 mb-2 block">Phone Number</label>
                        <input type="text" name="u_ph" id="u_ph"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="09xxxxxxxxx">
                    </div>
                    <div>
                        <label for="u_address" class="text-gray-600 mb-2 block">Address</label>
                        <input type="text" name="u_address" id="u_address"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="Yangon">
                    </div>

        
        
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="block w-full py-2 text-center text-white bg-green-900 border border-primary rounded hover:bg-transparent hover:text-green-900 transition uppercase font-roboto font-medium">create
                        account</button>
                </div>
            </form>
  

            <p class="mt-4 text-center text-gray-600">Already have account? <a href="./login.php"
                    class="text-green-900">Login now</a></p>
        </div>
    </div>

   <!-- register  -->
  
  
    <?php require_once "../assets/includes/footer.php"; ?>

    <script>
   <?php
    if (isset($_GET['error'])) {
        $error_type = $_GET['error'];
        if ($error_type === 'email_exists') {
    ?>
        toastr.error('Email already exists', 'Error', {
            closeButton: true,
            progressBar: true
        });
    <?php
        } elseif ($error_type === 'password_mismatch') {
    ?>
        toastr.error('Passwords do not match', 'Error', {
            closeButton: true,
            progressBar: true
        });
    <?php
        } 
    }
    ?>
    </script>