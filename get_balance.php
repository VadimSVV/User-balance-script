<?php 

require_once 'dbconnection.php';
require_once 'constants.php';

//Проверка наличия параметра user_id в URL
if (!isset($_GET['USER_ID_PARAM'])) {
    // Ошибка, если параметр отсутствует
    echo json_encode(array('error'=> 'Missing user_id parameter'));
    exit;
}

// Получение значения параметра user_id
$user_id = $_GET['USER_ID_PARAM'];

// Параметры подключения к базе данных
$host = 'database_host';
$dbname = 'database_name';
$username = 'database_username';
$password = 'database_password';

try {
    // Соединение с базой данных
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // SQL-запрос для получения баланса пользователя
    $query = "SELECT SUM(amount) AS balance FROM transactions WHERE paid_by = :user_id OR paid_to = :user_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Запрос
    $statement->execute();

    //Получение результата
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    //Проверка наличия результата
    if ($result) {
        //Баланс пользователя
        echo json_encode(['balance' => $result['balance']]);
        } else {
            echo json_encode(['error'=> 'User not found']);
        }
} catch (PDOException $e) {
    //Ошибка при возникновении исключения
    echo json_encode(['error'=> $e->getMessage()]);
}
?>
