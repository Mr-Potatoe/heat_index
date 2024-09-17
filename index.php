<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'heat_indices');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, role FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $role);
        $stmt->fetch();

        $_SESSION['user_id'] = $id;
        $_SESSION['role'] = $role;

        if ($role == 'admin') {
            header('Location: php/admin_dashboard.php');
        } else {
            header('Location: php/user_dashboard.php');
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en" class="system">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heat Index Map - Login</title>
    <link rel="stylesheet" href="dist/css/stylesx.css">
    <link rel="icon" href="public/assets/school-logo.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.1/tailwind.min.css" integrity="sha512-biy/TXdue7ElI4oop0vK1o0JVMwDtG2AeA1VEqJU3Z6LqZMMi6KTbc2ND1MC557MijurEJSPDVHV3WgwBgF1Pw==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-8 h-8 mr-2" src="public/assets/school-logo.png" alt="logo">
            Heat Index Map   
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Admin Login
                </h1>
                <?php if (!empty($error)): ?>
                    <div class="text-red-500 text-center text-sm mb-4"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="index.php" method="POST" class="space-y-4 md:space-y-6">
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <input type="text" name="username" id="username" class="pl-10 pr-4 py-2 block w-full dark:text-white bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring focus:border-blue-500" placeholder="Enter username" required>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" name="password" id="password" class="pl-10 pr-4 py-2 block w-full dark:text-white bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring focus:border-blue-500" placeholder="Enter password" required>
                            <!-- Password visibility toggle icon -->
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" id="password-toggle">
                                <i class="fas fa-eye text-gray-400" id="password-toggle-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Log in</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Font Awesome icons -->
<script>
const passwordInput = document.getElementById('password');
const passwordToggle = document.getElementById('password-toggle');
const passwordToggleIcon = document.getElementById('password-toggle-icon');

passwordToggle.addEventListener('click', function() {
    // Toggle password input type between "password" and "text"
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Toggle the icon between "eye" and "eye-slash"
    if (type === 'password') {
        passwordToggleIcon.classList.remove('fa-eye-slash');
        passwordToggleIcon.classList.add('fa-eye');
    } else {
        passwordToggleIcon.classList.remove('fa-eye');
        passwordToggleIcon.classList.add('fa-eye-slash');
    }
});

</script>

</body>


</html>
