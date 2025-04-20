<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .container {
            background-color: #f9f9f9;
            border-radius: 5px;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Verify Your Email Address</h2>
        </div>
        
        <p>Dear {{$name}},</p>
        
        <p>Thank you for registering with our service. Before we can activate your account, please verify your email address by clicking the button below:</p>
        
        <div style="text-align: center;">
            <a class="button" href="{{$link}}" target='_blank'>Verify Email Address</a>
        </div>
        
        <p>If you did not create an account, no further action is required.</p>
        
        <p>If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:</p>
        
        <div style="word-break: break-all; margin: 15px 0; padding: 10px; background-color: #eee; border-radius: 3px;">
            {{$link}}
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} WebSecService. All rights reserved.</p>
        </div>
    </div>
</body>
</html>