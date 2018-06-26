<?php
if($_POST['email']){ // если робот
	echo "Robot";
}else{ // если не робот

	// Доступы к CRM
	define('CRM_HOST', 'bitrix.urbanstroi.by'); // your CRM domain name
	define('CRM_PORT', '443'); // CRM server port
	define('CRM_PATH', '/crm/configs/import/lead.php'); // CRM server REST service path
	define('CRM_PATH_SUBSCRIBE', '/crm/configs/import/post.php'); // CRM server REST service path for subscribe
	define('CRM_LOGIN', 'createLead@urbanstroi.by'); // login of a CRM user able to manage leads
	define('CRM_PASSWORD', 'D3y5}VMY'); // password of a CRM user
	$address = "info@bildin.by"; // Почта на которую отправляем письмо

	// Получаем поля
	if (isset($_POST['title'])) {$title = $_POST['title'];} //заголовок формы
	if (isset($_POST['name'])) {$name = $_POST['name'];} //имя
	if (isset($_POST['tel'])) {$tel = $_POST['tel'];} // телефон
	if (isset($_POST['mail'])) {$mail = $_POST['mail'];} // email
	if (isset($_POST['que'])) {$que = $_POST['que'];} // сообщение
	if (isset($_POST['site'])) {$site = $_POST['site'];} // с какого сайта
	if (isset($_POST['size'])) {$size = 'Размер товара: '.$_POST['size'];} // размер товара
	if (isset($_POST['subscribe'])) { // подписка
		$subscribe = 'Подписка оформлена';
	} else {
		$subscribe = 'Отказ от подписки';
	};

	// Записываем поля
	$postData = array(
		'TITLE' => 'Лид с сайта: '.$site,
		'NAME' => $name,
		'EMAIL_WORK' => $mail,
		'PAGE' => $site,
		'PHONE_WORK' => $tel,
		'COMMENTS' => $que.'<br>'.$size.'<br>'.$subscribe,
		'SOURCE_ID' => 'WEB',
		'FORM_TYPE' => $title,
		'STATUS_DESCRIPTION' => $site.' '.$title
	);

	// Записываем поля для подписчиков
	$postDataSubscribe = array(
		'NAME' => $name,
		'EMAIL' => $mail,
		'FORM_TYPE' => $title,
		'PAGE' => $site,
	);

	// Авторизация
	$postData['LOGIN'] = CRM_LOGIN;
	$postData['PASSWORD'] = CRM_PASSWORD;
	$postDataSubscribe['LOGIN'] = CRM_LOGIN;
	$postDataSubscribe['PASSWORD'] = CRM_PASSWORD;

	// Текст письма
	$mes = "Лид с сайта: $site<br>Имя: $name<br>Телефон: $tel<br>Email: $mail<br>Сообщение: $que<br>$size<br>$subscribe";

	// Отправляем письмо
	// подписанных на urbsmarketing@gmail.com
	$send = mail ($address,$name,$mes,"Content-type:text/html; charset = UTF-8\r\nFrom:zajavka@bildin.by");


	// Отправка лида
	// $fp = fsockopen("ssl://".CRM_HOST, CRM_PORT, $errno, $errstr, 30);
	// if ($fp){
	// 	// Готовим данные
	// 	$strPostData = '';
	// 	foreach ($postData as $key => $value)
	// 		$strPostData .= ($strPostData == '' ? '' : '&').$key.'='.urlencode($value);

	// 	// Готовим заголовки
	// 	$str = "POST ".CRM_PATH." HTTP/1.0\r\n";
	// 	$str .= "Host: ".CRM_HOST."\r\n";
	// 	$str .= "Content-Type: application/x-www-form-urlencoded\r\n";
	// 	$str .= "Content-Length: ".strlen($strPostData)."\r\n";
	// 	$str .= "Connection: close\r\n\r\n";

	// 	$str .= $strPostData;

	// 	// Отправляем данные в CRM
	// 	fwrite($fp, $str);

	// 	// Получаем заголовки из CRM
	// 	$result = '';
	// 	while (!feof($fp))
	// 	{
	// 		$result .= fgets($fp, 128);
	// 	}
	// 	fclose($fp);

	// 	// Вырезаем заголовки ответа
	// 	$response = explode("\r\n\r\n", $result);

	// 	// Отправка подписчика
	// 	if (isset($_POST['subscribe'])){
	// 		// Готовим данные
	// 		$strPostDataSubscribe = '';
	// 		foreach ($postDataSubscribe as $key => $value)
	// 			$strPostDataSubscribe .= ($strPostDataSubscribe == '' ? '' : '&').$key.'='.urlencode($value);

	// 		// Готовим заголовки
	// 		$strs = "POST ".CRM_PATH_SUBSCRIBE." HTTP/1.0\r\n";
	// 		$strs .= "Host: ".CRM_HOST."\r\n";
	// 		$strs .= "Content-Type: application/x-www-form-urlencoded\r\n";
	// 		$strs .= "Content-Length: ".strlen($strPostDataSubscribe)."\r\n";
	// 		$strs .= "Connection: close\r\n\r\n";

	// 		$strs .= $strPostDataSubscribe;

	// 		// Отправляем данные в CRM
	// 		fwrite($fps, $strs);

	// 		// Получаем заголовки из CRM
	// 		$results = '';
	// 		while (!feof($fps))
	// 		{
	// 			$results .= fgets($fps, 128);
	// 		}
	// 		fclose($fps);

	// 		// Вырезаем заголовки ответа
	// 		$responses = explode("\r\n\r\n", $results);
	// 	}
	// //}else{
	// 	//echo 'не получилось!';
	// };
	echo 'OK';
};
?>
