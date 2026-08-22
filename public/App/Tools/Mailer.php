<?php

namespace App\Tools;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer
{

	public function sendAccessCode($toEmail, $toName, $accessCode, $loginUrl)
	{

		if (empty($toEmail) || empty($_ENV['SMTP_HOST'])) {
			return false;
		}

		try {

			$mail = new PHPMailer(true);

			$mail->isSMTP();
			$mail->CharSet = 'UTF-8';
			$mail->Timeout = 10;
			$mail->Host = $_ENV['SMTP_HOST'];
			$mail->Port = $_ENV['SMTP_PORT'] ?? 587;
			$mail->SMTPAuth = true;
			$mail->Username = $_ENV['SMTP_USER'] ?? '';
			$mail->Password = $_ENV['SMTP_PASSWORD'] ?? '';
			$mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'] ?? PHPMailer::ENCRYPTION_STARTTLS;

			$mail->setFrom($_ENV['SMTP_FROM_EMAIL'] ?? $_ENV['SMTP_USER'], $_ENV['SMTP_FROM_NAME'] ?? 'Exitus');
			$mail->addAddress($toEmail, $toName);

			$mail->isHTML(true);
			$mail->Subject = 'Seu acesso ao sistema Exitus';
			$mail->Body = "
				<p>Olá, <strong>{$toName}</strong>!</p>
				<p>Seu cadastro no sistema Exitus foi realizado com sucesso. Use os dados abaixo para acessar:</p>
				<p>Código de acesso: <strong>{$accessCode}</strong></p>
				<p><a href=\"{$loginUrl}\">Clique aqui para acessar o sistema</a></p>
			";
			$mail->AltBody = "Olá, {$toName}! Seu código de acesso ao sistema Exitus é: {$accessCode}. Acesse em: {$loginUrl}";

			$mail->send();

			return true;
		} catch (\Throwable $e) {

			error_log('Falha ao enviar e-mail de acesso: ' . $e->getMessage());

			return false;
		}
	}
}
