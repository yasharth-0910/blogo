<?php
include "partials/header.php";
if(!isset($_SESSION['user_is_admin'])){
    header("location: " . ROOT_URL . "logout.php");
    session_destroy();
}
if(isset($_GET['id'])){
    $id=filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

    // fetch category from database
    $query="SELECT * FROM categories WHERE id=$id";
    $result=mysqli_query($connection,$query);
    if(mysqli_num_rows($result)==1){
        $category = mysqli_fetch_assoc($result);
    }
} else {
    header("location: " . ROOT_URL . "admin/manage-categories.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category - BlogoSphere</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'space-black': '#0f0f0f',
                        'space-gray': '#1a1a1a',
                        'space-blue': '#2c3e50',
                        'space-text': '#e0e0e0',
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
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold">Edit Category</h2>
            </div>
            <form class="mt-8 space-y-6" action="<?= ROOT_URL ?>admin/edit-category-logic.php" method="POST">
                <input type="hidden" name="id" value="<?=$category['id']?>">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="title" class="sr-only">Title</label>
                        <input id="title" name="title" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-space-gray placeholder-gray-500 text-space-text rounded-t-md focus:outline-none focus:ring-space-blue focus:border-space-blue focus:z-10 sm:text-sm bg-space-gray" placeholder="Title" value="<?=$category['title']?>">
                    </div>
                    <div>
                        <label for="description" class="sr-only">Description</label>
                        <textarea id="description" name="description" rows="4" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-space-gray placeholder-gray-500 text-space-text rounded-b-md focus:outline-none focus:ring-space-blue focus:border-space-blue focus:z-10 sm:text-sm bg-space-gray" placeholder="Description"><?=$category['description']?></textarea>
                    </div>
                </div>

                <div>
                    <button type="submit" name="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-space-blue hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-space-blue transition duration-150 ease-in-out">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include "../partials/footer.php"; ?>
</body>
</html>