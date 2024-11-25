<?php
include "partials/header.php";

$current_admin_id = $_SESSION['user-id'];
if(!isset($_SESSION['user_is_admin'])){
    header("location: " . ROOT_URL . "logout.php");
    session_destroy();
}
$query="SELECT id,firstname,lastname,username,is_admin FROM users WHERE NOT id='$current_admin_id'";
$users=mysqli_query($connection,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'neon-blue': '#00f3ff',
                        'deep-space': '#0a0a0a',
                        'star-dust': '#222222',
                    },
                    fontFamily: {
                        'orbitron': ['Orbitron', 'sans-serif'],
                    },
                    boxShadow: {
                        'neon': '0 0 5px theme("colors.neon-blue"), 0 0 20px theme("colors.neon-blue")',
                    }
                },
            },
        }
    </script>
</head>
<body class="bg-deep-space text-white font-orbitron">
    <div class="min-h-screen flex flex-col">
        <section class="dashboard flex-grow">
            <?php
            $alertTypes = [
                'add-user-success' => 'success',
                'edit-user' => 'error',
                'edit-user-success' => 'success',
                'delete-user' => 'error',
                'delete-user-success' => 'success'
            ];

            foreach ($alertTypes as $sessionKey => $alertType):
                if(isset($_SESSION[$sessionKey])):
            ?>
                <div class="alert__message <?= $alertType ?> container mx-auto px-4 py-2 mb-4 <?= $alertType === 'success' ? 'bg-green-500' : 'bg-red-500' ?> bg-opacity-20 border <?= $alertType === 'success' ? 'border-green-500' : 'border-red-500' ?> rounded-lg">
                    <p class="<?= $alertType === 'success' ? 'text-green-300' : 'text-red-300' ?>">
                        <?= $_SESSION[$sessionKey];
                        unset($_SESSION[$sessionKey]);
                        ?>
                    </p>
                </div>
            <?php
                endif;
            endforeach;
            ?>

            <div class="container mx-auto px-4 dashboard__container">
                <div class="flex">
                    <aside class="w-64 pr-4">
                        <nav class="space-y-2">
                            <a href="<?= ROOT_URL ?>admin/add-post.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-star-dust transition duration-300">
                                <i class="uil uil-pen text-neon-blue"></i>
                                <span>Add Post</span>
                            </a>
                            <a href="<?= ROOT_URL ?>admin/index.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-star-dust transition duration-300">
                                <i class="uil uil-postcard text-neon-blue"></i>
                                <span>Manage Posts</span>
                            </a>
                            <?php if(isset($_SESSION['user_is_admin'])) : ?>
                            <a href="<?= ROOT_URL ?>admin/add-user.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-star-dust transition duration-300">
                                <i class="uil uil-user-plus text-neon-blue"></i>
                                <span>Add User</span>
                            </a>
                            <a href="<?= ROOT_URL ?>admin/manage-users.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg bg-star-dust">
                                <i class="uil uil-users-alt text-neon-blue"></i>
                                <span>Manage Users</span>
                            </a>
                            <a href="<?= ROOT_URL ?>admin/add-category.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-star-dust transition duration-300">
                                <i class="uil uil-edit text-neon-blue"></i>
                                <span>Add Category</span>
                            </a>
                            <a href="<?= ROOT_URL ?>admin/manage-categories.php" class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-star-dust transition duration-300">
                                <i class="uil uil-list-ul text-neon-blue"></i>
                                <span>Manage Categories</span>
                            </a>
                            <?php endif ?>
                        </nav>
                    </aside>
                    <main class="flex-grow">
                        <h2 class="text-2xl font-bold mb-6 text-neon-blue">Manage Users</h2>
                        <?php if(mysqli_num_rows($users) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full bg-star-dust rounded-lg overflow-hidden">
                                <thead class="bg-deep-space">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-neon-blue uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-neon-blue uppercase tracking-wider">Username</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-neon-blue uppercase tracking-wider">Edit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-neon-blue uppercase tracking-wider">Delete</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-neon-blue uppercase tracking-wider">Admin</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    <?php while($user = mysqli_fetch_assoc($users)): ?>
                                    <tr class="hover:bg-deep-space transition duration-300">
                                        <td class="px-6 py-4 whitespace-nowrap"><?= $user["firstname"] . " " . $user['lastname'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= $user["username"] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="text-neon-blue hover:underline">Edit</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="<?= ROOT_URL ?>admin/delete-users.php?id=<?= $user['id'] ?>" class="text-red-500 hover:underline">Delete</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= $user["is_admin"] ? 'Yes' : 'No' ?></td>
                                    </tr>
                                    <?php endwhile ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else : ?>
                            <div class="alert__message error bg-red-500 bg-opacity-20 border border-red-500 text-red-300 p-4 rounded-lg">No users found</div>
                        <?php endif ?>
                    </main>
                </div>
            </div>
        </section>
    </div>

    <?php include "../partials/footer.php"; ?>
</body>
</html>