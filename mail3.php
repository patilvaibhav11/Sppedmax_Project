<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["c_name"]));
            $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["c_email"]), FILTER_SANITIZE_EMAIL);
        $contact = trim($_POST["c_number"]);
        $address = trim($_POST["c_address"]);
        $city = trim($_POST["c_city"]);
        $pincode = trim($_POST["c_pincode"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($contact) OR empty($address) OR empty($city) OR empty($pincode) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "contact@speedmaxx.co.in";

        // Set the email subject.
        $subject = "New Package Requirements from $name";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Contact No: $contact\n\n";
        $email_content .= "Address: $address\n\n";
        $email_content .= "City: $city\n\n";
        $email_content .= "Pincode: $pincode\n\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";
        
        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
