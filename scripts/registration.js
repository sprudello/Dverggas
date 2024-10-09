document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("registration-form");
  const steps = Array.from(form.querySelectorAll(".step"));
  const nextButtons = form.querySelectorAll(".next-button");
  const prevButtons = form.querySelectorAll(".prev-button");
  const progressSteps = document.querySelectorAll(".progress-step");
  const progressBar = document.querySelector(".progress-bar");
  const totalSteps = steps.length;
  let currentStep = 0;

  // Initialize the first step
  showStep(currentStep);

  // Add event listeners to Next buttons
  nextButtons.forEach((button) => {
    button.addEventListener("click", () => {
      if (validateStep(currentStep)) {
        // Mark the current step as completed
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

  // Add event listeners to Previous buttons
  prevButtons.forEach((button) => {
    button.addEventListener("click", () => {
      currentStep--;
      if (currentStep >= 0) {
        // Revert the previous step to active and show the step number
        progressSteps[currentStep].classList.remove("completed");
        progressSteps[currentStep].classList.add("active");
        progressSteps[currentStep].innerHTML = currentStep + 1; // Reset to show the step number
        showStep(currentStep);
      }
    });
  });

  // Function to update the progress step content
  function updateProgressStepContent(stepIndex) {
    if (progressSteps[stepIndex].classList.contains("completed")) {
      progressSteps[stepIndex].innerHTML = '<i class="fa-solid fa-check"></i>';
    } else {
      progressSteps[stepIndex].innerHTML = stepIndex + 1;
    }
  }

  // Function to show a specific step
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
        // Show step number if not completed
        if (!ps.classList.contains("completed")) {
          ps.innerHTML = index + 1;
        }
      } else {
        ps.classList.remove("active", "completed");
        ps.innerHTML = index + 1;
      }
    });

    // Calculate and set progress
    const progressPercentage = step === 0 ? 0 : (step / (totalSteps - 1)) * 100;
    progressBar.style.setProperty("--progress", `${progressPercentage}%`);

    // Focus on the first input of the current step
    const firstInput = steps[step].querySelector("input, select, textarea");
    if (firstInput) {
      firstInput.focus();
    }

    // Scroll to the top of the form on step change
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

    // Additional custom validation for password match (assuming step 5 is password)
    if (step === 4) {
      // Adjust index if step order changes
      const password = document.getElementById("password");
      const confirmPassword = document.getElementById("confirm_password");
      const passwordMatchMsg = document.getElementById("password-match");

      if (password.value !== confirmPassword.value) {
        passwordMatchMsg.textContent = "Passwords do not match.";
        valid = false;
      } else {
        passwordMatchMsg.textContent = "";
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

  // Optional: Handle form submission
  form.addEventListener("submit", (e) => {
    // Final validation before submission
    if (!validateStep(currentStep)) {
      e.preventDefault();
    }
  });
});
