<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Deposit</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Payment Container Styling */
        .payment-container {
            text-align: center;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 26px;
            font-weight: bold;
            color: #2d2d2d;
        }

        .amount {
            font-size: 22px;
            color: #1e90ff;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* Payment Element Styling */
        #payment-element {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fafafa;
        }

        /* Button Styling */
        #pay-button {
            padding: 14px 30px;
            font-size: 18px;
            color: #ffffff;
            background-color: #1e90ff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #pay-button:hover {
            background-color: #0056b3;
        }

        #pay-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* Footer Styling */
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .payment-container {
                padding: 30px;
            }

            h2 {
                font-size: 24px;
            }

            .amount {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <h2>Pay Your Deposit</h2>
        <div class="amount">MYR {{ $depositAmount / 100 }}</div>

        <!-- Payment Element for Stripe -->
        <div id="payment-element"></div>

        <button id="pay-button">Pay Now</button>

        <div class="footer">
            <p>Your payment is securely processed by Stripe.</p>
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
