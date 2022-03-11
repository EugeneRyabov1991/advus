/**---------------------------------------------------------------------------------------------------------------------
 *   Функции работы со справочниками
 * ---------------------------------------------------------------------------------------------------------------------
 * @User: E.Ryabov
 * @Date: 30.11.16
 * @Time: 12:20
 * ---------------------------------------------------------------------------------------------------------------------
 */

/*---------------------------------------------------------------------------------------------------
 *  Отображает диалог редактирования программ.
 */
function showSpraEditForm(nRecordId_, cMode_){
    var dataObj = {
        "gnCurrentUserId"  : $("#txtCurrentUserId").val(),
        "id_record"        : nRecordId_,
        "gcMode"           : cMode_
    };
    var cFuncName = "spra/formSpraEdit.php";

    $.ajax({
        type: "POST",
        url:  cFuncName,
        data: dataObj,
        success: function(data){
            $("#headerForm").html("Редактирование записи справочника");
            $("#frmSpraEdit").html(data);
            $("#dlgSpraEditForm").modal({backdrop: false});
            $("#btnSaveSpraEditForm").focus();
        }
    })
}

//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Добавить запись в стравочник".
//
function InsertSpraRecord(cMode_) {

    var dataObj = {
        "gnCurrentUserId"   : $("#txtCurrentUserId").val(),
        "txtFilterId"   : $("#txtFilterId").val(),
        "gcMode"           : cMode_
    };
    $.ajax({
          type: "POST",
          url:  "spra/insertSpraRecord.php",
          data: dataObj,
          success: function(objRecord_){     // в параметр objRecord_ возвращается JSON-объект с данными по конкретной записи справочника
                $("#trSpraHeader").after(objRecord_);
              },
          error:   function(e){alert("Error:"+ e.toString());}
    });

}

//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Удалить запись из справочника".
//
function DeleteSpraRecord(nRecordId_, cMode_) {
  if (confirm("Bы уверены, что хотите удалить запись?")){
    var dataObj = {
          "id_record" : nRecordId_,
          "gnCurrentUserId"   : $("#txtCurrentUserId").val(),
          "gcMode"           : cMode_
    };
    $.ajax({
          type: "POST",
          url:  "spra/deleteSpraRecord.php",
          data: dataObj,
          success: function(data){
                      if( cMode_=="SPRA_GOODS"){
                        $("#trRecordDetail"+nRecordId_).fadeOut(100);
                      }
                      $("#trRecord"+nRecordId_).fadeOut(100);
                   },
          error:   function(e){alert("Error:"+ e.toString());}
    });
  }
}

//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Сохранить" в форме редактирования строки справочника.
//
$("#btnSaveSpraEditForm").click(function () {
    var strObj = "{";
    $(".ctrlFormSpraEdit").each(function(index, element) {   // Перебираем все элементы редактирования, и закидываем их в строку
                                                         // под форматирование в JSON-объект ...
       strObj = strObj + '"'+ $(this).attr("name") + '" : "' + htmlEscape($(this).val()) + '" ,';
    });

    $(".ctrlFormSpraCheckbox").each(function(index, element) {   // Перебираем все checkbox'ы
        strObj = strObj + '"'+ $(this).attr("name") + '" : "' + ($(this).prop("checked") ? "on" : "off") + '" ,';
    });

    strObj = strObj + '"gnCurrentUserId" : "'+ $("#txtCurrentUserId").val() +'",';  // ... сверху докидываем id пользователя ...
    strObj = strObj + '"id_record" : "'+ $("#txtRecordId").val() +'",';             // ... сверху докидываем id записи ...
    strObj = strObj + '"gcMode"   : "'+ $("#txtMode").val() +'"}';                  // ... сверху докидываем код справочника ...


    var dataObj = JSON.parse(strObj);                                               // ... и форматируем

    $.ajax({type: "POST",
          url:  "spra/saveSpraRecord.php",
          data: dataObj,
          success: function(data){
                      $("#tdName"+dataObj.id_record).html($("#txtName").val());
                      if ($("#txtMode").val() == "DOCS"){
                          $("#tdCaption"+dataObj.id_record).html($("#txtName").val());
                      }
                      if ($("#txtMode").val() == "EVENTS"){
                          $("#tdDtStart"+dataObj.id_record).html($("#txtDtStart").val());
                          $("#tdDtFinish"+dataObj.id_record).html($("#txtDtFinish").val());
                      }
                      if ($("#txtMode").val() == "INSURANCES"){
                          $("#tdNum"+dataObj.id_record).html($("#txtNum").val());
                          $("#tdName"+dataObj.id_record).html($("#txtName").val());
                          $("#tdSum"+dataObj.id_record).html($("#txtSum").val());
                          $("#tdPeriod"+dataObj.id_record).html("c "+$("#txtDtStart").val()+" по "+$("#txtDtFinish").val());
                      }
                      if ($("#txtMode").val() == "USERS"){
                        $("#tdLogin"+dataObj.id_record).html($("#txtLogin").val());
                        $("#tdPhone"+dataObj.id_record).html($("#txtPhone").val());
                        $("#tdEMail"+dataObj.id_record).html($("#txtEMail").val());
                      }
          }
    });
});

