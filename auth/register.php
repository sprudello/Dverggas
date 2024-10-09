<?php
session_start();
include '../db/connection.php';

$errors = [];

$username = $firstname = $lastname = $display_name = $email = $phone_number = $phone_code = '';
$street = $street2 = $house_number = $plz = $city = $country = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form data
    $username = trim($_POST['username'] ?? '');
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $display_name = trim($_POST['display_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone_number = trim($_POST['phone_number'] ?? '');
    $phone_code = trim($_POST['phone_code'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $street2 = trim($_POST['street2'] ?? '');
    $house_number = trim($_POST['house_number'] ?? '');
    $plz = trim($_POST['plz'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Retrieve checkbox values
    $accept_tos = isset($_POST['accept_tos']);
    $accept_privacy = isset($_POST['accept_privacy']);

    // Combine phone code and phone number
    $full_phone_number = $phone_code . $phone_number;

    // Validate required fields
    if (empty($username) || empty($firstname) || empty($lastname) || empty($email) || empty($street) || empty($house_number) || empty($plz) || empty($city) || empty($country) || empty($password)) {
        $errors[] = "Please fill all required fields!";
    }

    // Validate email with regex
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format!";
    }

    // Check if username is available
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "Username already taken!";
        }
        $stmt->close();
    } else {
        $errors[] = "Database error: Unable to prepare statement.";
    }

    // Validate password match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match!";
    }

    // Validate checkbox agreements
    if (!$accept_tos) {
        $errors[] = "You must accept the General Terms and Conditions!";
    }

    if (!$accept_privacy) {
        $errors[] = "You must accept the Privacy Policy!";
    }

    // Optional: Additional validations (e.g., password strength) can be added here

    if (empty($errors)) {
        // Hash the password securely
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the INSERT statement
        $stmt = $conn->prepare("INSERT INTO users (username, firstname, lastname, display_name, email, phone_number, street, street2, house_number, plz, city, country, password_hash) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param(
                'sssssssssssss',
                $username,
                $firstname,
                $lastname,
                $display_name,
                $email,
                $full_phone_number,
                $street,
                $street2,
                $house_number,
                $plz,
                $city,
                $country,
                $password_hash
            );

            if ($stmt->execute()) {
                // Registration successful
                // Optionally, redirect the user or log them in
                echo "<div class='success-message'>Registration successful! You can now <a href='login.php'>login</a>.</div>";
            } else {
                // Handle execution errors
                $errors[] = "Error: " . htmlspecialchars($stmt->error);
            }

            $stmt->close();
        } else {
            $errors[] = "Database error: Unable to prepare statement.";
        }
    }
}
?>

<?php include_once '../include/head.php'; ?>

