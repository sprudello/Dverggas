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

    // Multi-step form script
    let currentStep = 0;
    const form = document.getElementById("registration-form");
    const steps = Array.from(form.querySelectorAll(".step"));
    const nextButtons = form.querySelectorAll(".next-button");
    const prevButtons = form.querySelectorAll(".prev-button");
    const progressSteps = document.querySelectorAll(".progress-step");
    const progressBar = document.querySelector(".progress-bar");
    const totalSteps = steps.length;

    function showStep(stepNumber) {
        steps.forEach((step, index) => {
            step.style.display = index === stepNumber ? "block" : "none";
            if (index === stepNumber) {
                step.classList.add("active");
            } else {
                step.classList.remove("active");
            }
        });

        // Update progress bar
        const progress = ((stepNumber) / (totalSteps - 1)) * 100;
        progressBar.style.setProperty("--progress", `${progress}%`);

        // Update progress steps
        progressSteps.forEach((step, index) => {
            if (index < stepNumber) {
                step.classList.add("completed");
                step.classList.remove("active");
                step.innerHTML = '<i class="fa-solid fa-check"></i>';
            } else if (index === stepNumber) {
                step.classList.add("active");
                step.classList.remove("completed");
                step.innerHTML = index + 1;
            } else {
                step.classList.remove("active", "completed");
                step.innerHTML = index + 1;
            }
        });
    }

    // Show initial step
    showStep(currentStep);

    // Next button event listeners
    nextButtons.forEach((button) => {
        button.addEventListener("click", () => {
            if (validateStep(currentStep)) {
                currentStep++;
                if (currentStep < steps.length) {
                    showStep(currentStep);
                }
            }
        });
    });

    // Previous button event listeners
    prevButtons.forEach((button) => {
        button.addEventListener("click", () => {
            currentStep--;
            if (currentStep >= 0) {
                showStep(currentStep);
            }
        });
    });

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
