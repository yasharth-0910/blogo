<?php 
include 'partials/header.php';

//featured
$featured_query="SELECT * FROM posts WHERE is_featured=1";
$featured_result=mysqli_query($connection,$featured_query);
$featured=mysqli_fetch_assoc($featured_result);

//fetch 9post
$query="SELECT * FROM posts ORDER BY date_time DESC";
$posts=mysqli_query($connection,$query);
?>

<main class="container mx-auto px-4 py-8">
    <section class="mb-8">
        <form class="flex items-center" action="<?=ROOT_URL?>search.php" method="GET">
            <div class="relative w-full">
                <input type="search" name="search" placeholder="Search" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-full focus:outline-none focus:ring-2 focus:ring-primary">
                <button type="submit" name="submit" class="absolute right-0 top-0 mt-2 mr-4 text-gray-400">
                    <i class="uil uil-search"></i>
                </button>
            </div>
        </form>
    </section>
    
    <!-- ===================END OF SEARCH================-->

    <section class="posts <?= $featured ? '' : 'mt-12' ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                <article class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                    <div class="h-48 overflow-hidden">
                        <img src="./images/<?= $post['thumbnail'] ?>" alt="<?= $post['title'] ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <?php
                        $category_id = $post['category_id'];
                        $category_query = "SELECT * FROM categories WHERE id=$category_id";
                        $category_result = mysqli_query($connection, $category_query);
                        $category = mysqli_fetch_assoc($category_result);
                        ?>
                        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="inline-block px-3 py-1 bg-primary text-white text-sm font-semibold rounded-full mb-2"><?= $category['title'] ?></a>
                        <h2 class="text-xl font-bold mb-2">
                            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>" class="hover:text-primary transition duration-300"><?= $post['title'] ?></a>
                        </h2>
                        <p class="text-gray-400 mb-4 h-20 overflow-hidden">
                            <?= substr(html_entity_decode($post['body']), 0, 120) ?>...
                        </p>
                        <div class="flex items-center mt-4">
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
            <?php endwhile; ?>
        </div>
    </section>

    <!--=====================================================================
    ==========================END OF THE POSTS===============================
    =================================================================== -->
    <section class="mt-12">
        <h2 class="text-2xl font-bold mb-4">Categories</h2>
        <div class="flex flex-wrap gap-4">
            <?php 
            $all_categories_query="SELECT * FROM categories ";
            $all_categories_result=mysqli_query($connection,$all_categories_query);
            ?>
            <?php while ( $category=mysqli_fetch_assoc($all_categories_result) ) : ?>
            <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['id']?>" class="px-4 py-2 bg-gray-800 text-white rounded-full hover:bg-primary transition duration-300"><?=$category['title']?></a>
            <?php endwhile?>
        </div>
    </section>
    <!--=======================END OF CATEGORY ===================================-->
</main>

<?php
include './partials/footer.php';
?>

