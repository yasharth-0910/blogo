<?php
require 'config/database.php';
if(isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id='$id'";
    $result = mysqli_query($connection, $query);
    $avatar =  mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="max-age=3600">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogoSphere</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- GOOGLE FONT(MONTSERATE) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,800;1,700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'primary': '#007bff',
                        'secondary': '#6c757d',
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head> 
<body class="bg-gray-900 text-white font-montserrat">

    <nav class="bg-gray-800 shadow-lg">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <a href="<?= ROOT_URL ?>index.php" class="text-2xl font-bold text-primary">BlogoSphere</a>
            <ul class="hidden md:flex items-center space-x-6">
                <li><a href="<?= ROOT_URL ?>blog.php" class="hover:text-primary transition duration-300">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php" class="hover:text-primary transition duration-300">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php" class="hover:text-primary transition duration-300">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php" class="hover:text-primary transition duration-300">Contact</a></li>
                <?php if(isset($_SESSION['user-id'])) : ?>
                <li class="relative group">
                    <div class="w-10 h-10 rounded-full overflow-hidden cursor-pointer">
                        <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>" alt="User Avatar" class="w-full h-full object-cover">
                    </div>
                    <ul class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg hidden group-hover:block">
                        <li><a href="<?= ROOT_URL ?>/admin/index.php" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a></li>
                        <li><a href="<?= ROOT_URL ?>logout.php" class="block px-4 py-2 hover:bg-gray-700">Logout</a></li>
                    </ul>
                </li>
                <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>signin.php" class="hover:text-primary transition duration-300">SignIn</a></li>
                <?php endif ?>
            </ul>
            
            <button id="open__nav-btn" class="md:hidden text-2xl"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn" class="hidden md:hidden text-2xl"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!-- ======================== END OF NAV ======================== -->

