<?php
/*---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку справочников
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   Date:   29.10.2021
---------------------------------------------------------------------------------------------------------------------*/

include("../db_connect.php");

/** @var INTEGER $cIdUser */
$cIdUser = $_POST["gnCurrentUserId"];
/** @var STRING $cMode */
  $cMode = $_POST["gcMode"];
  $cFilterValue = $_POST["gcFilter"];

  $cInsertLable = "";

?>
    <INPUT ID='txtFilterId' NAME='txtFilterId' type='hidden' Value='<?php echo $cFilterValue; ?>'>

    <table class="table table-bordered table-hover table-striped">

<?php

  switch ($cMode){
    case "USERS":
        $sSQL = "Select * FROM users Order By name";
        break;
    case "DOCS":
        $sSQL = "Select * FROM documents Where id_user=".$cFilterValue." Order By caption";
        echo '<button type="button" class="btn btn-primary" id="btnMailing" onClick="MarkDocsToZip()"><i class="fa fa-lg fa-file-zip-o"></i>Сделать выгрузку документов</button>';
        break;
    case "INSURANCES":
        $sSQL = "Select * FROM insurances Order By name";
        break;
    default:
        $sSQL = "Select * FROM users Order By name";
        break;
  }

  if ($cMode == "DOCS") {
      echo "<tr id='trSpraHeader'><th>Название документа</th><th>Файл</th><th>&nbsp;</th>";
  } else if ($cMode == "USERS") {
      echo "<tr id='trSpraHeader'><th class='col-lg-3'>ФИО</th><th class='col-lg-3'>Логин (e-mail)</th><th class='col-lg-3'>EMail</th><th>Телефон</th><th>&nbsp;</th>";
  } else if ($cMode == "INSURANCES") {
      echo "<tr id='trSpraHeader'><th class='col-lg-3'>Компания</th><th class='col-lg-3'>№ страховки</th><th class='col-lg-3'>Период</th><th>Сумма</th><th>&nbsp;</th>";
  }
  $crsSpra = mysqli_query($link, $sSQL);
  while ($rowSpra = mysqli_fetch_array($crsSpra)){
    $nId   = $rowSpra['id'];
    $cName =  htmlspecialchars_decode($rowSpra['name'], ENT_QUOTES);
    if ($cMode == "DOCS") {
        $cCaption = $rowSpra['caption'];
        $cFileName   = $rowSpra['file_name'];
        if ($cFileName != ""){
            $cFileName = '<a target="_blank" href="uploads/'.$cFileName.'">Посмотреть файл...</a>';
        }
        echo "<tr id='trRecord$nId'><td id='tdCaption$nId'>$cCaption</td><td id='tdFileName$nId'>$cFileName</td>".
            "<td nowrap>" .
            "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showSpraEditForm($nId, \"$cMode\");'><i class='fa fa-lg fa-edit'></i></a>" .
            "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Загрузить...' onClick='onLoadDocument($nId);'><i class='fa fa-lg fa-download'></i></a>" .
            "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteSpraRecord($nId, \"$cMode\");'><i class='fa fa-lg fa-trash-o'></i></a>".
            "</td></tr>";
    }else if ($cMode == "USERS") {
          $cName = $rowSpra['name'];
          $cLogin   = $rowSpra['login'];
          $cEmail   =  htmlspecialchars_decode($rowSpra['email'], ENT_QUOTES);
          $cPhone   = $rowSpra['phone'];
          echo "<tr id='trRecord$nId'><td id='tdName$nId'>$cName</td><td id='tdLogin$nId'>$cLogin</td><td id='tdEMail$nId'>$cEmail</td><td id='tdPhone$nId'>$cPhone</td>".
              "<td nowrap>" .
                "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showSpraEditForm($nId, \"$cMode\");'><i class='fa fa-lg fa-edit'></i></a>" .
                "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Документы...' onClick='SelectTabDocs($nId, \"$cName\");'><i class='fa fa-lg fa-book'></i></a>" .
                "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteSpraRecord($nId, \"$cMode\");'><i class='fa fa-lg fa-trash-o'></i></a>".
              "</td></tr>";
    }else if ($cMode == "INSURANCES") {
        $cName = $rowSpra['name'];
        $cNum   = $rowSpra['num'];
        $cDtStart   = $rowSpra['dt_start'];
        $cDtFinish   = $rowSpra['dt_finish'];
        $cSum    = $rowSpra['sum'];
        echo "<tr id='trRecord$nId'><td id='tdName$nId'>$cName</td><td id='tdNum$nId'>$cNum</td><td id='tdPeriod$nId'> c $cDtStart по $cDtFinish</td><td id='tdSum$nId'>$cSum</td>".
            "<td nowrap>" .
            "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Редактировать...' onClick='showSpraEditForm($nId, \"$cMode\");'><i class='fa fa-lg fa-edit'></i></a>" .
            "<a class='marginR10 btn btn-primary btn-sm' role='button' title='Удалить...' onClick='DeleteSpraRecord($nId, \"$cMode\");'><i class='fa fa-lg fa-trash-o'></i></a>".
            "</td></tr>";
    }
  }

?>
</table>

