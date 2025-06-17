<?php

use Core\Render;
use Core\Validator;
use Auth\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '../../../../vendor/autoload.php';
class ForgetPassword extends Render
{

    public function index()
    {
        $errors = [];
        if (!empty($_POST) && isset($_POST['email'])) {
            $val = new Validator($_POST);
            $val->setRules([
                'email' => ['required', 'email'],
            ]);
            if ($val->has_error()) {
                $errors = $val->errors;
            } else {
                $user = new User();
                $res =  $user->fetchByValue(
                    table: 'users',
                    where: 'email = :email',
                    data: ['email' => $_POST['email']]
                );
                if ($res) {
                   
                    // Generate token and expiration
                    $token = bin2hex(random_bytes(32));
                    $expires = date('Y-m-d H:i:s', time() + 1800); // expires in 30 minutes
                   
                    // Save token and expiration in DB
                    $user->update_user_by_id($res->id, [
                        'reset_token' => $token,
                        'reset_expires' => $expires,
                    ]);

                    $this->sendResetLink($res->email, $token);
                    flashMessage('success', 'Check your email for password reset instructions.');
                } else {
                    flashMessage(mode: 'danger', msg: 'Email not found.');
                    $errors['general'] = ["User Email ({$_POST['email']}) not found."];
                }
            }
        }
        $this->render(path: 'auth/forget-password', useLayout: false, data: [
            'title' => 'Forget Password',
            'errors' => $errors
        ]);
    }
    private function sendResetLink($email, $token)
    {
        $resetLink = BASE_URL . "/reset-password?token=" . urlencode($token);
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mayadihno@gmail.com';
            $mail->Password   = 'xxmu rqwt vmih cxtc';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('mayadihno@gmail.com', 'E-Seller');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';

            $mail->Body = "<p>Click the link below to reset your password:</p><p><a href='{$resetLink}'>Reset Password</a></p>";
            $mail->AltBody = "Reset your password using this link: {$resetLink}";

            $mail->send();
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
        }
    }
}
