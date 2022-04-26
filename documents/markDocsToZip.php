<?php
/*---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку для пометки документов под выгрузку
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   Date:   03.11.2021
---------------------------------------------------------------------------------------------------------------------*/

include("../db_connect.php");

$cIdUser = $_POST["id_user"];


$sSQL = "Select *, documents.id as id_doc, users.name as user_name From documents
             Left Join users on users.id=documents.id_user
         Order By users.id, caption";

  echo '<button type="button" class="btn btn-primary" id="btnZipHeader" onClick="ZipDocs()"><i class="fa fa-lg fa-file-zip-o"></i>Сформировать архив...</button>';

  echo '<table class="table table-bordered table-hover table-striped">';

  echo "<tr id='trDocs'><th></th><th>Сотрудник</th><th>Название документа</th>";
  $crsDocs = mysqli_query($link, $sSQL);
  while ($rowDoc = mysqli_fetch_array($crsDocs)){
    $nId   = $rowDoc['id_doc'];
    $cCaption =  htmlspecialchars_decode($rowDoc['caption'], ENT_QUOTES);
    $cUserName =  htmlspecialchars_decode($rowDoc['user_name'], ENT_QUOTES);
    if ($cUserName == "") $cUserName = "Документ компании";
    echo "<tr id='trRecord$nId'>
              <td><INPUT TYPE='checkbox' class='ctrlDocsCheckbox' NAME='chkDoc$nId' ID='chkDoc$nId' /></td>
              <td id='tdUserName$nId'>$cUserName</td><td id='tdCaption$nId'>$cCaption</td>".
            "</tr>";
  }

echo '</table>';
echo '<button type="button" class="btn btn-primary" id="btnZipFoooter" onClick="ZipDocs()"><i class="fa fa-lg fa-file-zip-o"></i>Сформировать архив...</button>';
?>

