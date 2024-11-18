<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Deposit</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f4f8;
            margin: 0;
        }

        .payment-container {
            text-align: center;
            padding: 30px;
            border: 1px solid #e0e0e0;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
        }

        .amount {
            font-size: 20px;
            color: #007bff;
            margin-bottom: 20px;
        }

        #payment-element {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        #pay-button {
            padding: 12px 25px;
            font-size: 18px;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        #pay-button:hover {
            background-color: #0056b3;
        }

        #pay-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <h2>Pay Deposit</h2>
        <div class="amount">MYR {{ $depositAmount / 100 }}</div>

        <!-- Payment Element for Stripe -->
        <div id="payment-element"></div>

        <button id="pay-button">Pay Deposit</button>

        <div class="footer">
            <p>Your payment is secure and processed by Stripe.</p>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Initialize Stripe
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const clientSecret = "{{ $clientSecret }}";

        console.log("Client Secret:", clientSecret); // Debugging

        // Check if clientSecret is populated
        if (!clientSecret) {
            alert("Client secret is missing. Please make sure it is provided.");
        }

        // Initialize Stripe Elements with the clientSecret
        const elements = stripe.elements({
            clientSecret: clientSecret
        });

        // Create an instance of the Payment Element
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');

        // Handle the payment button click
        document.getElementById('pay-button').addEventListener('click', async () => {
            console.log("Pay button clicked."); // Debugging
            document.getElementById('pay-button').disabled = true;

            try {
                const { error } = await stripe.confirmPayment({
                    elements,
                    confirmParams: {
                        return_url: "{{ route('payment.success', $bookingId) }}",
                    },
                });

                if (error) {
                    console.error("Payment confirmation error:", error.message);
                    alert("Error: " + error.message);
                } else {
                    console.log("Payment confirmed successfully.");
                }
            } catch (err) {
                console.error("Unexpected error during payment:", err);
                alert("Unexpected error occurred. Please try again.");
            }

            document.getElementById('pay-button').disabled = false;
        });
    </script>
</body>

</html>