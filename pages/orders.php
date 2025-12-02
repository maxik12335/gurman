<?php
// подключение к БД
$conn = mysqli_connect("localhost", "ck004753_gurman", "admin", "ck004753_gurman");
if ($conn === false) {
  die("Ошибка: " . mysqli_connect_error());
}

$sql = "SELECT * FROM Users";

mysqli_close($conn);