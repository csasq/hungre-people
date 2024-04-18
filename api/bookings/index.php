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

// Логика бронирования столика
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из тела запроса
    $requestData = json_decode(file_get_contents('php://input'), true);

    // Проверяем наличие всех необходимых данных в запросе
    $requiredFields = ['name', 'email', 'phone', 'num_persons', 'booking_datetime'];
    foreach ($requiredFields as $field) {
        if (!isset($requestData[$field])) {
            http_response_code(400);
            echo json_encode(["message" => "Missing $field"]);
            exit();
        }
    }

    // Дополнительная валидация данных (например, проверка формата email и телефона)

    // Вставляем данные бронирования в таблицу
    $stmt = $dbh->prepare("INSERT INTO bookings (user_id, name, email, phone, num_persons, booking_datetime) VALUES (:user_id, :name, :email, :phone, :num_persons, :booking_datetime)");
    $stmt->bindParam(':user_id', $userId); // Предположим, что ID пользователя доступен после аутентификации
    $stmt->bindParam(':name', $requestData['name']);
    $stmt->bindParam(':email', $requestData['email']);
    $stmt->bindParam(':phone', $requestData['phone']);
    $stmt->bindParam(':num_persons', $requestData['num_persons']);
    $stmt->bindParam(':booking_datetime', $requestData['booking_datetime']);
    $stmt->execute();

    // Возвращаем успешный ответ
    http_response_code(201);
    echo json_encode(["message" => "Booking created successfully"]);
    exit();
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method Not Allowed"]);
    exit();
}
?>
