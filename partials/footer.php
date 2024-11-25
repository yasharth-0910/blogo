<footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="container mx-auto px-4">
        <p class="text-center">&copy; <?= date('Y') ?> BlogoSphere. All rights reserved.</p>
    </div>
</footer>

<script>
    // Mobile menu toggle
    const openNavBtn = document.querySelector('#open__nav-btn');
    const closeNavBtn = document.querySelector('#close__nav-btn');
    const navItems = document.querySelector('.nav__items');

    openNavBtn.addEventListener('click', () => {
        navItems.style.display = 'flex';
        openNavBtn.style.display = 'none';
        closeNavBtn.style.display = 'inline-block';
    });

    closeNavBtn.addEventListener('click', () => {
        navItems.style.display = 'none';
        openNavBtn.style.display = 'inline-block';
        closeNavBtn.style.display = 'none';
    });
</script>

</body>
</html>

