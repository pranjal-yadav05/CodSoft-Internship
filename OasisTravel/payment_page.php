<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment Gateway - Oasis Travel</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f3f3f3;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    max-width: 400px;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

.header {
    text-align: center;
    margin-bottom: 20px;
}

.header img {
    width: 80px;
    height: auto;
}

.header h1 {
    font-size: 24px;
    margin: 10px 0;
    color: #333;
}

.payment-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.payment-form input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box; 
}

.pay-button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.pay-button:hover {
    background-color: #0056b3;
}

.popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: fit-content;
    max-width: 80%;
}



.processing-animation {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.spinner {
    border: 3px solid rgba(0, 0, 0, 0.3);
    border-top: 3px solid #007bff;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin-bottom: 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.success-message {
    display: none;
    margin-top: 20px;
}

.hidden {
    display: none;
}
.paymentPopup{
    display:none;
}

</style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logos.png" alt="Oasis Travel Logo">
            <h1>Secure Payment Gateway</h1>
        </div>
        <div class="payment-form">
            <form method="post">
                <label for="cardNumber">Card Number</label>
                <input type="text" id="cardNumber" name="cardNumber" required>
                <label for="expiry">Expiry Date</label>
                <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" required>
                <button type="button" id="payButton" class="pay-button">Pay Now</button>
            </form>
        </div>
        <div class="popup" id="paymentPopup">
            <div class="popup-content">
                <div class="processing-animation">
                    <div class="spinner"></div>
                    <p>Processing Payment...</p>
                </div>
                <div class="success-message hidden">
                    <p>Payment Successful!</p>
                    <button class="download-button"><a  id="backBtn" href="generate_ticket_pdf.php">Download Ticket</a></button>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        var payButton = document.getElementById("payButton");
        var paymentPopup = document.getElementById("paymentPopup");
        var processingAnimation = paymentPopup.querySelector(".processing-animation");
        var successMessage = paymentPopup.querySelector(".success-message");
        var downloadButton = successMessage.querySelector(".download-button");
        var container = document.querySelector(".container");
        var redirectingCounter = 10; 

        payButton.addEventListener("click", function () {
            paymentPopup.style.display="block";
            processingAnimation.style.display = "flex";

            setTimeout(function () {
                processingAnimation.style.display = "none";
                successMessage.style.display = "block";
            }, 3000); 
        });

        downloadButton.addEventListener("click", function () {
            successMessage.style.display = "none";
            container.innerHTML = '<p style="text-align: center; font-size: 18px;">Redirecting to Home in <span id="redirectingCounter">10</span> seconds...</p>';

            // Start the countdown timer
            var counterElement = document.getElementById("redirectingCounter");
            var countdownInterval = setInterval(function () {
                redirectingCounter--;
                counterElement.textContent = redirectingCounter;

                if (redirectingCounter <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = "index.php";
                }
            }, 1000);
        });
    });
</script>
</body>
</html>
