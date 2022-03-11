<?php
include("db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$nIdRecord = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */

$sSQL = "Select * FROM users Where id =  $nIdRecord  Limit 1";

$crsUser = mysqli_query($link, $sSQL);
if ($rowUser = mysqli_fetch_array($crsUser)) {
 $message = '
<html>
<head>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> Регистрация на сайте UpravDom.ru</title>
</head>
<body>
  <h3>Здравствуйте, '.$rowUser["name"].'!</h3>
  <p>Вы зарегистрировались на сайте UpravDom.ru'.$rowUser["name"].'.</p>
  <p>Вход в личный кабинет: <a href=\"http://h106798759.nichost.ru/vote\">http://h106798759.nichost.ru/vote</a></p>
  <p>Ваш логин: <b>'.$rowUser["login"].'</b>.</p>
  <p>Ваш пароль: <b>72329</b></p>
  <p>Мы рады, что Вы с нами!</p>

</body>
</html>';

// To send HTML mail, the Content-type header must be set
  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
  $headers .= 'From: site' . "\r\n";

//  $cSelfMail = "eugene_ruabov@mail.ru";
  $cSelfMail = $rowUser["login"];

  if (!mail($cSelfMail, "Регистрация на сайте UpravDom.ru", $message, $headers))
    echo 'Что-то пошло не так... Письмо не отправлено!!!';
  else
    echo 'Письмо отослано успешно!!!';

  $sSQL = "Update users Set status = 1 Where id = $nIdRecord  Limit 1";

  if (!mysqli_query($link, $sSQL)) echo mysqli_error($link);

}
?>
