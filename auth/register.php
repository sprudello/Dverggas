<?php
session_start();
include '../db/connection.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $display_name = $_POST['display_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $phone_code = $_POST['phone_code'];
    $street = $_POST['street'];
    $street2 = $_POST['street2'];
    $house_number = $_POST['house_number'];
    $plz = $_POST['plz'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

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
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = "Username already taken!";
    }
    $stmt->close();

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

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, firstname, lastname, display_name, email, phone_number, street, street2, house_number, plz, city, country, password_hash) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssssssssss', $username, $firstname, $lastname, $display_name, $email, $full_phone_number, $street, $street2, $house_number, $plz, $city, $country, $password_hash);

        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
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

        <!-- First Step -->
        <div class="two-columns">
            <div class="input-group">
                <label for="firstname">Firstname <span class="required">*</span></label>
                <input type="text" name="firstname" id="firstname" placeholder="Firstname" required>
            </div>
            <div class="input-group">
                <label for="lastname">Lastname <span class="required">*</span></label>
                <input type="text" name="lastname" id="lastname" placeholder="Lastname" required>
            </div>
        </div>

        <div class="two-columns">
            <div class="input-group">
                <label for="display_name">Displayname</label>
                <input type="text" name="display_name" id="display_name" placeholder="Displayname (optional)">
            </div>
            <div class="input-group">
                <label for="username">Username <span class="required">*</span></label>
                <input type="text" name="username" id="username" placeholder="Username" required>
            </div>
        </div>
        
        <!-- Second Step -->
        <div class="two-columns">
            <div class="input-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" name="email" id="email" placeholder="Email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
            </div>
            <div class="input-group">
                <label for="phone_number">Phone number</label>
                <input type="tel" id="phone" name="phone_number" placeholder="Phone Number">
            </div>
        </div>

        <!-- Third Step -->
        <div class="two-columns">
            <div class="input-group">
                <label for="street">Address <span class="required">*</span></label>
                <input type="text" name="street" id="street" placeholder="Street" required>
            </div>
            <div class="input-group">
                <label for="house_number">House number <span class="required">*</span></label>
                <input type="text" name="house_number" id="house_number" placeholder="House Number" required>
            </div>
        </div>

        <div class="input-group">
            <label for="street2">Additional Address</label>
            <input type="text" name="street2" id="street2" placeholder="Street 2 (optional)">
        </div>
        
        <!-- Fourth Step -->
        <div class="two-columns">
            <div class="input-group">
                <label for="plz">PLZ <span class="required">*</span></label>
                <input type="text" name="plz" id="plz" placeholder="PLZ" required>
            </div>
            <div class="input-group">
                <label for="city">City <span class="required">*</span></label>
                <input type="text" name="city" id="city" placeholder="City" required>
            </div>
        </div>

        <div class="input-group">
            <label for="country">Country <span class="required">*</span></label>
            <input type="text" name="country" id="country" required>
        </div>
        
        <!-- Fifth Step -->
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
            <input type="checkbox" name="accept_tos" id="accept_tos" required>
            <label for="accept_tos">I accept the <a href="https://github.com/sprudello/Dverggas/blob/main/important/GToS.md" target="_blank" class="legal-link">General Terms and Conditions</a> <span class="required">*</span></label>
        </div>

        <div class="checkbox-group">
            <input type="checkbox" name="accept_privacy" id="accept_privacy" required>
            <label for="accept_privacy">I accept the <a href="https://github.com/sprudello/Dverggas/blob/main/important/PP.md" target="_blank" class="legal-link">Privacy Policy</a> <span class="required">*</span></label>
        </div>
        
        <!-- Last Step-->
        <button type="submit" class="login-button">Register</button>
    </form>
</div>


<?php include_once '../include/footer.php'; ?>

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
    window.intlTelInput(input, {
        separateDialCode: true,
        initialCountry: "ch",
        preferredCountries: ["ch", "de", "fr", "it", "us"]
    });

    // Initialize country-select for country dropdown
    $(document).ready(function() {
        $("#country").countrySelect({
            defaultCountry: "ch", 
            preferredCountries: ["ch", "de", "fr", "it", "us"]
        });
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
</script>