/*---------------------------------------------------------------------------------------------------
 *  Отсылает пользователю письмо с паролем
 */
function SendMail(nRecordId_){
    var dataObj = {
        "gnCurrentUserId"  : $("#txtCurrentUserId").val(),
        "id_record"        : nRecordId_
    };
    var cFuncName = "sendMail.php";
    $.ajax({
        type: "POST",
        url:  cFuncName,
        data: dataObj,
        success: function(data){
            $("#divMessage").html(data);
        }
    })
}

/*---------------------------------------------------------------------------------------------------
 *  Делает рассылку о событии всем собственникам дома
 */
function Mailing(nRecordId_){
    var dataObj = {
        "gnCurrentUserId"  : $("#txtCurrentUserId").val(),
        "id_record"        : nRecordId_
    };
    var cFuncName = "sendEventMail.php";
    $.ajax({
        type: "POST",
        url:  cFuncName,
        data: dataObj,
        success: function(data){
            $("#divMessage").html(data);
        }
    })
}

//---------------------------------------------------------------------------------------------------------------------
//   Служебная функция. Экранирует спецсимволы в строке.
//
function htmlEscape(str) {
    str = str
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    str = str.replace(/\n/g, '</br>');

    return str;
}


function UploadDoc(nRecordId_){
            // Get form
            var form = $('#frmUploadBackground')[0];

           $("#btnUploadSubmit").prop("disabled", true);
            // FormData object
            var data = new FormData(form);

            // If you want to add an extra field for the FormData
            data.append("type", "EVENT_DOCS");
            data.append("id_doc", nRecordId_);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "UploadFile.php",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                success: function (data) {
                    if (data != "") {
                        $("#output").text("Файл [" + data + "] загружен успешно");
                        $("#tdFileName"+nRecordId_).html('<a target="_blank" href="uploads/'+data+'">Посмотреть файл...</a>');
                        console.log("SUCCESS : ", data);
                        $("#btnUploadSubmit").prop("disabled", false);
                    }else   $("#output").text("Выберите файл!");

                },
                error: function (e) {
                    $("#output").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnUploadSubmit").prop("disabled", false);
                }
            });
}


//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Загрузить результаты голосования".
//
function onLoadDocument(nIdDoc_){
    var dataObj = {
        "gnCurrentUserId"  : $("#txtCurrentUserId").val(),
        "id_doc"         : nIdDoc_,
        "gnMode"           : 1
    };
    $.ajax({
        type: "POST",
        url:  "spra/formLoadDocs.php",
        data: dataObj,
        success: function(data){
            $("#headerUploadForm").html("Загрузка документа");
            $("#frmUploadEdit").html(data);
            $("#dlgUploadForm").modal({backdrop: false});
        }
    })
}


function MarkDocsToZip(){
    $("#pnlContent").html("");
    $("#divProgressBar").fadeIn();
    $("#divHeader").html("Пометьте документы для выгрузки");
    $.ajax({
        type: "POST",
        url:  "documents/markDocsToZip.php",
        success: function(data){     // в параметр [data] возвращается отформатированная строка таблицы с данными по новому городу
            $("#pnlContent").html(data);
            $("#divProgressBar").fadeOut();
        },
        error:   function(e){alert("Error:"+ e.toString());}
    });

}

function ZipDocs(){
    var strObj = "{";
    $(".ctrlDocsCheckbox").each(function(index, element) {   // Перебираем все checkbox'ы
        strObj = strObj + '"'+ $(this).attr("name") + '" : "' + ($(this).prop("checked") ? "on" : "off") + '" ,';
    });

    strObj = strObj + '"gnCurrentUserId" : "'+ $("#txtCurrentUserId").val() +'"}';  // ... сверху докидываем id пользователя ...


    var dataObj = JSON.parse(strObj);                                               // ... и форматируем

    $.ajax({type: "POST",
        url:  "documents/ZipFile.php",
        data: dataObj,
        success: function(data){
            $("#btnZipHeader").after("<a target='_blank' href='uploads/archive.zip'>Архив готов ["+data+"]</a>");        }
    });
}