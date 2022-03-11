<?php

include("../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$nIdDoc = $_POST["id_doc"];

$sSQL = "Select *, users.name as user_name From documents
             Left Join users on users.id=documents.id_user
         Where documents.id = $nIdDoc  Limit 1";

$crsDocs = mysqli_query($link, $sSQL);
$cCaption = "";
$cUserName = "";
if ($rowDoc = mysqli_fetch_array($crsDocs)) {
  if ($rowDoc["caption"] != "") $cCaption = $rowDoc["caption"];
  if ($rowDoc["user_name"] != "") $cUserName = $rowDoc["user_name"];
}
$cCaption .= ($cUserName!="" ? " (Документ сотрудника [".$cUserName."])" : "");
echo $cCaption;
?>


<div id="pnlSpraEdit">
    <form enctype="multipart/form-data" method="post" action="UploadFile.php?type=EVENT_DOCS&id_event=<? echo $nIdDoc; ?>" ID="frmUploadBackground" NAME="frmUploadBackground">
        <div class="form-group">
            <div class="col-sm-12">
                <input type="hidden" name="MAX_FILE_SIZE" value="20000000"/>
                <div class="col-sm-6">
                  <input name="txtFile1" id="txtFile1" type="file">
                </div>

                <a class='marginR10 btn btn-primary btn-sm' role='button' id='btnUploadSubmit' title='Загрузить документ...' onClick='UploadDoc(<?php echo($nIdDoc); ?>);'>
                  <i class='fa fa-lg fa-download'>Загрузить документ...</i>
                </a>
                <span id="output"></span>

            </div>
        </div>
    </form>
</div>
