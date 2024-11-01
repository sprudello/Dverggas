<?php
session_start();
include '../db/connection.php';

$errors = [];

// Initialize variables to avoid undefined variable warnings
$username = $firstname = $lastname = $display_name = $email = $phone_number = $phone_code = '';
$street = $street2 = $house_number = $plz = $city = $country = '';
$accept_tos = $accept_privacy = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    $accept_tos = isset($_POST['accept_tos']);
    $accept_privacy = isset($_POST['accept_privacy']);

    // Combine phone code and phone number
    if (empty($phone_number)) {
        $full_phone_number = null;
    } else {
        $full_phone_number = $phone_code . $phone_number;
    }

    // Validate required fields
    if (empty($username)) $errors[] = "Username is required.";
    if (empty($firstname)) $errors[] = "Firstname is required.";
    if (empty($lastname)) $errors[] = "Lastname is required.";
    if (empty($email)) $errors[] = "Email is required.";
    if (empty($street)) $errors[] = "Street is required.";
    if (empty($house_number)) $errors[] = "House number is required.";
    if (empty($plz)) $errors[] = "PLZ is required.";
    if (empty($city)) $errors[] = "City is required.";
    if (empty($country)) $errors[] = "Country is required.";
    if (empty($password)) $errors[] = "Password is required.";

    // Validate email format
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format!";
    }

    // Validate PLZ format
    if (!empty($plz) && !preg_match('/^\d{5}$/', $plz)) {
        $errors[] = "PLZ must be exactly 5 digits.";
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

    // If no errors, proceed with registration
    if (empty($errors)) {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the INSERT statement
        $stmt = $conn->prepare("INSERT INTO users (username, firstname, lastname, display_name, email, phone_number, street, street2, house_number, plz, city, country, password_hash) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            // Bind parameters
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

            // (Un)Successful registration
            if ($stmt->execute()) {
                echo "<script>window.location.href = 'login.php'; </script>";
                exit;
            } else {
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
<div class="registration-container">
    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form id="registration-form" method="post" action="">
        <div class="progress-container">
            <div class="progress-bar"></div>
            <div class="progress-steps">
                <div class="progress-step active">1</div>
                <div class="progress-step">2</div>
                <div class="progress-step">3</div>
                <div class="progress-step">4</div>
                <div class="progress-step">5</div>
                <div class="progress-step">6</div>
            </div>
        </div>

        <div class="steps-container">
            <!-- Step 1: Personal Information -->
            <div class="step active">
                <h2>Personal Information</h2>
                <div class="two-columns">
                    <div class="input-group">
                        <label for="firstname">Firstname <span class="required">*</span></label>
                        <input type="text" name="firstname" id="firstname" required value="<?php echo htmlspecialchars($firstname); ?>">
                    </div>
                    <div class="input-group">
                        <label for="lastname">Lastname <span class="required">*</span></label>
                        <input type="text" name="lastname" id="lastname" required value="<?php echo htmlspecialchars($lastname); ?>">
                    </div>
                </div>
                <div class="two-columns">
                    <div class="input-group">
                        <label for="display_name">Displayname</label>
                        <input type="text" name="display_name" id="display_name" value="<?php echo htmlspecialchars($display_name); ?>">
                    </div>
                    <div class="input-group">
                        <label for="username">Username <span class="required">*</span></label>
                        <input type="text" name="username" id="username" required value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                </div>
                <button type="button" class="next-button">Next</button>
            </div>

            <!-- Step 2: Contact Information -->
            <div class="step">
                <h2>Contact Information</h2>
                <div class="input-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="input-group">
                    <label for="phone">Phone number</label>
                    <input type="tel" id="phone" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">
                </div>
                <input type="hidden" id="phone_code" name="phone_code" value="<?php echo htmlspecialchars($phone_code); ?>">
                <button type="button" class="prev-button">Previous</button>
                <button type="button" class="next-button">Next</button>
            </div>

            <!-- Step 3: Address -->
            <div class="step">
                <h2>Address</h2>
                <div class="two-columns">
                    <div class="input-group">
                        <label for="street">Street <span class="required">*</span></label>
                        <input type="text" name="street" id="street" required value="<?php echo htmlspecialchars($street); ?>">
                    </div>
                    <div class="input-group">
                        <label for="house_number">House number <span class="required">*</span></label>
                        <input type="text" name="house_number" id="house_number" required value="<?php echo htmlspecialchars($house_number); ?>">
                    </div>
                </div>
                <div class="input-group">
                    <label for="street2">Additional Address</label>
                    <input type="text" name="street2" id="street2" value="<?php echo htmlspecialchars($street2); ?>">
                </div>
                <button type="button" class="prev-button">Previous</button>
                <button type="button" class="next-button">Next</button>
            </div>

            <!-- Step 4: Location -->
            <div class="step">
                <h2>Location</h2>
                <div class="two-columns">
                    <div class="input-group">
                        <label for="plz">PLZ <span class="required">*</span></label>
                        <input type="text" name="plz" id="plz" maxlength="5" pattern="\d{5}" required value="<?php echo htmlspecialchars($plz); ?>">
                    </div>
                    <div class="input-group">
                        <label for="city">City <span class="required">*</span></label>
                        <input type="text" name="city" id="city" required value="<?php echo htmlspecialchars($city); ?>">
                    </div>
                </div>
                <div class="input-group">
                    <label for="country">Country <span class="required">*</span></label>
                    <input type="text" name="country" id="country" required value="<?php echo htmlspecialchars($country); ?>">
                </div>
                <button type="button" class="prev-button">Previous</button>
                <button type="button" class="next-button">Next</button>
            </div>

            <!-- Step 5: Password -->
            <div class="step">
                <h2>Password</h2>
                <div class="input-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="input-group">
                    <label for="confirm_password">Confirm Password <span class="required">*</span></label>
                    <input type="password" name="confirm_password" id="confirm_password" required>
                    <small id="password-match" class="info-message"></small>
                </div>
                <button type="button" class="prev-button">Previous</button>
                <button type="button" class="next-button">Next</button>
            </div>

            <!-- Step 6: Terms and Conditions -->
            <div class="step">
                <h2>Terms and Conditions</h2>
                <div class="checkbox-group">
                    <input type="checkbox" name="accept_tos" id="accept_tos" <?php echo $accept_tos ? 'checked' : ''; ?> required>
                    <label for="accept_tos">I accept the <a href="#" class="legal-link">General Terms and Conditions</a> <span class="required">*</span></label>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" name="accept_privacy" id="accept_privacy" <?php echo $accept_privacy ? 'checked' : ''; ?> required>
                    <label for="accept_privacy">I accept the <a href="#" class="legal-link">Privacy Policy</a> <span class="required">*</span></label>
                </div>
                <button type="button" class="prev-button">Previous</button>
                <button type="submit" class="submit-button">Register</button>
            </div>
        </div>
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
    document.addEventListener("DOMContentLoaded", () => {
      
        // Initialize intl-tel-input
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            separateDialCode: true,
            initialCountry: "ch",
            preferredCountries: ["ch", "de", "fr", "it", "us"],
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        // Update hidden phone_code input
        input.addEventListener('countrychange', function () {
            var countryData = iti.getSelectedCountryData();
            document.getElementById('phone_code').value = '+' + countryData.dialCode;
        });

        // Populate phone_code on initial load
        var countryData = iti.getSelectedCountryData();
        document.getElementById('phone_code').value = '+' + countryData.dialCode;

        // Initialize country-select
        $("#country").countrySelect({
            defaultCountry: "ch",
            preferredCountries: ["ch", "de", "fr", "it", "us"],
        });

        var countryValue = $("#country").val();
        if (countryValue) {
            $("#country").countrySelect("setCountry", countryValue);
        }

        // Multi-step form script
        const form = document.getElementById("registration-form");
        const steps = Array.from(form.querySelectorAll(".step"));
        const nextButtons = form.querySelectorAll(".next-button");
        const prevButtons = form.querySelectorAll(".prev-button");
        const progressSteps = document.querySelectorAll(".progress-step");
        const progressBar = document.querySelector(".progress-bar");
        const totalSteps = steps.length;
        let currentStep = 0;

        showStep(currentStep);

        nextButtons.forEach((button) => {
            button.addEventListener("click", () => {
                if (validateStep(currentStep)) {
                    progressSteps[currentStep].classList.add("completed");
                    progressSteps[currentStep].classList.remove("active");
                    updateProgressStepContent(currentStep);

                    currentStep++;
                    if (currentStep < totalSteps) {
                        showStep(currentStep);
                    }
                }
            });
        });

        // Event listeners for Previous buttons
        prevButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentStep--;
                if (currentStep >= 0) {
                    progressSteps[currentStep].classList.remove("completed");
                    progressSteps[currentStep].classList.add("active");
                    progressSteps[currentStep].innerHTML = currentStep + 1;
                    showStep(currentStep);
                }
            });
        });

        // Update progress step content
        input.addEventListener('countrychange', function () {
            var countryData = iti.getSelectedCountryData();
            document.getElementById('phone_code').value = '+' + countryData.dialCode;
        });

        var countryData = iti.getSelectedCountryData();
        document.getElementById('phone_code').value = '+' + countryData.dialCode;

        $("#country").countrySelect({
            defaultCountry: "ch",
            preferredCountries: ["ch", "de", "fr", "it", "us"],
        });

        var countryValue = $("#country").val();
        if (countryValue) {
            $("#country").countrySelect("setCountry", countryValue);
        }

        const form = document.getElementById("registration-form");
        const steps = Array.from(form.querySelectorAll(".step"));
        const nextButtons = form.querySelectorAll(".next-button");
        const prevButtons = form.querySelectorAll(".prev-button");
        const progressSteps = document.querySelectorAll(".progress-step");
        const progressBar = document.querySelector(".progress-bar");
        const totalSteps = steps.length;
        let currentStep = 0;

        showStep(currentStep);

        nextButtons.forEach((button) => {
            button.addEventListener("click", () => {
                if (validateStep(currentStep)) {
                    progressSteps[currentStep].classList.add("completed");
                    progressSteps[currentStep].classList.remove("active");
                    updateProgressStepContent(currentStep);

                    currentStep++;
                    if (currentStep < totalSteps) {
                        showStep(currentStep);
                    }
                }
            });
        });

        prevButtons.forEach((button) => {
            button.addEventListener("click", () => {
                currentStep--;
                if (currentStep >= 0) {
                    progressSteps[currentStep].classList.remove("completed");
                    progressSteps[currentStep].classList.add("active");
                    progressSteps[currentStep].innerHTML = currentStep + 1;
                    showStep(currentStep);
                }
            });
        });

        function updateProgressStepContent(stepIndex) {
            if (progressSteps[stepIndex].classList.contains("completed")) {
                progressSteps[stepIndex].innerHTML = '<i class="fa-solid fa-check"></i>';
            } else {
                progressSteps[stepIndex].innerHTML = stepIndex + 1;
            }
        }

        function showStep(step) {
            steps.forEach((s, index) => {
                s.classList.toggle("active", index === step);
            });

            // Update progress steps classes
            progressSteps.forEach((ps, index) => {
                if (index < step) {
                    ps.classList.add("completed");
                    updateProgressStepContent(index);
                } else if (index === step) {
                    ps.classList.add("active");
                    ps.classList.remove("completed");
                    if (!ps.classList.contains("completed")) {
                        ps.innerHTML = index + 1;
                    }
                } else {
                    ps.classList.remove("active", "completed");
                    ps.innerHTML = index + 1;
                }
            });
          
            // Focus on the first input of the current step
            const progressPercentage = step === 0 ? 0 : (step / (totalSteps - 1)) * 100;
            progressBar.style.setProperty("--progress", `${progressPercentage}%`);
            const firstInput = steps[step].querySelector("input, select, textarea");
            if (firstInput) {
                firstInput.focus();
            }

            form.scrollIntoView({ behavior: "smooth" });
        }

        // Function to validate the current step
        function validateStep(step) {
            const currentFormStep = steps[step];
            const inputs = Array.from(
                currentFormStep.querySelectorAll("input, select, textarea")
            );
            let valid = true;

            inputs.forEach((input) => {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    valid = false;
                }
            });

            // Additional validation for password match
            if (step === 4) {
                const password = document.getElementById("password");
                const confirmPassword = document.getElementById("confirm_password");
                const passwordMatchMsg = document.getElementById("password-match");

                if (password.value !== confirmPassword.value) {
                    passwordMatchMsg.textContent = "Passwords do not match.";
                    valid = false;
                } else {
                    passwordMatchMsg.textContent = "Passwords match.";
                }
            }
            return valid;
        }
        // Real-time password match validation
        const password = document.getElementById("password");
        const confirmPassword = document.getElementById("confirm_password");
        const passwordMatchMsg = document.getElementById("password-match");

        if (password && confirmPassword && passwordMatchMsg) {
            confirmPassword.addEventListener("input", () => {
                if (password.value !== confirmPassword.value) {
                    passwordMatchMsg.textContent = "Passwords do not match.";
                } else {
                    passwordMatchMsg.textContent = "";
                }
            });
        }
    });
    </script>
