<?php 
include 'partials/header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
    $author_id = $post['author_id'];
    $author_query = "SELECT * FROM users WHERE id=$author_id";
    $author_result = mysqli_query($connection, $author_query);
    $author = mysqli_fetch_assoc($author_result);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $post['title'] ?> - BlogoSphere</title>
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
    <main class="container mx-auto px-4 py-8 max-w-3xl">
        <article class="space-y-8">
            <header class="space-y-4">
                <h1 class="text-4xl font-bold leading-tight">
                    <?= $post['title'] ?>
                </h1>
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full overflow-hidden">
                        <img src="./images/<?= $author['avatar'] ?>" alt="<?= $author['firstname'] ?> <?= $author['lastname'] ?>" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="font-semibold"><?= "{$author['firstname']} {$author['lastname']}" ?></p>
                        <p class="text-sm text-gray-400">
                            <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                        </p>
                    </div>
                </div>
            </header>

            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                <img src="./images/<?= $post['thumbnail'] ?>" alt="<?= $post['title'] ?>" class="w-full h-full object-cover">
            </div>

            <div class="prose prose-invert max-w-none">
                <?= $post['body'] ?>
            </div>
        </article>
    </main>

</body>
</html>

<?php
include './partials/footer.php';
?>

