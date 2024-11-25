<?php 
include 'partials/header.php';

// featured
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($connection, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

// fetch 9 posts
$query = "SELECT * FROM posts WHERE is_featured=0 ORDER BY date_time DESC LIMIT 9";
$posts = mysqli_query($connection, $query);
?>

<main class="bg-gray-900 text-gray-100 min-h-screen">
    <?php if (mysqli_num_rows($featured_result) == 1) : ?>
    <section class="relative py-20 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="./images/<?= $featured['thumbnail'] ?>" alt="Featured post background" class="w-full h-full object-cover filter blur-sm">
            <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <?php
                $category_id = $featured['category_id'];
                $category_query = "SELECT * FROM categories WHERE id=$category_id";
                $category_result = mysqli_query($connection, $category_query);
                $category = mysqli_fetch_assoc($category_result); 

                $author_id = $featured['author_id'];
                $author_query = "SELECT * FROM users WHERE id=$author_id";
                $author_result = mysqli_query($connection, $author_query);
                $author = mysqli_fetch_assoc($author_result);
                ?>
                <a href="category-posts.php?id=<?= $category_id ?>" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-full text-sm font-semibold mb-4 hover:bg-blue-600 transition duration-300"><?= $category['title'] ?></a>
                <h2 class="text-4xl md:text-5xl font-bold mb-4 hover:text-blue-400 transition duration-300">
                    <a href="post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a>
                </h2>
                <p class="text-xl mb-8">
                    <?= substr(html_entity_decode($featured['body']), 0, 300) ?>...
                </p>
                <div class="flex items-center justify-center">
                    <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                        <img src="./images/<?= $author['avatar'] ?>" alt="Author avatar" class="w-full h-full object-cover">
                    </div>
                    <div class="text-left">
                        <h5 class="font-semibold"><?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                        <small class="text-gray-400">
                            <?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif ?> 

    <section class="py-16 bg-gray-800">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Latest Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                <article class="bg-gray-700 rounded-lg overflow-hidden shadow-lg transform hover:scale-105 transition duration-300">
                    <div class="relative pb-2/3">
                        <img src="./images/<?= $post['thumbnail'] ?>" alt="Post thumbnail" class="absolute h-full w-full object-cover">
                    </div>
                    <div class="p-6">
                        <?php
                        $category_id = $post['category_id'];
                        $category_query = "SELECT * FROM categories WHERE id=$category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="inline-block px-3 py-1 bg-blue-500 text-white rounded-full text-xs font-semibold mb-2 hover:bg-blue-600 transition duration-300"><?= $category['title'] ?></a>
                        <h3 class="text-xl font-bold mb-2 hover:text-blue-400 transition duration-300">
                            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        </h3>
                        <p class="text-gray-400 mb-4 h-20 overflow-hidden">
                            <?= substr($post['body'], 0, 150) ?>...
                        </p>
                        <div class="flex items-center mt-4">
                            <?php
                            $author_id = $post['author_id'];
                            $author_query = "SELECT * FROM users WHERE id=$author_id";
                            $author_result = mysqli_query($connection, $author_query);
                            $author = mysqli_fetch_assoc($author_result);
                            ?>
                            <div class="w-10 h-10 rounded-full overflow-hidden mr-4">
                                <img src="./images/<?= $author['avatar'] ?>" alt="Author avatar" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h5 class="font-semibold"><?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                                <small class="text-gray-500"><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Explore Categories</h2>
            <div class="flex flex-wrap justify-center gap-4">
                <?php 
                $all_categories_query = "SELECT * FROM categories";
                $all_categories_result = mysqli_query($connection, $all_categories_query);
                ?>
                <?php while ($category = mysqli_fetch_assoc($all_categories_result)) : ?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="px-6 py-3 bg-gray-800 text-white rounded-full hover:bg-blue-500 transition duration-300 transform hover:scale-110">
                    <?= $category['title'] ?>
                </a>
                <?php endwhile ?>
            </div>
        </div>
    </section>
</main>

<?php
include './partials/footer.php';
?>
