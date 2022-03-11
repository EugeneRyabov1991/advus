<?php
/*---------------------------------------------------------------------------------------------------------------------
//
//  Добавляем в справочник новую запись
//  Вызов из: js/spra.js
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   27.06.2021
//---------------------------------------------------------------------------------------------------------------------
*/
include("../db_connect.php");

  $cIdUser = $_POST["gnCurrentUserId"];
  $cMode = $_POST["gcMode"];
  $cFilerId = $_POST["txtFilterId"];

  if ($cMode == "DOCS"){
      $sSQL = "INSERT INTO documents (caption, id_user) Values ('!!! Новый документ !!!', ".$cFilerId.")";
  } else if ($cMode == "USERS"){
      $sSQL = "INSERT INTO users (name) Values ('!!! Новый пользователь !!!')";
  } else if ($cMode == "INSURANCES"){
      $sSQL = "INSERT INTO insurances (name) Values ('!!! Страховщик !!!')";
   }
   if (!mysqli_query($link, $sSQL)) echo mysqli_error($link);
   $nId = mysqli_insert_id($link);

/*
   if ($cMode == "POINTS") { // Для опросников проставляем номер пункта
       $sSQL = "Update event_points Set num = '" . $nId . "' Where id = " . $nId . " Limit 1";
       if (!mysqli_query($link, $sSQL)) echo mysqli_error();
   }
*/

   if ($cMode == "DOCS") {
       echo "<tr id='trRecord$nId'><td id='tdCaption$nId'>!!! Новый документ !!!</td><td id='tdFileName$nId'></td>".
           "<td nowrap>" .
           "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showSpraEditForm($nId, \"DOCS\");'><i class='fa fa-lg fa-edit'></i></a>" .
           "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Загрузить...' onClick='onLoadDocument($nId);'><i class='fa fa-lg fa-download'></i></a>" .
           "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteSpraRecord($nId, \"DOCS\");'><i class='fa fa-lg fa-trash-o'></i></a>".
           "</td></tr>";
   } if ($cMode == "USERS") {
       echo "<tr id='trRecord$nId'><td id='tdName$nId'>!!! Новый сотрудник !!!</td><td id='tdLogin$nId'></td><td id='tdEmail$nId'></td><td id='tdPhone$nId'></td>".
           "<td nowrap>" .
              "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showSpraEditForm($nId, \"$cMode\");'><i class='fa fa-lg fa-edit'></i></a>" .
              "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Документы...' onClick='SelectTabDocs($nId, \"$cName\");'><i class='fa fa-lg fa-book'></i></a>" .
              "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteSpraRecord($nId, \"$cMode\");'><i class='fa fa-lg fa-trash-o'></i></a>".

            "</td></tr>";
   } if ($cMode == "INSURANCES") {
        echo "<tr id='trRecord$nId'><td id='tdName$nId'>!!! Страховщик !!!</td><td id='tdNum$nId'></td><td id='tdPeriod$nId'> c ... по ...</td><td id='tdSum$nId'>0</td>".
            "<td nowrap>" .
               "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showSpraEditForm($nId, \"$cMode\");'><i class='fa fa-lg fa-edit'></i></a>" .
               "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteSpraRecord($nId, \"$cMode\");'><i class='fa fa-lg fa-trash-o'></i></a>".
             "</td></tr>";
   }


