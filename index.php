<?php
session_start();
include_once "include/head.php";
include_once "include/header.php";

?>

<!DOCTYPE html>

<<<<<<< Updated upstream
<body>
    <p>This is a Text</p>
</body>
</html>
<?php 
include_once "include/footer.php";
?>
=======



<!-- Categories Section -->
<div class="categories">
    <h2>Categories</h2>
    <div id="category-list" class="category-grid">
        <?php foreach ($categories as $category): 
            $randomColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        ?>
            <a href="category.php?id=<?= $category['id']; ?>" style="text-decoration: none; color: inherit;">
                <div class="category-card" style="background-color: <?= $randomColor; ?>;">
                    <div class="category-name">
                        <?= htmlspecialchars($category['name']); ?>
                    </div>
                    <div class="subcategory-list">
                        <?php 
                        $subcategories = getSubcategories($category['id'], $conn);
                        foreach ($subcategories as $subcategory): ?>
                            <span class="subcategory"><?= htmlspecialchars($subcategory); ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="more-link">
        <a href="javascript:void(0);" id="more-link" onclick="toggleCategories()">
            <i id="more-icon" class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- About Section -->
<div class="about">
    <p>Dverggas is your go-to online store for a variety of products, ranging from electronics to household items. Explore our diverse categories and find exactly what you need at the best prices.</p>
</div>

<script>
    let allCategories = <?= json_encode($all_categories); ?>;
    let expanded = false;

    function toggleUserMenu() {
        var userMenu = document.getElementById('user-menu');
        userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
    }

    function toggleCategories() {
        const categoryList = document.getElementById('category-list');
        const moreIcon = document.getElementById('more-icon');

        if (!expanded) {
            allCategories.slice(3).forEach(category => {
                const categoryDiv = document.createElement('a');
                categoryDiv.href = `category.php?id=${category.id}`;
                categoryDiv.style.textDecoration = 'none';
                categoryDiv.style.color = 'inherit';

                categoryDiv.innerHTML = `
                    <div class="category-card" style="background-color: ${randomColor()}">
                        <div class="category-name">${category.name}</div>
                        <div class="subcategory-list"></div>
                    </div>`;
                categoryList.appendChild(categoryDiv);
            });
            moreIcon.className = "fa-solid fa-arrow-left";
        } else {
            const additionalCategories = categoryList.querySelectorAll('.category-card:nth-child(n+4)');
            additionalCategories.forEach(category => category.remove());
            moreIcon.className = "fa-solid fa-arrow-right";
        }

        expanded = !expanded;
    }

    function randomColor() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
    }
</script>

<?php include_once 'include/footer.php'; ?>
>>>>>>> Stashed changes
