<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        # FIX: Replace this email with recipient email
        $mail_to = "example@yourdomain.com";
        # Sender Data
        $subject = trim($_POST["subject"]);
        $firstname = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["firstname"])));
        $lastname = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["lastname"])));
        $email = trim($_POST["email"]);
        $phone = trim($_POST["phone"]);
        $message = trim($_POST["message"]);
        # Mail Content
        $content = "First Name: $firstname\n";
        $content .= "Last Name: $lastname\n";
        $content .= "Email: $email\n\n";
        $content .= "Phone: $phone\n";
        $content .= "Message:\n$message\n";
        # email headers.
        $headers = "From: $firstname $lastname <$email>";
        # Send the email.
        $success = mail($mail_to, $subject, $content, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            # echo "Thank You! Your message has been sent.";
            # Back to contact
            header("Location: ../../contact.html?code=200");
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            # echo "Oops! Something went wrong, we couldn't send your message.";   # Back to contact
            header("Location: ../../contact.html?code=500");
        }
    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        # echo "There was a problem with your submission, please try again.";   
        # Back to contact
        header("Location: ../../contact.html?code=403");

    }
?>
