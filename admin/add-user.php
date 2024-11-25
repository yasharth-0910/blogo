<?php
include "../partials/header.php";
if(!isset($_SESSION['user_is_admin'])){
    header("location: " . ROOT_URL . "logout.php");
    session_destroy();
    exit();
}

$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;

unset($_SESSION['add-user-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - BlogoSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'v0-dark': '#000000',
                        'v0-light': '#ffffff',
                        'v0-accent': '#007bff',
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-v0-dark text-v0-light font-inter">
    <main class="container mx-auto px-4 py-8">
        <section class="max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-center">Add User</h2>
            
            <?php if(isset($_SESSION['add-user-success'])): ?>
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                <p><?=$_SESSION['add-user-success']; unset($_SESSION['add-user-success']); ?></p>
            </div>
            <?php elseif(isset($_SESSION['add-user'])): ?>
            <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                <p><?=$_SESSION['add-user']; unset($_SESSION['add-user']); ?></p>
            </div>
            <?php endif ?>

            <form action="<?=ROOT_URL?>admin/add-user-logic.php" enctype="multipart/form-data" method="POST" class="space-y-4">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="First Name" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-v0-accent">
                <input type="text" name="lastname" value="<?= $lastname ?>" placeholder="Last Name" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-v0-accent">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-v0-accent">
                <input type="email" name="email" value="<?= $email ?>" placeholder="Email" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-v0-accent">
                <input type="password" name="createpassword" value="<?= $createpassword ?>" placeholder="Password" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-v0-accent">
                <input type="password" name="confirmpassword" value="<?= $confirmpassword ?>" placeholder="Confirm Password" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-v0-accent">
                <select name="userrole" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-v0-accent">
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
                </select>
                <div class="space-y-2">
                    <label for="avatar" class="block text-sm font-medium">User Avatar</label>
                    <input type="file" name="avatar" id="avatar" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg focus:outline-none focus:border-v0-accent">
                </div>
                <button type="submit" name="submit" class="w-full px-4 py-2 bg-v0-accent text-white rounded-lg hover:bg-blue-600 transition duration-300">Add User</button>
            </form>
        </section>
    </main>

    <?php include '../partials/footer.php'; ?>
</body>
</html>

