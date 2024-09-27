<?php
session_start();
include_once 'include/head.php';
include_once 'include/header.php';
include_once 'db/connection.php';

// Suchfunktion definieren
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

// Suchbegriff abrufen
$searchTerm = '';
$products = [];

if (isset($_GET['search_term'])) {
    $searchTerm = $_GET['search_term'];
    $products = searchProducts($conn, $searchTerm);
}

$conn->close();
?>

<!-- Suchergebnisse anzeigen -->
<div class="search-results">
    <h2>Suchergebnisse für "<?php echo htmlspecialchars($searchTerm); ?>"</h2>
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                <p>Kategorie: <?php echo htmlspecialchars($product['category_name']); ?></p>
                <p>Beschreibung: <?php echo htmlspecialchars($product['prod_desc']); ?></p>
                <p>Preis: <?php echo htmlspecialchars($product['price']); ?>€</p>
                <p>Marke: <?php echo htmlspecialchars($product['brand']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Keine Produkte gefunden.</p>
    <?php endif; ?>
</div>

<?php include_once 'include/footer.php'; ?>
