<?php
// --- КОНФИГУРАЦИЯ ---
$telegramBotToken = '8026306365:AAHsfEx44g2IuDOslBK0XEko3LNzXelKtZc'; // !!! ЗАМЕНИТЕ НА ВАШ API-ТОКЕН БОТА !!!
$telegramChatId = '@gurman_zakazi_bot';  

// --- Самая простая функция для формирования сообщения из массива ---
function formatSimpleArrayForTelegram($dataArray) {
    $message = "🚀 **Получен массив:**\n\n";

    // Если массив не пришел или пустой
    if (empty($dataArray)) {
        return $message . "<i>Массив пуст или некорректен.</i>";
    }

    // Перебираем массив и добавляем элементы в сообщение
    foreach ($dataArray as $key => $value) {
        // Если элемент - массив, рекурсивно обрабатываем или выводим как строку
        if (is_array($value)) {
            // Для простоты, просто преобразуем в строку, но можно сделать и рекурсивно
            $message .= "- [" . htmlspecialchars($key) . "] " . htmlspecialchars(print_r($value, true)) . "\n";
        } else {
            // Обычный элемент
            $message .= "- " . htmlspecialchars($value) . "\n";
        }
    }
    return $message;
}


// --- Основная часть PHP скрипта ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. ПРИНИМАЕМ ДАННЫЕ (JSON)
    $jsonInput = file_get_contents('php://input'); // Читаем сырой JSON
    $data = json_decode($jsonInput, true);        // Декодируем в PHP массив

    // Проверка: если JSON некорректный
    if ($data === null) {
        echo "❌ Ошибка: Некорректный JSON.";
        http_response_code(400); // Bad Request
        exit;
    }

    // Получаем наш массив по ключу 'myArray'
    $receivedArray = $data['myArray'] ?? null;

    // Простейшая проверка: если массив не пришел или пустой
    if ($receivedArray === null || empty($receivedArray)) {
        echo "❌ Ошибка: Массив не получен или пуст.";
        http_response_code(400);
        exit;
    }

    // 2. ФОРМИРУЕМ СООБЩЕНИЕ ДЛЯ TELEGRAM
    $telegramMessage = formatSimpleArrayForTelegram($receivedArray);


    // --- ОТПРАВКА В TELEGRAM ---
    // URL для отправки сообщения
    $url = "https://api.telegram.org/bot" . $telegramBotToken . "/sendMessage?chat_id=" . $telegramChatId . "&text=" . urlencode($telegramMessage) . "&parse_mode=HTML";

    // Максимально простая отправка через file_get_contents
    // @ подавляет вывод ошибок, если что-то пошло не так
    $response = @file_get_contents($url);

    // --- Обратная связь ---
    if ($response === FALSE) {
        echo "❌ Ошибка отправки в Telegram.";
        http_response_code(500);
    } else {
        echo "✅ Массив успешно отправлен в Telegram!";
    }

} else {
    // Если запрос не POST
    echo "❌ Используйте только POST запросы.";
    http_response_code(405); // Method Not Allowed
}