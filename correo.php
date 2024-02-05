<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar los campos del formulario
    if (empty($_POST['name']) || empty($_POST['msg']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(500);
        exit();
    }

    // Obtener datos del formulario y sanearlos
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
   
    $message = htmlspecialchars($_POST['msg']);

    // Configuración de PHPMailer
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.zoho.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'davidhuaman@davidh.tech';
    $mail->Password = 'Geyda.20';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configurar remitente y destinatario para Zoho
    $mail->setFrom('davidhuaman@davidh.tech', 'david');
    $mail->addAddress('davidhuaman@davidh.tech'); // Correo de Zoho

    // Configurar contenido del mensaje para Zoho
    $mail->isHTML(true);
   
    $mail->Body = "Has recibido un nuevo mensaje desde el formulario de contacto de tu sitio web.<br><br>Detalles:<br><br>Nombre: $name<br>Email: $email<br>Mensaje: $message";

    try {
        // Enviar correo a Zoho
        $mail->send();

        // Enviar correo de agradecimiento al usuario
        $mail->clearAddresses();
        $mail->addAddress($email);
        $mail->Subject = "Gracias por ponerte en contacto";
        $mail->Body = "¡Gracias por ponerte en contacto con nosotros, $name!<br><br>Hemos recibido tu mensaje y nos pondremos en contacto contigo pronto.<br><br><br>Mensaje: $message";
        $mail->send();

        echo "Mensaje enviado correctamente";
    } catch (Exception $e) {
        http_response_code(500);
        exit();
    }
} else {
    // Redirigir si no es una solicitud POST
    header("Location: contact.html");
exit();
}
?>


