<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["c_name"]));
            $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["c_email"]), FILTER_SANITIZE_EMAIL);
        $phone = filter_var(trim($_POST["c_phone"]));
        $topic = strip_tags(trim($_POST["c_topic"]));
        $message = trim($_POST["c_message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR empty($phone) OR empty($topic) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "contact@speedmaxx.co.in";

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "Topic: $topic\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";
        
        // Send the phone.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
            

        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
            header("Location: http://www.redirect.to.url.com/");
            

        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
