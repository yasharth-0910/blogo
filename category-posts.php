<?php 
include 'partials/header.php';

//fetch posts if id is set
if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    exit();
}

// Fetch category details
$category_query = "SELECT * FROM categories WHERE id=$id";
$category_result = mysqli_query($connection, $category_query);
$category = mysqli_fetch_assoc($category_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $category['title'] ?> - BlogoSphere</title>
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
        <header class="mb-12">
            <h1 class="text-4xl font-bold text-center"><?= $category['title'] ?></h1>
        </header>

        <?php if (mysqli_num_rows($posts) > 0) : ?>
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                <div class="aspect-w-16 aspect-h-9">
                    <img src="./images/<?= $post['thumbnail'] ?>" alt="<?= $post['title'] ?>" class="object-cover w-full h-full">
                </div>
                <div class="p-6">
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="inline-block px-3 py-1 bg-v0-accent text-v0-light rounded-full text-sm font-semibold mb-2"><?= $category['title'] ?></a>
                    <h2 class="text-xl font-bold mb-2">
                        <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>" class="hover:text-v0-accent transition duration-300"><?= $post['title'] ?></a>
                    </h2>
                    <p class="text-gray-400 mb-4">
                        <?= substr(html_entity_decode($post['body']), 0, 120) ?>...
                    </p>
                    <div class="flex items-center">
                        <?php
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id=$author_id";
                        $author_result = mysqli_query($connection, $author_query);
                        $author = mysqli_fetch_assoc($author_result);
                        ?>
                        <div class="w-10 h-10 rounded-full overflow-hidden mr-4">
                            <img src="./images/<?= $author['avatar'] ?>" alt="<?= $author['firstname'] ?> <?= $author['lastname'] ?>" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h5 class="font-semibold"><?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                            <small class="text-gray-500"><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                        </div>
                    </div>
                </div>
            </article>
            <?php endwhile ?>
        </section>
        <?php else : ?>
        <div class="bg-red-500 text-white p-4 rounded-lg text-center">
            <p>No posts found for this category</p>
        </div>
        <?php endif ?>

        <section class="mt-16">
            <h2 class="text-2xl font-bold mb-6 text-center">Categories</h2>
            <div class="flex flex-wrap justify-center gap-4">
                <?php 
                $all_categories_query = "SELECT * FROM categories";
                $all_categories_result = mysqli_query($connection, $all_categories_query);
                ?>
                <?php while ($category = mysqli_fetch_assoc($all_categories_result)) : ?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="px-4 py-2 bg-gray-800 text-v0-light rounded-full hover:bg-v0-accent transition duration-300">
                    <?= $category['title'] ?>
                </a>
                <?php endwhile ?>
            </div>
        </section>
    </main>

    <?php include './partials/footer.php'; ?>
</body>
</html>

