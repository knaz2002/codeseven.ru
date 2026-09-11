<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email         = trim($_POST['mail'] ?? '');
    $timestamp     = $_POST['timestamp'] ?? time();
    $formatted_date = date('d.m.Y H:i:s', $timestamp);
    $mail = new PHPMailer(true);


    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.timeweb.ru';
        $mail->SMTPAuth = true;
        $mail->Username = 'marketing@aq-capital.ru';
        $mail->Password = 's0h3PxYh{lr*}#';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('marketing@aq-capital.ru', 'АКГ «Капитал»');
        $mail->addAddress('marketing@ag-capital.ru');

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Подписка на сайте  АКГ «Капитал»';

        // Формируем HTML-тело письма
        $mail->Body = "
        <html>
        <head>
            <title>Подписка на сайте  АКГ «Капитал»</title>
        </head>
        <body>
            <h2>Подписка на сайте  АКГ «Капитал»</h2>
            <p>Здравствуйте,</p>
            <p>На сайте osnova.capital клиент оформил подписку на рассылку в адрес:</p>
            <p><strong>Email:</strong> " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "</p>
            <p><strong>Время подписки:</strong> $formatted_date</p>
        </body>
        </html>
        ";

        // Формируем альтернативное тело письма в виде обычного текста
        $mail->AltBody = "Подписка на сайте  АКГ «Капитал»\n\nEmail: $email\nВремя подписки: $formatted_date";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Сообщение успешно отправлено']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Ошибка отправки: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Неверный метод запроса']);
}
?>