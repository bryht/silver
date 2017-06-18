<?php

namespace app\control;

use app\model\UserModel;

class LoginControl extends \core\Control
{
    public function __construct($foo = null)
    {

    }

    public function register($para)
    {
        if (empty($para)) {
            $this->assign('message', '');
            $this->display('register.html');
        } else {
            $check = UserModel::instance()->checkRegister($para['name'], $para['mail']);
            if ($check == true) {
                $this->assign('message', 'User or Mail alerady exist!');
                $this->display('register.html');
                return;
            }

            $res = UserModel::instance()->insertObj($para);
            if ($res > 0) {
                $this->assign('message', 'Register success!');
                $this->display('register.html');
            }
        }
    }

    public function forgetPassword($value = '')
    {
        $this->display('user-forget-password.html');
    }

    public function getPasswordBack($value = '')
    {
        $mailTo = $value['mail'];
        $mail = new \PHPMailer\PHPMailer\PHPMailer;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );
        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = 'smtp-mail.outlook.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'service_bryht@outlook.com'; // SMTP username
        $mail->Password = 'Bb123456'; // SMTP password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted STARTTLS
        $mail->Port = 587; // TCP port to connect to

        $mail->setFrom('service_bryht@outlook.com', 'Silver');
        $mail->addAddress($mailTo, 'User'); // Add a recipient

        $mail->isHTML(true); // Set email format to HTML

        $mail->Subject = 'Passsword Change';
        $mail->Body = 'This is your new password <b>in bold!</b>';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }

    }

    public function login($para)
    {
        if (empty($para)) {
            $this->display('login.html');
        } else {

            $res = UserModel::instance()->checkUser($para['email'], $para['password']);
            if ($res != false) {
                session_set('user_id', $res['id']);
                session_set('user_name', $res['name']);
                session_set('user_auth', $res['auth']);
                //Notice: get the default album for the login user.
                $albumRes = \app\model\AlbumModel::instance()->getAlbumsByUserId($res['id']);
                if (count($albumRes) > 0) {
                    $albumId = $albumRes[0]['id'];
                } else {
                    $albumId = -1;
                }
                $this->redirect('index', 'index', ['album_id' => $albumId]); //default is main category
            } else {
                $this->display('login.html');
            }
        }
    }

    public function logout()
    {
        if (!session_id()) {
            session_start();
        }
        session_destroy();
        $this->redirect('login', 'login');
    }

}
