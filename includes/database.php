<?php
if(preg_match('/database.php/', $_SERVER['SCRIPT_NAME'])) { 
  header('Location: ../');
}

// Връзка с базата данни
$host   =   "localhost"; // Хост, подразбиране localhost
$root   =   "testing"; // Името на потребителя
$pass   =   "testing"; // Парола
$db     =   "testing"; // Името на базата данни

$conn = mysqli_connect("$host","$root","$pass","$db"); // Свързваме се към базата данни

mysqli_set_charset($conn, "UTF8"); // За всеки случай да сложим кодировка UTF8

// Проверяваме връзката с базата данни
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Настройки на системата
$siteName = "Clout"; // Името на сайта
$forum_path = "forums/"; // В коя папка се намира phpBB
$paypal_email = "impossiblelimner@gmail.com";

$expire_ads = 604800; // След колко дни да изтичат рекламите, по-начало 7 дни. (epoch)

$servID1 = 24796; // 10 кредита
$servID2 = 24796; // 20 кредита
$servID3 = 24796; // 40 кредита
$servID4 = 24796; // 60 кредита

$info1 = "Изпрати SMS с текст блабла на номер 1091 (1,20 лв. с ддс)"; 
$info2 = "Изпрати SMS с текст блабла на номер 1092 (2,40 лв. с ддс)";
$info3 = "Изпрати SMS с текст блабла на номер 1094 (4,80 лв. с ддс)";
$info4 = "Изпрати SMS с текст блабла на номер 1096 (6,00 лв. с ддс)";

// Колко кредита да дава
$credits1 = 10;
$credits2 = 20;
$credits3 = 40;
$credits4 = 60;

$tombola_credits = 20; // Колко кредита да дава при спечелена томбола
$tombola_posts = 10; // Колко мнения трябва да има потребител, за да играе в томболата

$sms_vip_price  = 20;
$sms_admin_price  = 60;
$sms_nickname_price = 10;
$smsnick_credits  = 50;
$sms_88x31 = 10;
$sms_468x60 = 20;

$timehook = time();

$accessvip = "abipj"; // Какви флагове да дава
$daysvip = 30; // За колко време ще са
$expiredvip = time() + ($daysvip * 24 * 60 * 60); // От кога до кога ще са правата

$accessadmin ="abcdejniup"; // Какви флагове да дава
$daysadmin = 30; // За колко време ще са
$expiredadmin = time() + ($daysadmin * 24 * 60 * 60); // От кога до кога ще са правата

$accessnick = "z"; // Какви права да дава
$daysnick = 30; // колко дни
$expirednick = time() + ($daysnick * 24 * 60 * 60); // От кога до кога ще са правата

$ashowin = 0; // Дали да се показва в страницата на админите в CS:Bans
$nameflags = "a"; // Даваме правата по име

$ip_u = $_SERVER['REMOTE_ADDR'];

$custom1 = '';
$static1 = 'no';