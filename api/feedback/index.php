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

// Логика обработки обращения
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из тела запроса
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Проверяем наличие всех необходимых данных в запросе
    $requiredFields = ['name', 'email', 'phone', 'message'];
    foreach ($requiredFields as $field) {
        if (!isset($requestData[$field])) {
            http_response_code(400);
            echo json_encode(["message" => "Missing $field"]);
            exit();
        }
    }

    // Дополнительная валидация данных (например, проверка формата email и телефона)

    // Вставляем данные обращения в таблицу
    $stmt = $dbh->prepare("INSERT INTO feedback (name, email, phone, message) VALUES (:name, :email, :phone, :message)");
    $stmt->bindParam(':name', $requestData['name']);
    $stmt->bindParam(':email', $requestData['email']);
    $stmt->bindParam(':phone', $requestData['phone']);
    $stmt->bindParam(':message', $requestData['message']);
    $stmt->execute();

    // Возвращаем успешный ответ
    http_response_code(201);
    echo json_encode(["message" => "Feedback submitted successfully"]);
    exit();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit();
}
?>
