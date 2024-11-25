<?php
require 'partials/header.php';

// if input is there
if ((isset($_GET['search'])) && isset($_GET['submit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY date_time DESC";
    $posts = mysqli_query($connection, $query);
} else {
    header("location: " . ROOT_URL . 'blog.php');
    exit();
}
?>

<main class="bg-gray-900 text-gray-100 min-h-screen py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold mb-8 text-center">Search Results for "<?= htmlspecialchars($search) ?>"</h1>

        <?php if (mysqli_num_rows($posts) > 0) : ?>
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                    <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="relative pb-2/3">
                            <img src="./images/<?= $post['thumbnail'] ?>" alt="Post thumbnail" class="absolute h-full w-full object-cover">
                        </div>
                        <div class="p-6">
                            <?php
                            // fetch category
                            $category_id = $post['category_id'];
                            $category_query = "SELECT * FROM categories WHERE id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);

                            $author_id = $post['author_id'];
                            $author_query = "SELECT * FROM users WHERE id=$author_id";
                            $author_result = mysqli_query($connection, $author_query);
                            $author = mysqli_fetch_assoc($author_result);
                            ?>
                            <a href="category-posts.php?id=<?= $post['category_id'] ?>" class="inline-block px-3 py-1 bg-blue-600 text-white rounded-full text-xs font-semibold mb-2 hover:bg-blue-700 transition duration-300"><?= $category['title'] ?></a>
                            <h3 class="text-xl font-bold mb-2 hover:text-blue-400 transition duration-300">
                                <a href="post.php?id=<?= $post["id"] ?>"><?= $post['title'] ?></a>
                            </h3>
                            <p class="text-gray-400 mb-4">
                                <?= substr($post['body'], 0, 150) ?>...
                            </p>
                            <div class="flex items-center mt-4">
                                <div class="w-10 h-10 rounded-full overflow-hidden mr-4">
                                    <img src="./images/<?= $author['avatar'] ?>" alt="Author avatar" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h5 class="font-semibold"><?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                                    <small class="text-gray-500">
                                        <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endwhile ?>
            </section>
        <?php else : ?>
            <div class="bg-red-900 text-white p-4 rounded-lg text-center mb-8">
                <p class="text-lg">No posts found for this search</p>
            </div>
        <?php endif ?>

        <section class="mt-16">
            <h2 class="text-3xl font-bold mb-8 text-center">Explore Categories</h2>
            <div class="flex flex-wrap justify-center gap-4">
                <?php
                $all_categories_query = "SELECT * FROM categories";
                $all_categories_result = mysqli_query($connection, $all_categories_query);
                ?>
                <?php while ($category = mysqli_fetch_assoc($all_categories_result)) : ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="px-6 py-3 bg-gray-800 text-white rounded-full hover:bg-blue-600 transition duration-300 transform hover:scale-110">
                        <?= $category['title'] ?>
                    </a>
                <?php endwhile ?>
            </div>
        </section>
    </div>
</main>

<?php
include './partials/footer.php';
?>

