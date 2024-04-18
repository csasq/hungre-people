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

// Логика создания сессии
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из тела запроса
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Проверяем наличие электронной почты и пароля в запросе
    if (!isset($requestData['email']) || !isset($requestData['password'])) {
        http_response_code(400);
        echo json_encode(["message" => "Missing email or password"]);
        exit();
    }

    // Проверяем правильность электронной почты и пароля (реализуйте эту логику сами)

    // Если аутентификация прошла успешно, создаем сессию
    $userEmail = $requestData['email'];
    $sessionId = uniqid();
    $userId = 1; // Здесь должна быть логика получения ID пользователя из базы данных

    // Вставляем данные сессии в таблицу
    $stmt = $dbh->prepare("INSERT INTO sessions (user_id, session_token) VALUES (:user_id, :session_token)");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':session_token', $sessionId);
    $stmt->execute();

    // Возвращаем токен сессии
    http_response_code(200);
    echo json_encode(["session_token" => $sessionId]);
    exit();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit();
}
?>
