<?php

// подключение к БД
$conn = mysqli_connect("localhost", "ck004753_gurman", "admin", "ck004753_gurman");

if (!$conn) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Функция для получения данных по интервалу
function getOrdersByShift($start_date, $end_date, $conn) {
    // SQL-запрос с группировкой по названию позиции
    $sql = "SELECT 
                name, 
                SUM(price * count) as total_price, 
                SUM(count) as total_count
            FROM orders
            WHERE created_at BETWEEN '$start_date' AND '$end_date'
            GROUP BY name";
    
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'name' => $row['name'],
                'count' => $row['total_count'],
                'total_price' => $row['total_price']
            ];
        }
        return $data;
    }
    return [];
}

// Функция для сброса счетчика
function resetCount($conn) {
    $sql = "UPDATE orders SET count = 0 WHERE count >= 999";
    mysqli_query($conn, $sql);
}

// Пример использования
$start_date = '2025-12-01 22:00:00';
$end_date = '2025-12-02 10:00:00';

// Получаем данные
$orders = getOrdersByShift($start_date, $end_date, $conn);

// Сбрасываем счетчик
resetCount($conn);

// Формируем JSON
header('Content-Type: application/json');
echo json_encode($orders, JSON_UNESCAPED_UNICODE);

mysqli_close($conn);
?>

// подключение к БД
// $conn = mysqli_connect("localhost", "ck004753_gurman", "admin", "ck004753_gurman");
// if ($conn === false) {
//   die("Ошибка: " . mysqli_connect_error());
// }

// $users = [
//     ['Свиная Биг', 300, 1],
// ];
// // запрос нескольких позиций или одной
// if(count($users) === 1) {
//     $name = mysqli_real_escape_string($conn, $users[0][0]); 
//     $price = (int)$users[0][1];
//     $count = (int)$users[0][2];
    
//     $sql = "INSERT INTO gurman (name, price, count) VALUES ('{$name}', {$price}, {$count});";
    
//     if (mysqli_query($conn, $sql)) {
//         echo 'Запись успешно добавлена.';
//     } else {
//         echo "Ошибка при добавлении записи: " . mysqli_error($conn);
//     }
// } else {
//     foreach ($users as $user_data) {
//         $name = mysqli_real_escape_string($conn, $user_data[0]); // Экранируем строку
//         $price = (int)$user_data[1]; // Приводим к числу
//         $count = (int)$user_data[2]; // Приводим к числу
        
//         // Добавляем INSERT запрос для текущих данных
//         $sql .= "INSERT INTO gurman (name, price, count) VALUES ('{$name}', {$price}, {$count});\n";
//     }

//     if(mysqli_multi_query($conn, $sql)) {
//         echo 'Dates added';
//     }else{
//         echo "Ошибка: ";
//     }
// }
// mysqli_close($conn);
?>