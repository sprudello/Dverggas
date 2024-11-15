<?php
session_start();

include_once 'include/head.php';
include_once 'include/header.php';
include_once 'db/connection.php';


// Function to get subcategories
function getSubcategories($parent_id, $conn)
{
    $subcategories_query = "SELECT name FROM categories WHERE parent_id = $parent_id LIMIT 3";
    $sub_result = mysqli_query($conn, $subcategories_query);
    $subcategories = [];
    while ($sub_row = mysqli_fetch_assoc($sub_result)) {
        $subcategories[] = $sub_row['name'];
    }
    return $subcategories;
}

// Fetch the initial 3 categories (parent categories only)
$query = "SELECT * FROM categories WHERE parent_id IS NULL LIMIT 3";
$result = mysqli_query($conn, $query);
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['subcategories'] = getSubcategories($row['id'], $conn);
    $categories[] = $row;
}

// Fetch all categories (including subcategories)
$query_all = "SELECT * FROM categories WHERE parent_id IS NULL";
$result_all = mysqli_query($conn, $query_all);
$all_categories = [];
while ($row = mysqli_fetch_assoc($result_all)) {
    $row['subcategories'] = getSubcategories($row['id'], $conn);
    $all_categories[] = $row;
}
?>

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
                        <?php if (!empty($category['subcategories'])): ?>
                            <?php foreach ($category['subcategories'] as $subcategory): ?>
                                <span class="subcategory"><?= htmlspecialchars($subcategory); ?></span>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <span class="subcategory">No Subcategories</span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
    <div class="more-link">
        <a href="javascript:void(0);" id="more-link" onclick="toggleCategories()">
            <i id="more-icon" class="fa-solid fa-arrow-down"></i>
        </a>
    </div>
</div>

<!-- About Section -->
<div class="about">
    <p>Dverggas is your go-to online store for a variety of products, ranging from electronics to household items.
        Explore our diverse categories and find exactly what you need at the best prices.</p>
</div>

<script>
    let allCategories = <?= json_encode($all_categories); ?>;
    let expanded = false;


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
                <div class="category-card">
                    <div class="category-name">${category.name}</div>
                    <div class="subcategory-list">
                        ${category.subcategories.map(subcategory => `
                            <span class="subcategory">${subcategory}</span>
                        `).join('')}
                    </div>
                </div>`;
            categoryList.appendChild(categoryDiv);

            applyRandomBackgroundColor(categoryDiv.querySelector('.category-card'));
        });
        moreIcon.className = "fa-solid fa-arrow-up";
    } else {
        const additionalCategories = Array.from(categoryList.children).slice(3);
        additionalCategories.forEach(category => category.remove());
        moreIcon.className = "fa-solid fa-arrow-down";
    }

    expanded = !expanded;
}


    // ChatGPT
    function randomColor() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
    }

    function getTextColorBasedOnBg(bgColor) {
        let r = parseInt(bgColor.substring(1, 3), 16);
        let g = parseInt(bgColor.substring(3, 5), 16);
        let b = parseInt(bgColor.substring(5, 7), 16);

        let brightness = (r * 299 + g * 587 + b * 114) / 1000;

        return brightness > 150 ? 'black' : 'white';
    }

    function applyRandomBackgroundColor(element) {
        let bgColor = randomColor();
        let textColor = getTextColorBasedOnBg(bgColor);

        element.style.backgroundColor = bgColor;

        element.querySelector('.category-name').style.color = textColor;

        element.querySelectorAll('.subcategory').forEach(subcategory => {
            subcategory.style.color = textColor;
        });
    }


    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.category-card').forEach(card => {
            applyRandomBackgroundColor(card);
        });
    });
</script>


<?php include_once 'include/footer.php'; ?>
