<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST["phone"]));
    $message = strip_tags(trim($_POST["message"]));

    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        http_response_code(400);
        echo "Por favor preencha todos os campos.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Email inválido.";
        exit;
    }

    $email_content = "Nome: $name\nEmail: $email\nTelefone: $phone\nMensagem:\n$message\n";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.ethereal.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'marcella.hand@ethereal.email';
        $mail->Password = 'hVQYYPf6HGDGcDQWnW';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('marcella.hand@ethereal.email', 'Site');
        $mail->addAddress('isamaracostamaia@gmail.com');

        $mail->Subject = 'Novo contacto do site';
        $mail->Body = $email_content;

        $mail->send();
        echo "Formulário submetido com sucesso!";
    } catch (Exception $e) {
        http_response_code(500);
        echo "Erro ao enviar a mensagem: {$mail->ErrorInfo}";
    }

} else {
    http_response_code(403);
    echo "Erro: método inválido.";
}
?>
