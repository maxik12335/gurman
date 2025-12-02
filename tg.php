<?php
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