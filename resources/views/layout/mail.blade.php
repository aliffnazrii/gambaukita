<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>GambauKita.com - Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: #9068be;
            padding: 20px;
            text-align: center;
        }

        .email-header img {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 0;
        }

        .email-body {
            padding: 20px;
            font-size: 16px;
            line-height: 1.6;
            color: #333333;
        }

        .email-body h2 {
            font-size: 18px;
            color: #333333;
        }

        .email-footer {
            background-color: #9068be;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            color: #333333;
        }

        .email-footer a {
            color: #6e4e93;
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            background-color: #9068be;
            color: #ffffff;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #9c70ce;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Email Header -->
        <div class="email-header">
          
            <h1>GambauKita.com</h1>
        </div>

        <!-- Email Body -->
        <div class="email-body">
            <h2>Hello {{ $user->name }},</h2>
            <p>
                We are excited to share some important updates with you! Here are the details:
            </p>

            <!-- Dynamic content goes here -->
            <p>{{ $content }}</p>

            <!-- Call-to-action button -->
            <a href="{{ $action_url }}" class="btn">{{ $button_text }}</a>
        </div>

        <!-- Email Footer -->
        <div class="email-footer">
            <p>
                If you have any questions, feel free to reach out to us at <a href="mailto:support@gambaukita.com">support@gambaukita.com</a>
            </p>
            <p>
                You can also visit our <a href="{{ $website_url }}">website</a> for more information.
            </p>
            <p>
                &copy; 2025 GambauKita. All rights reserved.
            </p>
        </div>
    </div>
</body>

</html>
