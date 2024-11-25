<?php
include "../partials/header.php";

// fetch categories from database
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

// get back form data if form was invalid
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;
unset($_SESSION['add-post-data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post - BlogoSphere</title>
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
        <!-- Sidebar (you can include your sidebar here) -->

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h2 class="text-3xl font-bold mb-6">Add Post</h2>

            <?php if(isset($_SESSION['add-post'])) : ?>
            <div class="bg-red-500 text-white p-4 rounded mb-6">
                <p>
                    <?= $_SESSION['add-post'];
                    unset($_SESSION['add-post']);
                    ?>
                </p>
            </div>
            <?php endif ?>

            <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST" class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium mb-2">Title</label>
                    <input type="text" name="title" id="title" value="<?= $title ?>" placeholder="Enter post title" class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-v0-accent">
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium mb-2">Category</label>
                    <select name="category_id" id="category_id" class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-v0-accent">
                        <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                        <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                        <?php endwhile ?>
                    </select>
                </div>

                <?php if(isset($_SESSION["user_is_admin"])) : ?>
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" value='1' id="is_featured" checked class="mr-2">
                    <label for="is_featured" class="text-sm font-medium">Featured</label>
                </div>
                <?php endif ?>

                <div>
                    <label for="body" class="block text-sm font-medium mb-2">Body</label>
                    <textarea rows="8" name="body" id="body" placeholder="Write your post content here" class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-v0-accent"><?= $body ?></textarea>
                </div>

                <div>
                    <label for="thumbnail" class="block text-sm font-medium mb-2">Add Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail" class="w-full px-3 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-v0-accent">
                </div>

                <button type="submit" name="submit" class="px-4 py-2 bg-v0-accent text-white rounded-md hover:bg-blue-600 transition duration-300">Add Post</button>
            </form>
        </main>
    </div>

    <script>
        // You can add any necessary JavaScript here
    </script>
</body>
</html>

<?php
include '../partials/footer.php';
?>

