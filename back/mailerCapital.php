<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email         = trim($_POST['email'] ?? '');
    $name          = trim($_POST['name'] ?? '');
    $event_name    = trim($_POST['event_name'] ?? '');
    $event_time    = trim($_POST['event_time'] ?? '');
    $event_place   = trim($_POST['event_place'] ?? '');
    $event_link    = trim($_POST['event_link'] ?? '');
    $event_page    = trim($_POST['event_page'] ?? '');
    $mail = new PHPMailer(true);

    $template_path = __DIR__ . '/event_msg_tpl2.php';
    if (!file_exists($template_path)) {
        error_log("Шаблон не найден: $template_path");
        echo json_encode(['success' => false, 'message' => 'Ошибка: шаблон письма недоступен']);
        exit;
    }

    ob_start();
    include $template_path;
    $body = ob_get_clean();

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.timeweb.ru';
        $mail->SMTPAuth = true;
        $mail->Username = 'marketing@aq-capital.ru';
        $mail->Password = '9qqupe18n3';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('marketing@aq-capital.ru', 'АГ Капитал');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Ваша регистрация принята! ' . $event_name;
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Сообщение успешно отправлено']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Ошибка отправки: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Неверный метод запроса test']);
}
?>
