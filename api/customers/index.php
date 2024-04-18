<?php
// Подключение к базе данных
$host = 'localhost';
$db = 'your_database';
$user = 'your_username';
$pass = 'your_password';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
} catch (PDOException $e) {
    die("Unable to connect to database: " . $e->getMessage());
}

// Логика получения email текущего пользователя
// Предположим, что пользователь уже аутентифицирован и его токен сессии передан в заголовке запроса

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Проверяем наличие заголовка с токеном сессии
    if (!isset($_SERVER['HTTP_SESSION_TOKEN'])) {
        http_response_code(401);
        echo json_encode(["message" => "Unauthorized"]);
        exit();
    }

    // Получаем ID пользователя по токену сессии
    $sessionToken = $_SERVER['HTTP_SESSION_TOKEN'];
    $stmt = $dbh->prepare("SELECT user_id FROM sessions WHERE session_token = :session_token");
    $stmt->bindParam(':session_token', $sessionToken);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $userId = $row['user_id'];

    // Получаем email пользователя по его ID
    $stmt = $dbh->prepare("SELECT email FROM customers WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $userEmail = $row['email'];

    // Возвращаем email текущего пользователя
    http_response_code(200);
    echo json_encode(["email" => $userEmail]);
    exit();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit();
}
?>
