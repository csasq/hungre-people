<?php

require '/usr/local/etc/hungre-people.csasq.ru/config.php';

function get($data) {
    try {
        global $config;
        $connection = new PDO(
            $config['db:coninfo'],
            $config['db:username'],
            $config['db:password'],
        );
        $cursor = $connection->prepare('select title, caption, prise, priority from menu where category = :category limit 21;');
        $cursor->bindValue(':category', $data['category']);
        $cursor->execute();
        $menu = $cursor->fetchAll();
        echo json_encode($menu);
    } catch (PDOException $exception) {
        http_response_code(400);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['category']))
    get($_GET);
