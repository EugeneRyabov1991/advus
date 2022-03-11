<?php
//---------------------------------------------------------------------------------------------------------------------
//
//  Генерируем HTML-разметку формы редактирования позиции в базе заявок
//  Вызов из: INDEX.JSP
//
//---------------------------------------------------------------------------------------------------------------------
//   @Author: E. Ryabov
//   @Date:   11.09.18
//---------------------------------------------------------------------------------------------------------------------

include("../db_connect.php");

$cIdUser = $_POST["gnCurrentUserId"];  /** @var INTEGER $cIdUser */
$nIdRecord = $_POST["id_record"];      /** @var INTEGER  $nIdRecord */
?>

<div id="pnlSpraEdit">
  <FORM NAME='frmRecordEdit' ID='frmRecordEdit' role="form" METHOD='POST'>
    <INPUT ID='txtRecordId' NAME='txtRecordId' type='hidden' Value='<?php echo $nIdRecord; ?>'>

<?php
  $sSQL = "Select bids.* FROM bids
                 Where bids.id = ".$nIdRecord." Limit 1";

  $crsBids = mysqli_query($link, $sSQL);
  if ($rowBid = mysqli_fetch_array($crsBids)){
    $nId   = $rowBid['id'];
    $nNum   = $rowBid['num'];
    $cDtBid  = $rowBid['dt'];
//    $cDtBid = substr($cDtBid, 8, 2).".".substr($cDtBid, 5, 2).".".substr($cDtBid, 0, 4);
    $cCustName  = htmlspecialchars_decode($rowBid['custName']);
    $cCustFullName  = htmlspecialchars_decode($rowBid['custFullName']);
    $cCustBoss  = htmlspecialchars_decode($rowBid['custBoss']);
    $cCustBossFullName  = htmlspecialchars_decode($rowBid['custBossFullName']);
    $cCustINN  = $rowBid['custINN'];
    $cCustKPP = $rowBid['custKPP'];
    $cCustAddress  = htmlspecialchars_decode($rowBid['custAddress']);
    $cCustKS = $rowBid['custKS'];
    $cCustRS = $rowBid['custRS'];
    $cCustBIK = $rowBid['custBIK'];
    $cCustOGRN = $rowBid['custOGRN'];
    $cCustBank  = htmlspecialchars_decode($rowBid['custBank']);
    $cCustDocType = $rowBid['custDocType'];

    $cComments  = htmlspecialchars_decode($rowBid['comments']);
    $nPrice = $rowBid['price'];
    $nPrepaid = $rowBid['prepaid'];

    $cEstimateDt = $rowBid['estimateDt'];
    $cEstimatePaid = $rowBid['estimatePaid'];

    $nStatus   = $rowBid['status'];
    $nIdManager   = $rowBid['id_manager'];
    $nIdSign   = $rowBid['id_sign'];
    $cNumDog   = $rowBid['num_dog'];
    $nSubjType = $rowBid['subjType'];
    $nType = $rowBid['id_type'];
    $nIdInsurance  = $rowBid['id_insurance'];
    $nIdFirm  = $rowBid['id_firm'];
    $nIdManager  = $rowBid['id_manager'];
    $nIdSign  = $rowBid['id_sign'];
    $nPayStatus  = $rowBid['payStatus'];
    if ($nIdFirm == 0) $nIdFirm = 1;

    $cDtAct      = $rowBid['dtAct'];
    $cDtContract = $rowBid['dtContract'];
    $cDtDone     = $rowBid['dtDone'];

    echo '<div class="row" style="padding-left: 15px; padding-right: 15px">';
    echo ' <div class="form-group">';
    echo '  <div class="col-sm-2"><label class="control-label" for="txtBidCode">Номер договора:</label></div>';
    echo '  <div class="col-sm-2">
             <div class="input-group">
              <input class="form-control ctrlFormBidEdit" name="txtBidCode" id="txtBidCode" type="text" value="'.$nNum.'"/>
              <span class="input-group-addon" title="Сформировать..." onClick="getBidCode();">
                <i class="fa fa-lg fa-calculator"></i>
              </span>
             </div>
            </div>';

    echo '  <div class="col-sm-1"><label class="control-label" for="txtBidDate">Дата:</label></div>';
    echo '  <div class="col-sm-3">
			  <div class="input-group date" id="datetimepickerBidDate">
			    <input type="text" class="form-control ctrlFormBidEdit"  name="txtBidDate" id="txtBidDate" value="'.$cDtBid.'" />
			    <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span> </span>
		  	  </div>
            </div>';
    echo '  <div class="col-sm-2"><label class="control-label" for="cmbType">Тип договора:</label></div>';
    echo '  <div class="col-sm-2">';
    echo '    <select class="form-control ctrlFormBidEdit" name="cmbType" id="cmbType">';
    echo '      <option id="optType0" Value="0" '.($nType == 0 ? "SELECTED" : "").'>Оценка</option>';
    echo '      <option id="optType1" Value="1" '.($nType == 1 ? "SELECTED" : "").'>Консалтинг</option>';
    echo '      <option id="optType2" Value="2" '.($nType == 2 ? "SELECTED" : "").'>Судебный</option>';
    echo '    </select>';
    echo '  </div>';
    echo ' </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <label for="cmbSubjType" class="control-label col-sm-2">Предмет оценки:</label>';
    echo '  <div class="col-sm-4">';
    echo '    <select class="form-control ctrlFormBidEdit" name="cmbSubjType" id="cmbSubjType">';
    echo '      <option id="optSubjType0" Value="0" '.($nSubjType == 0 ? "SELECTED" : "").'>Не определен</option>';
    echo '      <option id="optSubjType1" Value="1" '.($nSubjType == 1 ? "SELECTED" : "").'>Недвижимость</option>';
    echo '      <option id="optSubjType2" Value="2" '.($nSubjType == 2 ? "SELECTED" : "").'>Бизнес</option>';
    echo '      <option id="optSubjType3" Value="3" '.($nSubjType == 3 ? "SELECTED" : "").'>Оборудование</option>';
    echo '      <option id="optSubjType4" Value="4" '.($nSubjType == 4 ? "SELECTED" : "").'>Инт. собственность</option>';
    echo '      <option id="optSubjType5" Value="5" '.($nSubjType == 5 ? "SELECTED" : "").'>Недвижимость+Оборудование</option>';
    echo '      <option id="optSubjType6" Value="6" '.($nSubjType == 6 ? "SELECTED" : "").'>Инт.собственность+Оборудование</option>';
    echo '      <option id="optSubjType7" Value="7" '.($nSubjType == 7 ? "SELECTED" : "").'>Инт.собственность+Оборудование+Недвижимость</option>';
    echo '    </select>';
    echo '  </div>';
    echo '  <label for="cmbStatus" class="control-label col-sm-3">Статус договора:</label>';
    echo '  <div class="col-sm-3">';
    echo '    <select class="form-control ctrlFormBidEdit" name="cmbStatus" id="cmbStatus">';
    echo '      <option id="optStatus0" Value="0" '.($nStatus == 0 ? "SELECTED" : "").'>Не определен</option>';
    echo '      <option id="optStatus1" Value="1" '.($nStatus == 1 ? "SELECTED" : "").'>Зарегистрирован</option>';
    echo '      <option id="optStatus2" Value="2" '.($nStatus == 2 ? "SELECTED" : "").'>В работе</option>';
    echo '      <option id="optStatus3" Value="3" '.($nStatus == 3 ? "SELECTED" : "").'>Согласование расчета</option>';
    echo '      <option id="optStatus4" Value="4" '.($nStatus == 4 ? "SELECTED" : "").'>Проверка отчета</option>';
    echo '      <option id="optStatus5" Value="5" '.($nStatus == 5 ? "SELECTED" : "").'>Сдан</option>';
    echo '      <option id="optStatus6" Value="6" '.($nStatus == 6 ? "SELECTED" : "").'>Архив</option>';
    echo '    </select>';
    echo '  </div>';
    echo '</div>';


    echo '<div class="form-group">';
    echo '  <div class="col-sm-4"><label class="control-label" for="txtCustName">Краткое название организации:</label></div>';
    echo '  <div class="col-sm-8">
              <input class="form-control ctrlFormBidEdit" name="txtCustName" id="txtCustName" type="text" value="'.$cCustName.'">             
            </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-4"><label class="control-label" for="txtCustFullName">Полное название организации:</label></div>';
    echo '  <div class="col-sm-8">
            <input class="form-control ctrlFormBidEdit" name="txtCustFullName" id="txtCustFullName" type="text" value="'.$cCustFullName.'">             
          </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-4"><label class="control-label" for="txtCustAddress">Адрес организации:</label></div>';
    echo '  <div class="col-sm-8">
          <input class="form-control ctrlFormBidEdit" name="txtCustAddress" id="txtCustAddress" type="text" value="'.$cCustAddress.'">             
        </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-4"><label class="control-label" for="txtCustBoss">Ген.директор:</label></div>';
    echo '  <div class="col-sm-8">
          <input class="form-control ctrlFormBidEdit" name="txtCustBoss" id="txtCustBoss" type="text" value="'.$cCustBoss.'">             
        </div>';
    echo '</div>';

    echo '<div class="row" style="padding-left: 15px; padding-right: 15px">';
    echo ' <div class="form-group">';
    echo '  <div class="col-sm-2"><label class="control-label" for="txtCustBossFullName">... в лице</label></div>';
    echo '  <div class="col-sm-5">
              <input class="form-control ctrlFormBidEdit" name="txtCustBossFullName" id="txtCustBossFullName" type="text" value="'.$cCustBossFullName.'">
            </div>';
    echo ' </div>';
    echo '  <div class="col-sm-2"><label class="control-label" for="txtCustDocType">действующего на основании:</label></div>';
    echo '  <div class="col-sm-3">
             <input class="form-control ctrlFormBidEdit" name="txtCustDocType" id="txtCustDocType" type="text" value="'.$cCustDocType.'">
            </div>';
    echo '</div>';

    echo '<div class="row" style="padding-left: 15px; padding-right: 15px">';
    echo ' <div class="form-group">';
    echo '  <div class="col-sm-3"><label class="control-label" for="txtCustINN">ИНН:</label></div>';
    echo '  <div class="col-sm-3">
             <input class="form-control ctrlFormBidEdit" name="txtCustINN" id="txtCustINN" type="text" value="'.$cCustINN.'">
            </div>';
    echo '  <div class="col-sm-3"><label class="control-label" for="txtCustKPP">КПП:</label></div>';
    echo '  <div class="col-sm-3">
              <input class="form-control ctrlFormBidEdit" name="txtCustKPP" id="txtCustKPP" type="text" value="'.$cCustKPP.'">
            </div>';
    echo ' </div>';
    echo '</div>';

    echo '<div class="row" style="padding-left: 15px; padding-right: 15px">';
    echo ' <div class="form-group">';
    echo '  <div class="col-sm-3"><label class="control-label" for="txtCustBIK">БИК:</label></div>';
    echo '  <div class="col-sm-3">
             <input class="form-control ctrlFormBidEdit" name="txtCustBIK" id="txtCustBIK" type="text" value="'.$cCustBIK.'">
            </div>';
   echo '  <div class="col-sm-3"><label class="control-label" for="txtCustOGRN">ОГРН:</label></div>';
   echo '  <div class="col-sm-3">
             <input class="form-control ctrlFormBidEdit" name="txtCustOGRN" id="txtCustOGRN" type="text" value="'.$cCustOGRN.'">
            </div>';
   echo ' </div>';
   echo '</div>';

   echo '<div class="form-group">';
   echo '  <div class="col-sm-4"><label class="control-label" for="txtCustBank">Банк:</label></div>';
   echo '  <div class="col-sm-8">
            <input class="form-control ctrlFormBidEdit" name="txtCustBank" id="txtCustBunk" type="text" value="'.$cCustBank.'">             
          </div>';
   echo '</div>';


   echo '<div class="row" style="padding-left: 15px; padding-right: 15px">';
   echo ' <div class="form-group">';
   echo '  <div class="col-sm-3"><label class="control-label" for="txtCustRS">Р/с:</label></div>';
   echo '  <div class="col-sm-3">
             <input class="form-control ctrlFormBidEdit" name="txtCustRS" id="txtCustRS" type="text" value="'.$cCustRS.'">
           </div>';
   echo '  <div class="col-sm-3"><label class="control-label" for="txtCustKS">К/с:</label></div>';
   echo '  <div class="col-sm-3">
             <input class="form-control ctrlFormBidEdit" name="txtCustKS" id="txtCustKS" type="text" value="'.$cCustKS.'">
            </div>';
    echo ' </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-2"><label class="control-label" for="txtBidPrice">Сумма [руб]:</label></div>';
    echo '  <div class="col-sm-2">
              <input class="form-control ctrlFormBidEdit" name="txtBidPrice" id="txtBidPrice" type="text" value="'.$nPrice.'"/>
            </div>';
    echo '  <div class="col-sm-2"><label class="control-label" for="txtBidPrepaid">Предоплата [руб]:</label></div>';
    echo '  <div class="col-sm-2">
              <input class="form-control ctrlFormBidEdit" name="txtBidPrepaid" id="txtBidPrepaid" type="text" value="'.$nPrepaid.'"/>
            </div>';
    echo '  <div class="col-sm-1"><label class="control-label" for="cmbPayStatus">Оплата:</label></div>';
    echo '  <div class="col-sm-3">';
    echo '    <select class="form-control ctrlFormBidEdit" name="cmbPayStatus" id="cmbPayStatus">';
    echo '       <option id="optFirm0" Value="0" '.($nPayStatus==0 ? "SELECTED" : "").'>Отсутствует</option>';
    echo '       <option id="optFirm1" Value="1" '.($nPayStatus==1 ? "SELECTED" : "").'>Внесен аванс</option>';
    echo '       <option id="optFirm2" Value="2" '.($nPayStatus==2 ? "SELECTED" : "").'>Оплачен</option>';
    echo '    </select>';

    echo '  </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-3"><label class="control-label" for="txtEstimateDt">Срок выполнения работ [дни]:</label></div>';
    echo '  <div class="col-sm-3">
              <input class="form-control ctrlFormBidEdit" name="txtEstimateDt" id="txtEstimateDt" type="text" value="'.$cEstimateDt.'"/>
            </div>';
    echo '  <div class="col-sm-3"><label class="control-label" for="txtEstimatePaid">Срок оплаты [дни]:</label></div>';
    echo '  <div class="col-sm-3">
              <input class="form-control ctrlFormBidEdit" name="txtEstimatePaid" id="txtEstimatePaid" type="text" value="'.$cEstimatePaid.'"/>
            </div>
          </div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-3"><label for="cmbInsurance" class="control-label">Страховка договора:</label></div>';
    echo '  <div class="col-sm-3">';
    echo '    <select class="form-control ctrlFormBidEdit" name="cmbInsurance" id="cmbInsurance">';
    $sSQL = "Select * FROM insurances Order By `name`";
    $crsInsurances = mysqli_query($link, $sSQL);
    while ($rowInsurance = mysqli_fetch_array($crsInsurances)) {
          $cInsuranceName = "[".htmlspecialchars_decode($rowInsurance['num'], ENT_QUOTES)."] - ".htmlspecialchars_decode($rowInsurance['name'], ENT_QUOTES);
          $cSelected = ($rowInsurance["id"] == $nIdInsurance ? "SELECTED" : "");
          echo '<option id="optInsurance'.$rowInsurance["id"].'" Value="'.$rowInsurance["id"].'" '.$cSelected.'>'.$cInsuranceName.'</option>';
      }
    echo '    </select>';
    echo '  </div>';

    echo '  <div class="col-sm-3"> <label for="cmbFirm" class="control-label">Фирма:</label></div>';
    echo '  <div class="col-sm-3">';
    echo '    <select class="form-control ctrlFormBidEdit" name="cmbFirm" id="cmbFirm">';
    echo '       <option id="optFirm1" Value="1" '.($nIdFirm==1 ? "SELECTED" : "").'>Адвус-Нева</option>';
    echo '       <option id="optFirm2" Value="2" '.($nIdFirm==2 ? "SELECTED" : "").'>ООО «ГСЭК»</option>';
    echo '       <option id="optFirm3" Value="3" '.($nIdFirm==3 ? "SELECTED" : "").'>НП «ДСЭК»</option>';
    echo '    </select>';
    echo '  </div>';
    echo '</div>';


    echo '  <div class="col-sm-3"> <label for="cmbManager" class="control-label">Менеджер проекта:</label></div>';
    echo '  <div class="col-sm-3">';
    echo '    <select class="form-control ctrlFormBidEdit" name="cmbManager" id="cmbManager">';
    $cSelected = ($nIdManager == 0 ? "SELECTED" : "");
    echo '<option id="optManager0" Value="0" '.$cSelected.'>Не выбран</option>';
    $sSQL = "Select * FROM users Order By `name`";
    $crsUsers = mysqli_query($link, $sSQL);
    while ($rowUser = mysqli_fetch_array($crsUsers)) {
        $cUserName = htmlspecialchars_decode($rowUser['name'], ENT_QUOTES);
        $cSelected = ($rowUser["id"] == $nIdManager ? "SELECTED" : "");
        echo '<option id="optManager'.$rowUser["id"].'" Value="'.$rowUser["id"].'" '.$cSelected.'>'.$cUserName.'</option>';
    }
    echo '    </select>';
    echo '  </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-3"><label for="cmbSign" class="control-label">Подписант:</label></div>';
    echo '  <div class="col-sm-3">';
    echo '    <select class="form-control ctrlFormBidEdit" name="cmbSign" id="cmbSign">';
    $cSelected = ($nIdSign == 0 ? "SELECTED" : "");
    echo '<option id="optSign0" Value="0" '.$cSelected.'>Не выбран</option>';
    $sSQL = "Select * FROM users Order By `name`";
    $crsUsers = mysqli_query($link, $sSQL);
    while ($rowUser = mysqli_fetch_array($crsUsers)) {
          $cUserName = htmlspecialchars_decode($rowUser['name'], ENT_QUOTES);
          $cSelected = ($rowUser["id"] == $nIdSign ? "SELECTED" : "");
          echo '<option id="optSign'.$rowUser["id"].'" Value="'.$rowUser["id"].'" '.$cSelected.'>'.$cUserName.'</option>';
    }
    echo '    </select>';
    echo '  </div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-3"><label class="control-label" for="txtSubjName">Комментарий:</label></div>';
    echo '  <div class="col-sm-9">
               <input class="form-control ctrlFormBidEdit" name="txtSubjName" id="txtSubjName" type="text" value="'.$cComments .'">
           </div>';
    echo '</div>';

    echo '<div class="form-group">';
    echo '  <div class="col-sm-1"><label class="control-label" for="txtDtAct">Прислали акт:</label></div>';
    echo '  <div class="col-sm-3">
			  <div class="input-group date" id="datetimepickerActDate">
			    <input type="text" class="form-control ctrlFormBidEdit"  name="txtDtAct" id="txtDtAct" value="'.$cDtAct.'" />
			    <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span> </span>
		  	  </div>
           </div>';
    echo '  <div class="col-sm-1"><label class="control-label" for="txtDtContract">Прислали договор:</label></div>';
    echo '  <div class="col-sm-3">
			  <div class="input-group date" id="datetimepickerContractDate">
			    <input type="text" class="form-control ctrlFormBidEdit"  name="txtDtContract" id="txtDtContract" value="'.$cDtContract.'" />
			    <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span> </span>
		  	  </div>
            </div>';
    echo '  <div class="col-sm-1"><label class="control-label" for="txtDtDone">Сдан:</label></div>';
    echo '  <div class="col-sm-3">
			  <div class="input-group date" id="datetimepickerDoneDate">
			    <input type="text" class="form-control ctrlFormBidEdit"  name="txtDtDone" id="txtDtDone" value="'.$cDtDone.'" />
			    <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span> </span>
		  	  </div>
           </div>';

    echo '</div>';

  }
?>
      <script type="text/javascript">
          $(function () {
              $('#datetimepickerBidDate, #datetimepickerBidDateIn, #datetimepickerActDate, #datetimepickerContractDate, #datetimepickerDoneDate').datetimepicker({
                  locale: 'ru',
                  stepping: 10,
                  format: 'DD.MM.YYYY',
//                  defaultDate: moment('09.09.2018').format('DD.MM.YYYY')
              });
          });
      </script>

  </form>
</div>
