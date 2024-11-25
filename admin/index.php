<?php
include "../partials/header.php";

// fetch current user-id from session
$current_user_id = $_SESSION['user-id'];
$query = "SELECT id, title, category_id FROM posts WHERE author_id=$current_user_id ORDER BY id DESC";
$posts = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BlogoSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
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
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 p-4">
            <nav>
                <ul class="space-y-2">
                    <li>
                        <a href="<?= ROOT_URL ?>admin/add-post.php" class="flex items-center space-x-2 p-2 rounded hover:bg-gray-800 transition duration-200">
                            <i class="uil uil-pen"></i>
                            <span>Add Post</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= ROOT_URL ?>admin/index.php" class="flex items-center space-x-2 p-2 rounded bg-v0-accent text-white">
                            <i class="uil uil-postcard"></i>
                            <span>Manage Posts</span>
                        </a>
                    </li>
                    <?php if(isset($_SESSION['user_is_admin'])) : ?>
                    <li>
                        <a href="<?= ROOT_URL ?>admin/add-user.php" class="flex items-center space-x-2 p-2 rounded hover:bg-gray-800 transition duration-200">
                            <i class="uil uil-user-plus"></i>
                            <span>Add User</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= ROOT_URL ?>admin/manage-users.php" class="flex items-center space-x-2 p-2 rounded hover:bg-gray-800 transition duration-200">
                            <i class="uil uil-users-alt"></i>
                            <span>Manage Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= ROOT_URL ?>admin/add-category.php" class="flex items-center space-x-2 p-2 rounded hover:bg-gray-800 transition duration-200">
                            <i class="uil uil-edit"></i>
                            <span>Add Category</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= ROOT_URL ?>admin/manage-categories.php" class="flex items-center space-x-2 p-2 rounded hover:bg-gray-800 transition duration-200">
                            <i class="uil uil-list-ul"></i>
                            <span>Manage Categories</span>
                        </a>
                    </li>
                    <?php endif ?>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h2 class="text-3xl font-bold mb-6">Manage Posts</h2>

            <?php
            $messages = [
                'signin-success' => ['type' => 'success', 'unset' => true],
                'add-post' => ['type' => 'error', 'unset' => true],
                'add-post-success' => ['type' => 'success', 'unset' => true],
                'edit-post' => ['type' => 'error', 'unset' => true],
                'edit-post-success' => ['type' => 'success', 'unset' => true]
            ];

            foreach ($messages as $key => $info) {
                if (isset($_SESSION[$key])) {
                    $type = $info['type'];
                    $bgColor = $type === 'success' ? 'bg-green-500' : 'bg-red-500';
                    echo "<div class='mb-4 p-4 rounded $bgColor'>";
                    echo "<p>{$_SESSION[$key]}</p>";
                    echo "</div>";
                    if ($info['unset']) {
                        unset($_SESSION[$key]);
                    }
                }
            }
            ?>

            <?php if (mysqli_num_rows($posts) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full bg-gray-800 rounded-lg overflow-hidden">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Category</th>
                                <th class="px-4 py-2 text-left">Edit</th>
                                <th class="px-4 py-2 text-left">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($post = mysqli_fetch_assoc($posts)): ?>
                                <?php
                                $category_id = $post['category_id'];
                                $category_query = "SELECT title FROM categories WHERE id=$category_id";
                                $category_result = mysqli_query($connection, $category_query);
                                $category = mysqli_fetch_assoc($category_result);
                                ?>
                                <tr class="border-b border-gray-700">
                                    <td class="px-4 py-2"><?= $post['title'] ?></td>
                                    <td class="px-4 py-2"><?= $category['title'] ?></td>
                                    <td class="px-4 py-2">
                                        <a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="bg-v0-accent text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200">Edit</a>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id'] ?>" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-200">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="bg-red-500 text-white p-4 rounded">No posts found</div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        // You can add any necessary JavaScript here
    </script>
</body>
</html>

<?php
include "../partials/footer.php";
?>

