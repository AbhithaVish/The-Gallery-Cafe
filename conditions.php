<?php
include_once('connection.php');
include_once('navbar.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions and Privacy Policy</title>
    <style>
        body {
            overflow-y: scroll;
            display: flex;
            font-family: Arial, sans-serif;
            padding: 0;
            color: black;
        }
        .container-policy {
            max-width: 800px;
            height: 1100px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 150px; 
        }
        .head {
            text-align: center;
            margin-bottom: 20px;
        }
        .head h1 {
            font-size: 2em;
            margin: 0;
        }
        .body ol {
            padding-left: 20px;
        }
        .body ol li {
            font-weight: bold;
            margin-top: 10px;
        }
        .body p {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container-policy">
        <div class="head">
            <h1>Terms and Conditions</h1>
        </div>
        <div class="body">
            <ol>
                <li><strong>Introduction</strong></li>
                <p>Welcome to the Gallery Cafe Restaurant. These terms and conditions outline the rules and regulations for the use of our services.</p>
                <li><strong>Reservations</strong></li>
                <p>Reservations can be made via our website, phone, or in person. We reserve the right to cancel or modify reservations in case of unforeseen circumstances.</p>
                <li><strong>Cancellations</strong></li>
                <p>Cancellations must be made at least 24 hours in advance. No-shows or late cancellations may incur a fee.</p>
                <li><strong>Food and Beverage</strong></li>
                <p>All menu items are subject to availability. Prices and menu items are subject to change without prior notice.</p>
                <li><strong>Payment</strong></li>
                <p>We accept cash, credit cards, and other specified payment methods. All payments must be made at the time of service unless otherwise agreed.</p>
                <li><strong>Allergies and Dietary Requirements</strong></li>
                <p>Please inform us of any allergies or dietary requirements at the time of booking or ordering. We will make every effort to accommodate your needs but cannot guarantee the absence of allergens.</p>
                <li><strong>Conduct</strong></li>
                <p>We expect all patrons to behave respectfully towards staff and other guests. We reserve the right to refuse service to anyone acting inappropriately.</p>
                <li><strong>Liability</strong></li>
                <p>The Gallery Cafe Restaurant is not liable for any personal injury, loss, or damage to property while on the premises.</p>
                <li><strong>Changes to Terms</strong></li>
                <p>We reserve the right to amend these terms and conditions at any time. Any changes will be posted on our website.</p>
                <li><strong>Governing Law</strong></li>
                <p>These terms and conditions are governed by the laws of the jurisdiction in which the restaurant is located.</p>
            </ol>
        </div>
    </div>
    <div class="container-policy">
        <div class="head">
            <h1>Privacy Policy</h1>
        </div>
        <div class="body">
            <ol>
                <li><strong>Introduction</strong></li>
                <p>The Gallery Cafe Restaurant is committed to protecting your privacy. This policy outlines how we collect, use, and safeguard your personal information.</p>
                <li><strong>Information Collection</strong></li>
                <p>We may collect personal information such as your name, contact details, and payment information when you make a reservation, place an order, or sign up for our newsletter. We may also collect non-personal information such as your IP address and browser type for analytical purposes.</p>
                <li><strong>Use of Information</strong></li>
                <p>Personal information is used to provide and improve our services, process payments, and communicate with you. Non-personal information is used to analyze website traffic and improve our online presence.</p>
                <li><strong>Sharing of Information</strong></li>
                <p>We do not sell, trade, or otherwise transfer your personal information to outside parties without your consent, except as required by law or to protect our rights. We may share information with third-party service providers who assist us in operating our business, such as payment processors and email marketing services.</p>
                <li><strong>Data Security</strong></li>
                <p>We implement a variety of security measures to protect your personal information. Despite our efforts, no method of transmission over the internet or electronic storage is 100% secure.</p>
                <li><strong>Cookies</strong></li>
                <p>Our website uses cookies to enhance your browsing experience. You can choose to disable cookies through your browser settings, but this may affect the functionality of our website.</p>
                <li><strong>Your Rights</strong></li>
                <p>You have the right to access, correct, or delete your personal information held by us. You may also opt-out of receiving marketing communications from us at any time.</p>
                <li><strong>Changes to Privacy Policy</strong></li>
                <p>We reserve the right to update this privacy policy at any time. Any changes will be posted on our website.</p>
                <li><strong>Contact Us</strong></li>
                <p>If you have any questions or concerns about our privacy policy, please contact us at <a href="tel:+94 114 777 888">114 777 888</a>.</p>
            </ol>
        </div>
    </div>
</body>
</html>
