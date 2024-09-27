<?php
session_start();
include_once 'include/head.php';
include_once 'db/connection.php';

// Function to get subcategories
function getSubcategories($parent_id, $conn) {
    $subcategories_query = "SELECT name FROM categories WHERE parent_id = $parent_id LIMIT 3";
    $sub_result = mysqli_query($conn, $subcategories_query);
    $subcategories = [];
    while ($sub_row = mysqli_fetch_assoc($sub_result)) {
        $subcategories[] = $sub_row['name'];
    }
    return $subcategories;
}

// Fetch the initial 3
$query = "SELECT * FROM categories WHERE parent_id IS NULL LIMIT 3";
$result = mysqli_query($conn, $query);
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

// Fetch all categories (excluding those with parent_id)
$query_all = "SELECT * FROM categories WHERE parent_id IS NULL";
$result_all = mysqli_query($conn, $query_all);
$all_categories = [];
while ($row = mysqli_fetch_assoc($result_all)) {
    $row['subcategories'] = getSubcategories($row['id'], $conn); // Fetch subcategories
    $all_categories[] = $row;
}
?>

<!-- Header -->
<header>
    <h1>Dverggas</h1>
    <div>
        <i class="fa-solid fa-user" style="font-size: 24px; cursor: pointer;" onclick="toggleUserMenu()"></i>
        <div id="user-menu" style="display: none;">
            <?php if (isset($_SESSION['username'])): ?>
                <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?></p>
                <a href="auth/logout.php">Logout</a>
            <?php else: ?>
                <p>Welcome, Guest</p>
                <a href="auth/login.php">Login</a> 
                <a href="auth/register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Search Bar -->
<div class="searchbar">
    <input type="text" placeholder="Search categories">
    <button>
        <i class="fa-solid fa-magnifying-glass"></i> Search
    </button>
</div>

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
            const additionalCategories = Array.from(categoryList.children).slice(3);
            additionalCategories.forEach(category => category.remove());
            moreIcon.className = "fa-solid fa-arrow-right";
        }

        expanded = !expanded;
    }

    // From ChatGPT
    function randomColor() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
    }
</script>

<?php include_once 'include/footer.php'; ?>
