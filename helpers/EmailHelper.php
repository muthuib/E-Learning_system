<?php

namespace app\helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Yii;

class EmailHelper
{
    /**
     * Send email using PHPMailer
     * 
     * @param string $toEmail Recipient email
     * @param string $toName Recipient name
     * @param string $subject Email subject
     * @param string $body HTML email body
     * 
     * @return bool True if email sent successfully, false otherwise
     */
    public static function sendEmail($toEmail, $toName, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'benmuthui98@gmail.com'; // Your SMTP username
            $mail->Password = 'wzlp bfwf scgl yide'; // Your SMTP password (App Password for Gmail)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // TCP port to connect to

            // Set email format to HTML
            $mail->setFrom('info@roundtech.com', 'Roundtech Solutions');
            $mail->addAddress($toEmail, $toName); // Add recipient

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Send the email
            if ($mail->send()) {
                return true;
            } else {
                Yii::error("Failed to send email: {$mail->ErrorInfo}");
                return false;
            }
        } catch (Exception $e) {
            Yii::error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}
