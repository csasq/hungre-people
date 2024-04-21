<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '/opt/phpmailer/src/PHPMailer.php';
require '/opt/phpmailer/src/Exception.php';
require '/opt/phpmailer/src/SMTP.php';

require '/usr/local/etc/hungre-people.csasq.ru/config.php';

function post ($data) {
    try {
        global $config;
        $connection = new PDO(
            $config['db:coninfo'],
            $config['db:username'],
            $config['db:password'],
        );
        $cursor = $connection->prepare(<<< EOF
        insert into feedback (
            name,
            email_address,
            phone_number,
            message
        ) values (
            :name,
            :email_address,
            :phone_number,
            :message
        );
        EOF);
        $cursor->bindValue(':name', $data['name']);
        $cursor->bindValue(':email_address', $data['email_address']);
        $cursor->bindValue(':phone_number', $data['phone_number']);
        $cursor->bindValue(':message', $data['message']);
        $cursor->execute();

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->Host = $config['smtp:hostname'];
        $mail->SMTPAuth = true;
        $mail->Username = $config['smtp:username'];
        $mail->Password = $config['smtp:password'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom($config['smtp:username'], $config['smtp:name']);
        $mail->addAddress($config['smtp:username'], $config['smtp:name']);
        $mail->Subject = 'New Feedback Request';
        $mail->Body = join(
            '<br />',
            array(
                'Name: ' . $data['name'],
                'Email Address: ' . $data['email_address'],
                'Phone Number: ' . $data['phone_number'],
                'Message: ' . $data['message'],
            ),
        );
        $mail->send();
    } catch (PDOException $exception) {
        http_response_code(400);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']))
    switch ($_POST['method']) {
        case 'POST': post($_POST); break;
    }
