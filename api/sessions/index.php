<?php

require '/usr/local/etc/hungre-people.csasq.ru/config.php';

function post($data) {
    try {
        global $config;
        $connection = new PDO(
            $config['db:coninfo'],
            $config['db:username'],
            $config['db:password'],
        );
        $cursor = $connection->prepare('select id from users where email_address = :email_address and password_hash = sha(:password);');
        $cursor->bindValue(':email_address', $data['email_address']);
        $cursor->bindValue(':password', $data['password']);
        $cursor->execute();
        $user_id = $cursor->fetch()['id'];
        $access_token = random_bytes(32);
        $cursor = $connection->prepare('insert into sessions (user_id, access_token) values (:user_id, :access_token);');
        $cursor->bindValue(':user_id', $user_id);
        $cursor->bindValue(':access_token', $access_token);
        $cursor->execute();
        setcookie(
            'access_token',
            bin2hex($access_token),
            array(
                'path' => '/',
                'secure' => true,
                'httponly' => false,
            ),
        );
    } catch (PDOException $exception) {
        http_response_code(400);
    }
}

function delete($data) {
    try {
        global $config;
        $connection = new PDO(
            $config['db:coninfo'],
            $config['db:username'],
            $config['db:password'],
        );
        $cursor = $connection->prepare('delete from sessions where access_token = :access_token;');
        $cursor->bindValue(':access_token', hex2bin($data['access_token']));
        $cursor->execute();
        setcookie(
            'access_token',
            null,
            array(
                'path' => '/',
                'secure' => true,
                'httponly' => false,
            ),
        );
    } catch (PDOException $exception) {
        http_response_code(400);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']))
    switch ($_POST['method']) {
        case 'POST': post($_POST); break;
        case 'DELETE': delete($_POST); break;
    }