<!-- Registration form -->
<div class="login-box">
    <h2 class="login-title">Register</h2>
    <form method="POST" action="register.php">
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <?php foreach ($errors as $error): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="two-columns">
            <div class="input-group">
                <label for="firstname">Firstname <span class="required">*</span></label>
                <input type="text" name="firstname" id="firstname" placeholder="Firstname" value="<?= htmlspecialchars($firstname ?? '') ?>" required>
            </div>
            <div class="input-group">
                <label for="lastname">Lastname <span class="required">*</span></label>
                <input type="text" name="lastname" id="lastname" placeholder="Lastname" value="<?= htmlspecialchars($lastname ?? '') ?>" required>
            </div>
        </div>

        <div class="two-columns">
            <div class="input-group">
                <label for="display_name">Displayname</label>
                <input type="text" name="display_name" id="display_name" placeholder="Displayname (optional)" value="<?= htmlspecialchars($display_name ?? '') ?>">
            </div>
            <div class="input-group">
                <label for="username">Username <span class="required">*</span></label>
                <input type="text" name="username" id="username" placeholder="Username" value="<?= htmlspecialchars($username ?? '') ?>" required>
            </div>
        </div>

        <div class="two-columns">
            <div class="input-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" name="email" id="email" placeholder="Email" value="<?= htmlspecialchars($email ?? '') ?>" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
            </div>
            <div class="input-group">
                <label for="phone_number">Phone number</label>
                <input type="tel" id="phone" name="phone_number" placeholder="Phone Number" value="<?= htmlspecialchars($phone_number ?? '') ?>">
                <input type="hidden" name="phone_code" id="phone_code">
            </div>
        </div>

        <div class="two-columns">
            <div class="input-group">
                <label for="street">Address <span class="required">*</span></label>
                <input type="text" name="street" id="street" placeholder="Street" value="<?= htmlspecialchars($street ?? '') ?>" required>
            </div>
            <div class="input-group">
                <label for="house_number">House number <span class="required">*</span></label>
                <input type="text" name="house_number" id="house_number" placeholder="House Number" value="<?= htmlspecialchars($house_number ?? '') ?>" required>
            </div>
        </div>

        <div class="input-group">
            <label for="street2">Additional Address</label>
            <input type="text" name="street2" id="street2" placeholder="Street 2 (optional)" value="<?= htmlspecialchars($street2 ?? '') ?>">
        </div>

        <div class="two-columns">
            <div class="input-group">
                <label for="plz">PLZ <span class="required">*</span></label>
                <input type="text" name="plz" id="plz" placeholder="PLZ" value="<?= htmlspecialchars($plz ?? '') ?>" required>
            </div>
            <div class="input-group">
                <label for="city">City <span class="required">*</span></label>
                <input type="text" name="city" id="city" placeholder="City" value="<?= htmlspecialchars($city ?? '') ?>" required>
            </div>
        </div>

        <div class="input-group">
            <label for="country">Country <span class="required">*</span></label>
            <input type="text" name="country" id="country" value="<?= htmlspecialchars($country ?? '') ?>" required>
        </div>

        <div class="two-columns">
            <div class="input-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <small id="password-match" class="info-message"></small>
            </div>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" name="accept_tos" id="accept_tos" <?= isset($_POST['accept_tos']) ? 'checked' : '' ?> required>
            <label for="accept_tos">I accept the <a href="https://github.com/sprudello/Dverggas/blob/main/important/GToS.md" target="_blank" class="legal-link">General Terms and Conditions</a> <span class="required">*</span></label>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" name="accept_privacy" id="accept_privacy" <?= isset($_POST['accept_privacy']) ? 'checked' : '' ?> required>
            <label for="accept_privacy">I accept the <a href="https://github.com/sprudello/Dverggas/blob/main/important/PP.md" target="_blank" class="legal-link">Privacy Policy</a> <span class="required">*</span></label>
        </div>

        <button type="submit" class="login-button">Register</button>
    </form>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include country-select-js and intl-tel-input scripts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.1.1/css/countrySelect.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.1.1/js/countrySelect.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>

<script>
    // Initialize intl-tel-input for phone numbers
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        separateDialCode: true,
        initialCountry: "ch",
        preferredCountries: ["ch", "de", "fr", "it", "us"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // Update hidden phone_code input on country change or input
    input.addEventListener('countrychange', function() {
        var countryData = iti.getSelectedCountryData();
        document.getElementById('phone_code').value = '+' + countryData.dialCode;
    });

    // Initialize country-select
    $(document).ready(function() {
        $("#country").countrySelect({
            defaultCountry: "ch", 
            preferredCountries: ["ch", "de", "fr", "it", "us"],
        });

        var countryValue = $("#country").val();
        if (countryValue) {
            $("#country").countrySelect("setCountry", countryValue);
        }
    });

    // Password Match Check
    $("#password, #confirm_password").on('keyup', function () {
        var password = $("#password").val();
        var confirm_password = $("#confirm_password").val();

        if (password === confirm_password && password !== "") {
            $("#password-match").html("<span style='color: green;'>Passwords match</span>");
        } else {
            $("#password-match").html("<span style='color: red;'>Passwords do not match</span>");
        }
    });

    // Populate phone_code on initial load if a country is pre-selected
    document.addEventListener("DOMContentLoaded", function() {
        var countryData = iti.getSelectedCountryData();
        document.getElementById('phone_code').value = '+' + countryData.dialCode;
    });
</script>