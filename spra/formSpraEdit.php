<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку формы редактирования позиции в справочнике
//  Вызов из: INDEX.JSP
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   14.01.17
//---------------------------------------------------------------------------------------------------------------------

include("../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$cMode = $_POST["gcMode"];             /** @var STRING $cMode */
$nIdRecord = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */
?>

<div id="pnlSpraEdit">
  <FORM NAME='frmRecordEdit' ID='frmRecordEdit' role="form" METHOD='POST'>
    <INPUT ID='txtMode' NAME='txtMode' type='hidden' Value='<?php echo $cMode ?>'>
    <INPUT ID='txtRecordId' NAME='txtRecordId' type='hidden' Value='<?php echo $nIdRecord; ?>'>

<?php
  if ($cMode == "DOCS") {
    $sSQL = "Select * FROM documents Where id = ".$nIdRecord." Limit 1";

    $crsSpra = mysqli_query($link, $sSQL);
    if ($rowSpra = mysqli_fetch_array($crsSpra)) {
        echo '<div class="form-group">';
        echo '  <div class="col-sm-3"><label class="control-label" for="txtName">Название документа</label></div>';
        echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtName" id="txtName" type="text" value="' . $rowSpra['caption'] . '"></div>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '  <div class="col-sm-3"><label class="control-label" for="txtFileName">Файл документа</label></div>';
        echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtFileName" id="txtFileName" type="text" value="' . $rowSpra['file_name'] . '"></div>';
        echo '</div>';
    }
  } else if ($cMode == "USERS") {  // Сотрудники
      $sSQL = "Select * FROM users Where id = " . $nIdRecord . " Limit 1";

      $crsSpra = mysqli_query($link, $sSQL);
      if ($rowSpra = mysqli_fetch_array($crsSpra)) {

          echo '<div class="form-group">';
          echo '  <div class="col-sm-3"><label class="control-label" for="txtName">ФИО</label></div>';
          echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtName" id="txtName" type="text" value="' . $rowSpra['name'] . '"></div>';
          echo '</div>';
          echo '<div class="form-group">';
          echo '  <div class="col-sm-3"><label class="control-label" for="txtLogin">Логин</label></div>';
          echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtLogin" id="txtLogin" type="text" value="' . $rowSpra['login'] . '"></div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '  <div class="col-sm-3"><label class="control-label" for="txtEMail">EMail</label></div>';
          echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtEMail" id="txtEMail" type="text" value="' . $rowSpra['email'] . '"></div>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '  <div class="col-sm-3"><label class="control-label" for="txtPhone">Телефон</label></div>';
          echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtPhone" id="txtPhone" type="text" value="' . $rowSpra['phone'] . '"></div>';
          echo '</div>';
          echo '<div class="form-group">';
          echo '  <div class="col-sm-3"><label class="control-label" for="txtSRO">СРО</label></div>';
          echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtSRO" id="txtSRO" type="text" value="' . $rowSpra['sro'] . '"></div>';
          echo '</div>';
          echo '<div class="form-group">';
          echo '  <div class="col-sm-3"><label class="control-label" for="txtInsurance">Страховой полис:</label></div>';
          echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtInsurance" id="txtInsurance" type="text" value="' . $rowSpra['insurance'] . '"></div>';
          echo '</div>';
          echo '<div class="form-group">';
          echo '  <div class="col-sm-3"><label class="control-label" for="txtInsuranceSum">Лимит ответственности страховщика:</label></div>';
          echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtInsuranceSum" id="txtInsuranceSum" type="text" value="' . $rowSpra['insuranceSum'] . '"></div>';
          echo '</div>';
      }
  } else if ($cMode == "INSURANCES") {  // Сотрудники
    $sSQL = "Select * FROM insurances Where id = " . $nIdRecord . " Limit 1";

    $crsSpra = mysqli_query($link, $sSQL);
    if ($rowSpra = mysqli_fetch_array($crsSpra)) {

        echo '<div class="form-group">';
        echo '  <div class="col-sm-3"><label class="control-label" for="txtName">Страховщик</label></div>';
        echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtName" id="txtName" type="text" value="' . $rowSpra['name'] . '"></div>';
        echo '</div>';
        echo '<div class="form-group">';
        echo '  <div class="col-sm-3"><label class="control-label" for="txtNum">Страховой полис:</label></div>';
        echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtNum" id="txtNum" type="text" value="' . $rowSpra['num'] . '"></div>';
        echo '</div>';

        echo '<div class="form-group">';
        echo '  <div class="col-sm-3"><label class="control-label" for="txtDtStart">Срок действия с</label></div>';
        echo '  <div class="col-sm-3"><input class="form-control ctrlFormSpraEdit" name="txtDtStart" id="txtDtStart" type="text" value="' . $rowSpra['dt_start'] . '"></div>';
        echo '  <div class="col-sm-3"><label class="control-label" for="txtDtFinish">по</label></div>';
        echo '  <div class="col-sm-3"><input class="form-control ctrlFormSpraEdit" name="txtDtFinish" id="txtDtFinish" type="text" value="' . $rowSpra['dt_finish'] . '"></div>';
        echo '</div>';

        echo '<div class="form-group">';
        echo '  <div class="col-sm-3"><label class="control-label" for="txtSum">Сумма покрытия</label></div>';
        echo '  <div class="col-sm-9"><input class="form-control ctrlFormSpraEdit" name="txtSum" id="txtSum" type="text" value="' . $rowSpra['sum'] . '"></div>';
        echo '</div>';
    }
  }

?>
<!--

      <script type='text/javascript' src="../vendor/bootstrap/js/moment-with-locales.min.js"></script>
      <script type='text/javascript' src="../vendor/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
      <script type="text/javascript">
          $(function () {
              $('#datetimepickerReportDate, #datetimepickerEventStartDate, #datetimepickerEventFinishDate').datetimepicker({
                  locale: 'ru',
                  stepping: 10,
                  format: 'YYYY-MM-DD',
                  defaultDate: moment('01.01.2021').format('DD.MM.YYYY')
              });
          });
      </script>
-->


  </form>
</div>
