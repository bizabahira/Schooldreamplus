<?php
// contact.php

// Start by checking if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include PHPMailer library
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'path/to/PHPMailer/src/Exception.php';
    require 'path/to/PHPMailer/src/PHPMailer.php';
    require 'path/to/PHPMailer/src/SMTP.php';

    // Function to send email
    function sendEmail($Recipient, $Subject, $Message, $SenderName)
    {
        $mail = new PHPMailer(true); // Passing `true` enables exceptions

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'mail.schooldream.co.rw';
            $mail->Port = 587; // Your SMTP port
            $mail->SMTPAuth = true;
            $mail->Username = 'mailsystem@schooldream.co.rw';
            $mail->Password = 'Ikoranabuhanga@1';
            $mail->SMTPSecure = 'tls';

            // Optional: For debugging SMTP issues
            // $mail->SMTPDebug = 2;

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Sender
            $mail->setFrom('mailsystem@schooldream.co.rw', $SenderName);

            // Recipient
            $mail->addAddress($Recipient);

            // Email content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = $Subject;

            // Define global variables or replace with actual values
            $school_name = "Your School Name";
            $school_location = "Your School Location";
            $school_contact = "+0123456789";
            $school_email = "info@schooldream.co.rw";
            $school_website = "https://www.schooldream.co.rw";

            $extraMsg = "<br><br><br>
            Kind Regards,<br>
            " . $SenderName . ",
            <br><br>
            " . $school_name . ",<br>
            " . $school_location . ",<br>
            Phone: " . $school_contact . ",<br>
            Email: " . $school_email . ",<br>
            Website: " . $school_website . "<br>";

            $mail->Body = $Message . $extraMsg;

            // Send the email
            if ($mail->send()) {
                // Redirect or display success message
                echo "<script>alert('Your message has been sent successfully!'); window.location.href='thankyou.html';</script>";
            } else {
                // Handle failure
                echo "<script>alert('There was an error sending your message. Please try again later.'); window.location.href='contact.html';</script>";
            }
        } catch (Exception $e) {
            // Handle exception
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href='contact.html';</script>";
        }
    }

    // Retrieve form data safely
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    $SenderName = "SchoolDream Plus";

    // Validate form data
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='contact.html';</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address.'); window.location.href='contact.html';</script>";
        exit;
    }

    // You can set the recipient email here
    $recipientEmail = "tripledeveloper2021@gmail.com";
    $emailSubject = "Confirmation of your Enquiry";
    $emailMessage = "Dear Customer,<br><br>We have received your enquiry and we are going to process it.";

    // Call the sendEmail function
    sendEmail($recipientEmail, $emailSubject, $emailMessage, $SenderName);
}
?>
