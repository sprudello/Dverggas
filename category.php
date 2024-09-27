<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once 'include/head.php';
include_once 'db/connection.php';

// Get category ID from the URL
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch category details
$query_category = "SELECT * FROM categories WHERE id = $category_id LIMIT 1";
$result_category = mysqli_query($conn, $query_category);
$category = mysqli_fetch_assoc($result_category);

if (!$category) {
    echo "Category not found!";
    exit;
}

// Fetch subcategories of current category
$query_subcategories = "SELECT * FROM categories WHERE parent_id = $category_id";
$result_subcategories = mysqli_query($conn, $query_subcategories);
$subcategories = [];
while ($row = mysqli_fetch_assoc($result_subcategories)) {
    $subcategories[] = $row;
}

// Fetch products of current category
$query_products = "SELECT * FROM products WHERE category_id = $category_id";
$result_products = mysqli_query($conn, $query_products);
$products = [];
while ($row = mysqli_fetch_assoc($result_products)) {
    $products[] = $row;
}
?>

<!-- Header -->
<header>
    <h1>Dverggas</h1>
    <!-- Search bar in the header -->
    <div class="searchbar">
        <input type="text" placeholder="Search">
        <button>
            <i class="fa-solid fa-magnifying-glass"></i> Search
        </button>
    </div>

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

<!-- Main Content Area -->
<div class="main-content" style="display: flex;">
    <!-- Left Menu -->
    <aside class="category-menu" style="width: 20%; padding: 20px;">
        <h3>Subcategories</h3>
        <ul>
            <?php foreach ($subcategories as $subcategory): ?>
                <li><a href="category.php?id=<?= $subcategory['id']; ?>"><?= htmlspecialchars($subcategory['name']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Product Listing -->
    <section class="products" style="width: 80%; padding: 20px;">
        <h2>Products in <?= htmlspecialchars($category['name']); ?></h2>
        <?php if (count($products) > 0): ?>
            <div class="product-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <?php foreach ($products as $product): ?>
                    <div class="product-card" style="border: 1px solid #ccc; padding: 20px; border-radius: 10px;">
                        <h3><?= htmlspecialchars($product['title']); ?></h3>
                        <p><?= htmlspecialchars($product['prod_desc']); ?></p>
                        <p><strong>Brand:</strong> <?= htmlspecialchars($product['brand']); ?></p>
                        <p><strong>Price:</strong> $<?= number_format($product['price'], 2); ?></p>
                        <p><strong>Release Date:</strong> <?= date("F j, Y", strtotime($product['release_date'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No products found in this category.</p>
        <?php endif; ?>
    </section>
</div>

<script>
    function toggleUserMenu() {
        var userMenu = document.getElementById('user-menu');
        userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
    }
</script>

<?php include_once 'include/footer.php'; ?>