<?php
include "partials/header.php";
if(!isset($_SESSION['user_is_admin'])){
    header("location: " . ROOT_URL . "logout.php");
    //destroy all sessions and redirect user to login page
    session_destroy();
}
//fetch categories from database
$query = "SELECT * FROM categories ORDER BY title";
$categories=mysqli_query($connection,$query)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - BlogoSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'space-black': '#0f0f0f',
                        'space-gray': '#1a1a1a',
                        'space-blue': '#2c3e50',
                        'space-text': '#e0e0e0',
                        'space-success': '#2ecc71',
                        'space-error': '#e74c3c',
                    },
                    fontFamily: {
                        'space': ['Space Grotesk', 'sans-serif'],
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-space-black text-space-text font-space">
    <div class="min-h-screen flex flex-col">
        <section class="dashboard flex-grow">
            <?php
            $alertTypes = [
                'add-category-success' => ['type' => 'success', 'bg' => 'space-success'],
                'add-category' => ['type' => 'error', 'bg' => 'space-error'],
                'edit-category-success' => ['type' => 'success', 'bg' => 'space-success'],
                'edit-category' => ['type' => 'error', 'bg' => 'space-error']
            ];

            foreach ($alertTypes as $key => $alert) {
                if(isset($_SESSION[$key])) {
                    echo "<div class='bg-{$alert['bg']} bg-opacity-10 border border-{$alert['bg']} text-{$alert['bg']} px-4 py-3 rounded relative mb-4' role='alert'>
                            <span class='block sm:inline'>{$_SESSION[$key]}</span>
                          </div>";
                    unset($_SESSION[$key]);
                }
            }
            ?>

            <div class="container mx-auto px-4 py-8">
                <div class="flex flex-col lg:flex-row">
                    <aside class="lg:w-1/4 mb-8 lg:mb-0">
                        <nav class="space-y-2">
                            <a href="<?= ROOT_URL ?>admin/add-post.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-space-gray transition duration-300">
                                <i class="uil uil-pen text-space-blue"></i>
                                <span>Add Post</span>
                            </a>
                            <a href="<?= ROOT_URL ?>admin/index.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-space-gray transition duration-300">
                                <i class="uil uil-postcard text-space-blue"></i>
                                <span>Manage Posts</span>
                            </a>
                            <?php if(isset($_SESSION['user_is_admin'])) : ?>
                            <a href="<?= ROOT_URL ?>admin/add-user.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-space-gray transition duration-300">
                                <i class="uil uil-user-plus text-space-blue"></i>
                                <span>Add User</span>
                            </a>
                            <a href="<?= ROOT_URL ?>admin/manage-users.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-space-gray transition duration-300">
                                <i class="uil uil-users-alt text-space-blue"></i>
                                <span>Manage Users</span>
                            </a>
                            <a href="<?= ROOT_URL ?>admin/add-category.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-space-gray transition duration-300">
                                <i class="uil uil-edit text-space-blue"></i>
                                <span>Add Category</span>
                            </a>
                            <a href="<?= ROOT_URL ?>admin/manage-categories.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-space-gray">
                                <i class="uil uil-list-ul text-space-blue"></i>
                                <span>Manage Categories</span>
                            </a>
                            <?php endif ?>
                        </nav>
                    </aside>
                    <main class="lg:w-3/4 lg:pl-8">
                        <h2 class="text-2xl font-bold mb-6">Manage Categories</h2>
                        <?php if(mysqli_num_rows($categories) > 0) : ?>
                        <div class="overflow-x-auto">
                            <table class="w-full bg-space-gray rounded-lg overflow-hidden">
                                <thead class="bg-space-blue bg-opacity-20">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Edit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-space-blue divide-opacity-20">
                                    <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                                    <tr class="hover:bg-space-blue hover:bg-opacity-10 transition duration-300">
                                        <td class="px-6 py-4 whitespace-nowrap"><?=$category['title']?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?=$category['id']?>" class="text-space-blue hover:underline">Edit</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?=$category['id']?>" class="text-space-error hover:underline">Delete</a>
                                        </td>
                                    </tr>
                                    <?php endwhile ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else : ?>
                        <div class="bg-space-error bg-opacity-10 border border-space-error text-space-error px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">No categories found</span>
                        </div>
                        <?php endif ?>
                    </main>
                </div>
            </div>
        </section>
    </div>

    <?php include "../partials/footer.php"; ?>
</body>
</html>