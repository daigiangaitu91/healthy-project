<?php

namespace common\base;

use common\models\settings\EmailSetting;
use Exception;
use Yii;
use yii\web\Application;

/**
 * Class Mailer
 *
 * @package common\base
 */
class Mailer{

	/**
	 * @param array|string $to
	 * @param string $subject
	 * @param string $body_html
	 * @param string $body_plain
	 * @param null $attachment
	 * @param string $reply_to
	 * @param array $ccs
	 * @param array $bccs
	 *
	 * @return bool
	 */
	public static function send(
		$to,
		$subject,
		$body_html,
		$body_plain = '',
		$attachment = NULL,
		$reply_to = '',
		$ccs = [],
		$bccs = []){

		try{

			$subject = str_replace(['[site:name]', '[site:url]'],
				[Yii::$app->name, Yii::$app->urlManager->createAbsoluteUrl([''])], $subject);

			$body_html = str_replace(['[site:name]', '[site:url]'],
				[Yii::$app->name, Yii::$app->urlManager->createAbsoluteUrl([''])], $body_html);

			$setting = new EmailSetting();
			$setting->getValues();

			/**@var \yii\swiftmailer\Mailer $mailer */
			$mailer = Yii::$app->mailer;
			$mailer->setTransport([
				'class'      => 'Swift_SmtpTransport',
				'host'       => $setting->email_smtp_server,
				'username'   => $setting->email_smtp_username,
				'password'   => $setting->email_smtp_password,
				'port'       => $setting->email_smtp_port,
				'encryption' => $setting->email_smtp_protocol,
			]);

			$mailer = $mailer->compose()
			                 ->setFrom([$setting->email_sender => $setting->email_sender_name])
			                 ->setTo($to)
			                 ->setSubject($subject)
			                 ->setTextBody($body_plain)
			                 ->setHtmlBody($body_html);

			if (!empty($reply_to)){
				$mailer->setReplyTo($reply_to);
			}

			if (!empty($ccs)){
				$mailer->setCc($ccs);
			}

			if (!empty($bccs)){
				$mailer->setBcc($bccs);
			}

			if (!empty($attachment)){
				if (!is_array($attachment)){
					$attachment = [$attachment];
				}

				foreach ($attachment as $attach){
					if (!empty($attach['content'])){
						$content = $attach['content'];
						unset($attach['content']);
						$mailer->attachContent($content, $attach);
					}else{
						$mailer->attach($attach);
					}
				}
			}

			return $mailer->send();

		}catch (Exception $e){
			Yii::error($e->getMessage(), __METHOD__);
			if (Yii::$app instanceof Application){
				Yii::$app->getSession()->setFlash('error', 'System can\'t send out email.');
			}
		}

		return FALSE;
	}

}