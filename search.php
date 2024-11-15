<?php
session_start();
include_once 'include/head.php';
include_once 'include/header.php';
include_once 'db/connection.php';

// Define search function
function searchProducts($conn, $searchTerm) {
    $sql = "
    SELECT 
        products.id, 
        products.title, 
        products.prod_desc, 
        products.price, 
        products.brand, 
        categories.name AS category_name
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
    WHERE 
        products.title LIKE ? OR 
        products.prod_desc LIKE ? OR 
        categories.name LIKE ?
    ";

    $stmt = $conn->prepare($sql);
    $searchTermWildcard = '%' . $searchTerm . '%';
    $stmt->bind_param("sss", $searchTermWildcard, $searchTermWildcard, $searchTermWildcard);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();
    return $products;
}

// Retrieve search term
$searchTerm = '';
$products = [];

if (isset($_GET['search_term'])) {
    $searchTerm = $_GET['search_term'];
    $products = searchProducts($conn, $searchTerm);
}

$conn->close();
?>

<!-- Display search results -->
<div class="search-results">
    <h2>Search results for "<?php echo htmlspecialchars($searchTerm); ?>"</h2>
    <?php if (!empty($products)): ?>
        <div class="product-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card" onmouseover="startHoverTimer(this)" onmouseout="clearHoverTimer(this)">
                    <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                    <p>Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
                    <p>Description: <?php echo htmlspecialchars($product['prod_desc']); ?></p>
                    <p>Price: <?php echo htmlspecialchars($product['price']); ?>€</p>
                    <p>Brand: <?php echo htmlspecialchars($product['brand']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>

<script>
let hoverTimer;

function startHoverTimer(element) {
    hoverTimer = setTimeout(() => {
        element.style.transform = 'scale(1.5)';
        element.style.zIndex = '1000';
        element.style.position = 'relative';
        element.style.transition = 'all 0.3s ease';
        element.style.backgroundColor = 'var(--card-bg-color)';
        element.style.boxShadow = '0 4px 8px var(--shadow-color)';
    }, 3000);
}

function clearHoverTimer(element) {
    clearTimeout(hoverTimer);
    element.style.transform = 'scale(1)';
    element.style.zIndex = '1';
}
</script>

<?php include_once 'include/footer.php'; ?>
