<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dverggas - Your Digital Marketplace</title>
    <script src="https://kit.fontawesome.com/4c39a50c7e.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    <?php
    $base_path = (basename(dirname($_SERVER['SCRIPT_NAME'])) == 'auth') ? '../' : '';
    ?>
    <link rel="stylesheet" type="text/css" href="<?= $base_path; ?>styles/styles.css">

    <script src="<?= $base_path; ?>scripts/modeswitch.js"></script>
    <script src="<?= $base_path; ?>scripts/shoppingcart.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
