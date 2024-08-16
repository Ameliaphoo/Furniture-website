<?php 
require_once "../assets/includes/usernavbar.php";
require_once "../assets/Database/Connection.php";

if (isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	try {
			$email = $_POST['u_email'];
            $password = $_POST['u_pass'];

            $stmt = $pdo->prepare("SELECT * FROM users WHERE uemail = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password,$user['upass'])) {
                $_SESSION['user'] = $user;
                if($user['utype'] === "Admin"){
                    header("Location: ../admin/home.php?success=ok");
                }else{
                    header("Location: index.php?success=ok");
                }
            }else{
                header("Location: login.php?error=login");
                exit();
            }

			exit();
	} catch(Exception $e) {
		echo $e->getMessage();
	}
}
?>
  <div class="contain py-16">
        <div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
            <h2 class="text-2xl uppercase font-medium mb-1">Login</h2>
            <p class="text-gray-600 mb-6 text-sm">
                welcome back customer
            </p>
            <form action="#" method="post" autocomplete="off">
                <div class="space-y-2">
                    <div>
                        <label for="u_email" class="text-gray-600 mb-2 block">Email address</label>
                        <input type="email" name="u_email" id="u_email"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="youremail.@domain.com" required>
                    </div>
                    <div>
                        <label for="u_pass" class="text-gray-600 mb-2 block">Password</label>
                        <input type="password" name="u_pass" id="u_pass"
                            class="block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400"
                            placeholder="*******" required> 
                    </div>
                </div>
              
                <div class="mt-4">
                    <button type="submit"
                        class="block w-full py-2 text-center text-white bg-green-900 border border-primary rounded hover:bg-transparent hover:text-green-900 transition uppercase font-roboto font-medium">Login</button>
                </div>
            </form>


            <p class="mt-4 text-center text-gray-600">Don't have account? <a href="./register.php"
                    class="text-green-900">Register
                    now</a></p>
        </div>
    </div>

<?php require_once "../assets/includes/footer.php"; ?>
<script>
    <?php
        if (isset($_GET['error'])) {
            ?>
                toastr.error('Invalid username or password', 'Login Error', {
                    closeButton: true,
                    
                });
            <?php
        }
        if (isset($_GET['success'])) {
            ?>
                toastr.success('Registration Successfull', 'Success', {
                    closeButton: true,
                    progressBar: true
                });
            <?php
        }
    ?>
</script>