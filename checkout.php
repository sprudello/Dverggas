<?php
session_start();
include_once 'include/head.php';
include_once 'include/header.php';
?>

<div class="checkout-container">
    <div class="progress-container">
        <div class="progress-bar"></div>
        <div class="progress-steps">
            <div class="progress-step active">1</div>
            <div class="progress-step">2</div>
            <div class="progress-step">3</div>
            <div class="progress-step">4</div>
        </div>
    </div>

    <form id="checkout-form" method="post" action="">
        <div class="steps-container">
            <!-- Step 1: Review Cart -->
            <div class="step active">
                <h2>Review Your Cart</h2>
                <div id="checkout-cart-items">
                    <!-- Will be populated by JavaScript -->
                </div>
                <div class="cart-summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="checkout-subtotal">0.00 CHF</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span id="checkout-shipping">0.00 CHF</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span id="checkout-total">0.00 CHF</span>
                    </div>
                </div>
                <button type="button" class="next-button">Next</button>
            </div>

            <!-- Step 2: Shipping -->
            <div class="step">
                <h2>Shipping Information</h2>
                <div class="two-columns">
                    <div class="input-group">
                        <label for="shipping-firstname">First Name <span class="required">*</span></label>
                        <input type="text" id="shipping-firstname" name="shipping-firstname" required>
                    </div>
                    <div class="input-group">
                        <label for="shipping-lastname">Last Name <span class="required">*</span></label>
                        <input type="text" id="shipping-lastname" name="shipping-lastname" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="shipping-street">Street Address <span class="required">*</span></label>
                    <input type="text" id="shipping-street" name="shipping-street" required>
                </div>
                <div class="input-group">
                    <label for="shipping-street2">Additional Address</label>
                    <input type="text" id="shipping-street2" name="shipping-street2">
                </div>
                <div class="two-columns">
                    <div class="input-group">
                        <label for="shipping-zip">ZIP Code <span class="required">*</span></label>
                        <input type="text" id="shipping-zip" name="shipping-zip" required>
                    </div>
                    <div class="input-group">
                        <label for="shipping-city">City <span class="required">*</span></label>
                        <input type="text" id="shipping-city" name="shipping-city" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="shipping-country">Country <span class="required">*</span></label>
                    <input type="text" id="shipping-country" name="shipping-country" required>
                </div>
                <button type="button" class="prev-button">Previous</button>
                <button type="button" class="next-button">Next</button>
            </div>

            <!-- Step 3: Payment -->
            <div class="step">
                <h2>Payment Information</h2>
                <div class="input-group">
                    <label for="card-number">Card Number <span class="required">*</span></label>
                    <input type="text" id="card-number" name="card-number" required>
                </div>
                <div class="two-columns">
                    <div class="input-group">
                        <label for="expiry-date">Expiry Date <span class="required">*</span></label>
                        <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" required>
                    </div>
                    <div class="input-group">
                        <label for="cvv">CVV <span class="required">*</span></label>
                        <input type="text" id="cvv" name="cvv" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="card-name">Name on Card <span class="required">*</span></label>
                    <input type="text" id="card-name" name="card-name" required>
                </div>
                <button type="button" class="prev-button">Previous</button>
                <button type="button" class="next-button">Next</button>
            </div>

            <!-- Step 4: Confirmation -->
            <div class="step">
                <h2>Order Confirmation</h2>
                <div class="confirmation-summary">
                    <div id="shipping-summary">
                        <h3>Shipping To:</h3>
                        <div id="shipping-address-display"></div>
                    </div>
                    <div id="payment-summary">
                        <h3>Payment Method:</h3>
                        <div id="payment-details-display"></div>
                    </div>
                    <div id="order-summary">
                        <h3>Order Summary:</h3>
                        <div id="final-cart-display"></div>
                    </div>
                </div>
                <button type="button" class="prev-button">Previous</button>
                <button type="submit" class="submit-button">Place Order</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const steps = Array.from(form.querySelectorAll('.step'));
    const nextButtons = form.querySelectorAll('.next-button');
    const prevButtons = form.querySelectorAll('.prev-button');
    const progressSteps = document.querySelectorAll('.progress-step');
    const progressBar = document.querySelector('.progress-bar');
    let currentStep = 0;

    function updateProgress() {
        const progress = (currentStep / (steps.length - 1)) * 100;
        progressBar.style.setProperty('--progress', `${progress}%`);
        
        progressSteps.forEach((step, idx) => {
            if (idx < currentStep) {
                step.classList.add('completed');
                step.classList.remove('active');
            } else if (idx === currentStep) {
                step.classList.add('active');
                step.classList.remove('completed');
            } else {
                step.classList.remove('active', 'completed');
            }
        });
    }

    function showStep(step) {
        steps.forEach((s, index) => {
            s.classList.toggle('active', index === step);
        });
        updateProgress();
    }

    nextButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    // Initialize first step
    showStep(currentStep);
});
</script>

<?php include_once 'include/footer.php'; ?>
