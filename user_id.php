<?php 

//Проверяю наличие параметра user_id в URL
if (!isset($_GET['user_id'])) {
    // Возвращаю ошибку, если параметр отсутствует
    echo json_encode(array('error'=> 'Missing user_id parameter'));
    exit;
}

// Получаю значение параметра user_id
$user_id = $_GET['user_id'];

// Устанавливаю параметры подключения к базе данных
$host = 'database_host';
$dbname = 'database_name';
$username = 'database_username';
$password = 'database_password';

try {
    // Устанавливаю соединение с базой данных
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Подготавливаю SQL-запрос для получения баланса пользователя
    $query = "SELECT SUM(amount) AS balance FROM transactions WHERE paid_by = :user_id OR paid_to = :user_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Выполняю запрос
    $statement->execute();

    //Получаю результат
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    //Проверяю наличие результата
    if ($result) {
        //Возвращаю баланс пользователя
        echo json_encode(['balance' => $result['balance']]);
        } else {
            echo json_encode(['error'=> 'User not found']);
        }
} catch (PDOException $e) {
    //Возвращаю ошибку при возникновении исключения
    echo json_encode(['error'=> $e->getMessage()]);
}
?>
