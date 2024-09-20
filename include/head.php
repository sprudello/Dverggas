<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dverggas</title>
    <script src="https://kit.fontawesome.com/4c39a50c7e.js" crossorigin="anonymous"></script>

    <?php
    $base_path = (basename(dirname($_SERVER['SCRIPT_NAME'])) == 'auth') ? '../' : '';
    ?>
    <link rel="stylesheet" type="text/css" href="<?= $base_path; ?>styles/styles.css">

    <script src="<?= $base_path; ?>scripts/script.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
