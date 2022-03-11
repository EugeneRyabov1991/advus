<?php
/*---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку страницы настроек.
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   Date:   04.12.2021
---------------------------------------------------------------------------------------------------------------------*/

include("../db_connect.php");

$sSQL = "Select * From options Limit 1";
$crsOption = mysqli_query($link, $sSQL);
if ($rowOption = mysqli_fetch_array($crsOption)) {
    $nIdRecord = $rowOption["id"];
    $lastBidId = $rowOption["maxIdDog"];

    echo '<div id="pnlOptionsEdit">';
    echo '  <FORM NAME="frmRecordEdit" ID="frmRecordEdit" role="form" >';
    echo "    <INPUT ID='txtRecordId' NAME='txtRecordId' type='hidden' Value='$nIdRecord'>";
    echo '    <div class="form-group">';
    echo '      <div class="col-sm-4"><label class="control-label" for="txtLastBidId">Номер последнего договора:</label></div>';
    echo '      <div class="col-sm-8">
                        <input class="form-control ctrlFormToolsEdit" name="txtLastBidId" id="txtLastBidId" type="text" value="' . $lastBidId . '">
                </div>';
    echo '    </div>';
    echo '   <div>
               <button type="button" class="btn btn-primary" name="btnSaveTools" id="btnSaveTools" onclick="saveTools()"><i class="fa fa-fw fa-save"></i>Сохранить</button>
             </div>';
    echo '  </form>';
    echo '</div>';
   }
?>