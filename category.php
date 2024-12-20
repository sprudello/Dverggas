<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once 'include/head.php';
include_once 'include/header.php';
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
$query_subcategories = "SELECT id, name FROM categories WHERE parent_id = $category_id";
$result_subcategories = mysqli_query($conn, $query_subcategories);
$subcategories = [];
while ($row = mysqli_fetch_assoc($result_subcategories)) {
    $subcategories[] = $row;
}

$subcategory_ids = array_merge([$category_id], array_column($subcategories, 'id'));

// Filter logic
$filter_used = false;
$products = [];
$price_min = isset($_GET['price_min']) ? (float)$_GET['price_min'] : null;
$price_max = isset($_GET['price_max']) ? (float)$_GET['price_max'] : null;
$brand = isset($_GET['brand']) ? $_GET['brand'] : null;

// Dynamische Query für Filter
$query_products = "SELECT * FROM products WHERE category_id IN (" . implode(',', $subcategory_ids) . ")";

if ($price_min !== null) {
    $query_products .= " AND price >= $price_min";
    $filter_used = true;
}
if ($price_max !== null) {
    $query_products .= " AND price <= $price_max";
    $filter_used = true;
}
if ($brand) {
    $query_products .= " AND brand = '" . $conn->real_escape_string($brand) . "'";
    $filter_used = true;
}

$result_products = $conn->query($query_products);
while ($row = $result_products->fetch_assoc()) {
    $products[] = $row;
}

// Alle Marken für den Filter
$brands_query = "SELECT DISTINCT brand FROM products WHERE category_id IN (" . implode(',', $subcategory_ids) . ")";
$result_brands = $conn->query($brands_query);
$brands = [];
while ($row = $result_brands->fetch_assoc()) {
    $brands[] = $row['brand'];
}
?>

<!-- Main Content Area -->
<div class="main-content" style="display: flex;">
    <!-- Left Menu -->
    <aside class="category-menu" style="width: 20%; padding: 20px;">
        <h3>Subcategories</h3>
        <ul>
            <?php foreach ($subcategories as $subcategory): ?>
                <li>
                    <a href="category.php?id=<?= $subcategory['id']; ?>">
                        <?= htmlspecialchars($subcategory['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Product Listing -->
    <section class="products" style="width: 80%; padding: 20px;">
        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" action="">
                <input type="hidden" name="id" value="<?= $category_id; ?>">
                <label for="price_min">Preis von:</label>
                <input type="number" name="price_min" id="price_min" step="0.01" min="0" placeholder="Min. Preis" value="<?= htmlspecialchars($price_min ?? '') ?>">

                <label for="price_max">bis:</label>
                <input type="number" name="price_max" id="price_max" step="0.01" min="0" placeholder="Max. Preis" value="<?= htmlspecialchars($price_max ?? '') ?>">

                <label for="brand">Marke:</label>
                <select name="brand" id="brand">
                    <option value="">Alle Marken</option>
                    <?php foreach ($brands as $brand_option): ?>
                        <option value="<?= htmlspecialchars($brand_option) ?>" <?= ($brand === $brand_option) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($brand_option) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Filtern</button>
            </form>
        </div>

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
<style>
    
    div.filter-section form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    div.filter-section form label {
        font-weight: bold;
        margin-right: 5px;
    }

    div.filter-section form input[type="number"],
    div.filter-section form select {
        width: auto;  
        padding: 5px 8px; 
        background-color: #444;
        color: white;
        border: 1px solid #444;
        border-radius: 5px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    div.filter-section form select:focus,
    div.filter-section form input[type="number"]:focus {
        border-color: #6600cc;
        outline: none;
        box-shadow: 0 0 5px rgba(102, 0, 204, 0.5);
    }

    div.filter-section form button {
        padding: 5px 15px; 
        background-color: #6600cc;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 8px rgba(102, 0, 204, 0.5);
    }

    div.filter-section form button:hover {
        background-color: #5800af;
        box-shadow: 0 8px 16px rgba(88, 0, 175, 0.5);
    }
</style>

<?php include_once 'include/footer.php'; ?>
