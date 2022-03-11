<?php
include("db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$nIdEvent = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */

$sSQL = "Select * FROM events Where id = $nIdEvent Limit 1";
$crsEvent = mysqli_query($link, $sSQL);
if ($rowEvent = mysqli_fetch_array($crsEvent)) {
  $nHouseId = $rowEvent["id_house"];
  $sSQL = "Select * FROM users Where id_house = $nHouseId";

  $crsUser = mysqli_query($link, $sSQL);

  // To send HTML mail, the Content-type header must be set
  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers .= 'From: site' . "\r\n";

  while ($rowUser = mysqli_fetch_array($crsUser)) {
    $message = '
  <html>
  <head>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title> Голосование на сайте UpravDom.ru</title>
  </head>
  <body>
    <h3>Здравствуйте, '.$rowUser["name"].'!</h3>
    <p>Уведомляем Вас о том, что с '.$rowEvent["dt_start"].' по '.$rowEvent["dt_finish"].' на сайте UpravDom.ru среди собственников Вашего дома пройдет голосование на тему "'.$rowEvent["name"].'".</p>
    <p>Вход в личный кабинет: <a href=\"http://h106798759.nichost.ru/vote\">http://h106798759.nichost.ru/vote</a></p>
    <p>Ваш логин: <b>'.$rowUser["login"].'</b>.</p>
    <p>Предлагаем принять участие в голосовании!</p>

  </body>
  </html>';

    $cSelfMail = $rowUser["login"];

    if (!mail($cSelfMail, "Голосование на сайте UpravDom.ru", $message, $headers))
      echo 'Что-то пошло не так... Письмо не отправлено!!!';
    else
      echo 'Письмо отослано успешно!!!';

    }
}
?>
