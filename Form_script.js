// script.js

// Function to handle the 'Other' donation amount input visibility
document.addEventListener('DOMContentLoaded', function() {
    const otherAmountInput = document.querySelector('input[name="other_amount"]');
    const radioButtons = document.querySelectorAll('input[name="amount"]');
    
    radioButtons.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'other') {
                otherAmountInput.style.display = 'inline';
            } else {
                otherAmountInput.style.display = 'none';
            }
        });
    });

    // Hide the 'Other' donation amount input initially
    otherAmountInput.style.display = 'none';
});

