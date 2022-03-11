
<?php
/*----------------------------------------------------------------------------------------------------------------------
  Проверка корректности входа в систему
  ----------------------------------------------------------------------------------------------------------------------
  User: E. Ryabov
  Date: 28.08.2018
  Time: 11:36:00
  ----------------------------------------------------------------------------------------------------------------------
*/
  include("db_connect.php");

$cPassword = $_POST['txtPassword'];
$nUserId = -1;
$cUserName = "";
$cUserLogin = "";
$nUserRole = 0;
$cUserPhone = "";
$cUserEmail = "";
$nOk = 0;

$sSQL = "Select * From users Where TRIM(pass)='".$cPassword."'";
$result=mysqli_query($link, $sSQL);
if (mysqli_num_rows($result) != 0){
  $row = mysqli_fetch_array($result);
  $nUserId = $row["id"];
  $cUserLogin = $row["login"];
  $cUserName = $row["name"];
  $cUserPhone = $row["phone"];
  $nOk = 1;
}

echo "{";
echo "\"Id\" : \"" .   $nUserId . "\",";
echo "\"Name\" : \"" . $cUserName . "\",";
echo "\"Login\" : \"". $cUserLogin."\",";
echo "\"Email\" : \"". $cUserEmail."\",";
echo "\"bOk\" : \"".   $nOk ."\"";
echo "}";

?>

