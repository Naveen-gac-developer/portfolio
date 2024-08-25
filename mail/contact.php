<?php
function sendEmail($apiKey, $toEmail, $subject, $htmlContent, $fromName, $fromEmail) {
    // API URL for sending email immediately
    $apiUrl = 'https://api.brevo.com/v3/smtp/email';

    // Email settings
    $postData = json_encode([
        "sender" => [
            "name" => $fromName,
            "email" => $fromEmail
        ],
        "to" => [
            [
                "email" => $toEmail
            ]
        ],
        "subject" => $subject,
        "htmlContent" => $htmlContent
    ]);

    // Initialize cURL
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'api-key: ' . $apiKey // API Key for authentication
    ]);

    // Execute cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for errors
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return 'Failed to send email. Error: ' . $error;
    }

    curl_close($ch);

    // Check HTTP response code and return the response
    if ($httpCode >= 200 && $httpCode < 300) {
        return 'Email sent successfully! Response: ' . $response;
    } else {
        return 'Failed to send email. HTTP Code: ' . $httpCode . ' Response: ' . $response;
    }
}

// Example usage
$apiKey = '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'; // Your Brevo API key
$toEmail = 'nnavin528@gmail.com'; // Recipient's email address
$subject = 'Test Email';
$htmlContent = '<p>This is a test email sent using Brevo API.</p>';
$fromName = 'Your Name';
$fromEmail = 'your-email@yourdomain.com';

// Call the function to send the email and print the result
$result = sendEmail($apiKey, $toEmail, $subject, $htmlContent, $fromName, $fromEmail);
echo $result;
?>
