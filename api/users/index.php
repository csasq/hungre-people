<?php

require '/usr/local/etc/hungre-people.csasq.ru/config.php';

function post ($data) {
    try {
        global $config;
        $connection = new PDO(
            $config['db:coninfo'],
            $config['db:username'],
            $config['db:password'],
        );
        $cursor = $connection->prepare('insert into users (email_address, password_hash) values (:email_address, sha(:password));');
        $cursor->bindValue(':email_address', $data['email_address']);
        $cursor->bindValue(':password', $data['password']);
        $cursor->execute();
    } catch (PDOException $exception) {
        http_response_code(400);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method']))
    switch ($_POST['method']) {
        case 'POST': post($_POST); break;
    }
