/**---------------------------------------------------------------------------------------------------------------------
 *   Функции работы с базой заявок (договоров)
 * ---------------------------------------------------------------------------------------------------------------------
 * @User: E.Ryabov
 * @Date: 18.11.2021
 * @Time: 12:52
 * ---------------------------------------------------------------------------------------------------------------------
 */


/*-----------------------------------------------------------------------------------------------
*    Диспетчер, загружает список заявок
*/
function SelectTabBids() {
    cHeader = "Договора (заявки)";

    $("#pnlContent").html("");
    $("#divProgressBar").fadeIn();

    $("#divHeader").html("<div class='col-sm-6'>"+cHeader+"</div>" +
        "<div class='col-sm-3'><a class='btn btn-info btn-lg marginB10' role='button'  onClick='BidReport()'><i class='fa fa-lg fa-print marginR5'></i>Сформировать отчет</a></div>" +
        "<div class='col-sm-3'><a class='btn btn-primary btn-lg marginB10' role='button'  onClick='InsertBid()'><i class='fa fa-lg fa-plus-square marginR5'></i>Новый договор (заявка)</a></div>");


    var dataObj = {
        "gnCurrentUserId"   : $("#txtCurrentUserId").val()
    };
    $.ajax({
        type: "POST",
        data: dataObj,
        url:  "bids/refreshBidList.php",
        success: function(data){
            $("#pnlContent").html(data);
            $("#divProgressBar").fadeOut();
        },
        error:   function(e){alert("Error:"+ e.toString());}
    });
}

/*-----------------------------------------------------------------------------------------------
 *    Формирует отчет о ходе работы по договорам
 */
function BidReport() {
    cHeader = "Отчет о ходе работ по договорам";

    $("#pnlContent").html("");
    $("#divProgressBar").fadeIn();

    $("#divHeader").html("<div class='col-sm-12'>Отчет о ходе работ по договорам</div>");

    var dataObj = {
        "gnCurrentUserId"   : $("#txtCurrentUserId").val()
    };
    $.ajax({
        type: "POST",
        url:  "bids/BidReport.php",
        success: function(data){
            $("#pnlContent").html(data);
            $("#divProgressBar").fadeOut();
        },
        error:   function(e){alert("Error:"+ e.toString());}
    });
}


//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Добавить запись в стравочник".
//
function InsertBid() {

    var dataObj = {
        "gnCurrentUserId"   : $("#txtCurrentUserId").val()
    };
    $.ajax({
        type: "POST",
        url:  "bids/insertBid.php",
        data: dataObj,
        success: function(objRecord_){     // в параметр objRecord_ возвращается JSON-объект с данными по конкретной записи справочника
            $("#trBidHeader").after(objRecord_);
        },
        error:   function(e){alert("Error:"+ e.toString());}
    });

}


//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Удалить запись из базы заявок".
//
function DeleteBidRecord(nRecordId_) {
    if (confirm("Bы уверены, что хотите удалить договор?")){
        var dataObj = {
            "id_record" : nRecordId_,
            "gnCurrentUserId"   : $("#txtCurrentUserId").val()
        };
        $.ajax({
            type: "POST",
            url:  "bids/deleteBid.php",
            data: dataObj,
            success: function(data){
                $("#trRecord"+nRecordId_).fadeOut(100);
            },
            error:   function(e){alert("Error:"+ e.toString());}
        });
    }
}


/*---------------------------------------------------------------------------------------------------
 *  Отображает диалог редактирования программ.
 */
function showBidEditForm(nRecordId_, cMode_){
    var dataObj = {
        "gnCurrentUserId"  : $("#txtCurrentUserId").val(),
        "id_record"        : nRecordId_
    };
    $.ajax({
        type: "POST",
        url:  "bids/formBidEdit.php",
        data: dataObj,
        success: function(data){
            $("#headerForm").html("Редактирование договора (заявки)");
            $("#frmBidEdit").html(data);
            $("#dlgBidEditForm").modal({backdrop: false});
        }
    })
}


//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Сохранить" в форме редактирования параметров заявки.
//
$("#btnSaveBidEditForm").click(function () {
    var strObj = "{";
    $(".ctrlFormBidEdit").each(function(index, element) {   // Перебираем все элементы редактирования, и закидываем их в строку
                                                         // под форматирование в JSON-объект ...
       strObj = strObj + '"'+ $(this).attr("name") + '" : "' + htmlEscape($(this).val()) + '" ,';
    });

    $(".ctrlFormBidCheckbox").each(function(index, element) {   // Перебираем все checkbox'ы
        strObj = strObj + '"'+ $(this).attr("name") + '" : "' + ($(this).prop("checked") ? "on" : "off") + '" ,';
    });

    strObj = strObj + '"gnCurrentUserId" : "'+ $("#txtCurrentUserId").val() +'",';  // ... сверху докидываем id пользователя ...
    strObj = strObj + '"id_record" : "'+ $("#txtRecordId").val() +'"}';             // ... сверху докидываем id записи ...

    var dataObj = JSON.parse(strObj);                                               // ... и форматируем

    $.ajax({type: "POST",
          url:  "bids/saveBidRecord.php",
          data: dataObj,
          success: function(data){

              SelectTabBids();
/*
              $("#tdBidNum"+dataObj.id_record).html($("#txtBidCode").val());
              $("#tdBidDt"+dataObj.id_record).html($("#txtBidDate").val());
              $("#tdCustName"+dataObj.id_record).html($("#txtCustName").val());
              $("#tdBidPrice"+dataObj.id_record).html($("#txtBidPrice").val());

              var arStatus = ["Не определен", "Зарегистрирована", "В работе", "Согласование расчета", "Проверока отчета", "Архив"];

              $("#tdStatus"+dataObj.id_record).html(arStatus[$("#cmbStatus").val()]);
*/
          }
    });
});

//---------------------------------------------------------------------------------------------------------------------
//   Запуск составления счета и акта (по заявке).
//
function PrintDoc(cType_){
    if (cType_ == "CONTRACT"){
        var strObj = "{";
        $(".ctrlFormBidEdit").each(function(index, element) {   // Перебираем все элементы редактирования, и закидываем их в строку
            // под форматирование в JSON-объект ...
            strObj = strObj + '"'+ $(this).attr("name") + '" : "' + htmlEscape($(this).val()) + '" ,';
        });

        $(".ctrlFormBidCheckbox").each(function(index, element) {   // Перебираем все checkbox'ы
            strObj = strObj + '"'+ $(this).attr("name") + '" : "' + ($(this).prop("checked") ? "on" : "off") + '" ,';
        });

        strObj = strObj + '"gnCurrentUserId" : "'+ $("#txtCurrentUserId").val() +'",';  // ... сверху докидываем id пользователя ...
        strObj = strObj + '"id_record" : "'+ $("#txtRecordId").val() +'"}';             // ... сверху докидываем id записи ...

        var dataObj = JSON.parse(strObj);                                               // ... и форматируем

        $.ajax({type: "POST",
            url:  "bids/saveBidRecord.php",
            data: dataObj,
            success: function(data){
                document.location.href='bids/createContract.php?id_record='+$("#txtRecordId").val();
            }
        });


    }else  if (cType_ == "BILL"){
        document.location.href='bids/createBidBill.php?id_record='+$("#txtRecordId").val();
    }
}


//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Сохранить" в форме редактирования состава исполнитлей заявки.
//
$("#btnSaveBidUserForm").click(function () {
    var strObj = "{";
    $(".ctrlFormBidUser").each(function(index, element) {   // Перебираем все элементы редактирования, и закидываем их в строку
        // под форматирование в JSON-объект ...
        strObj = strObj + '"'+ $(this).attr("name") + '" : "' + htmlEscape($(this).val()) + '" ,';
    });

    strObj = strObj + '"gnCurrentUserId" : "'+ $("#txtCurrentUserId").val() +'",';  // ... сверху докидываем id пользователя ...
    strObj = strObj + '"id_record" : "'+ $("#txtRecordId").val() +'"}';             // ... сверху докидываем id записи ...

    var dataObj = JSON.parse(strObj);                                               // ... и форматируем

    $.ajax({type: "POST",
        url:  "bids/saveBidUsers.php",
        data: dataObj,
        success: function(data){
        }
    });
});


//---------------------------------------------------------------------------------------------------------------------
//   Запускает окно подбора на проект команды исполнителей
//
function BidUsersForm(nRecordId_){
    var dataObj = {
        "gnCurrentUserId"  : $("#txtCurrentUserId").val(),
        "id_record"        : nRecordId_
    };
    $.ajax({
        type: "POST",
        url:  "bids/formBidUser.php",
        data: dataObj,
        success: function(data){
            $("#frmBidUser").html(data);
            $("#dlgBidUserForm").modal({backdrop: false});
        }
    })
}



//---------------------------------------------------------------------------------------------------------------------
//   Работа с составом заявки.
//
function BidDetails(nId_){
    var dataObj = {
        "gnCurrentUserId"  : $("#txtCurrentUserId").val(),
        "id_record"        : nId_
    };
    $("#divHeader").html("Работа с составом заявки "+$("#tdBidNum"+nId_).html());
    $("#pnlContent").html("");
    $("#divProgressBar").fadeIn();

    $.ajax({
        type: "POST",
        url:  "bids/formBidDetails.php",
        data: dataObj,
        success: function(data){
            $("#pnlContent").html(data);
            $("#divProgressBar").fadeOut();
        }
    })
}

//---------------------------------------------------------------------------------------------------------------------
//   Сохраняем состав заявки в БД.
//
function saveBidDetails(nIdRecord_, nRowCount_, nColCount_){
    if (confirm("Очистить содержание заявки?")) {
        var strObj = "{";
        $(".stlValue").filter(":visible").each(function(index, element) {   // Перебираем все элементы редактирования, и закидываем их в строку
            // под форматирование в JSON-объект ...
            strObj = strObj + '"'+ $(this).attr("name") + '" : "' + htmlEscape($(this).html()) + '" ,';
        });

        $(".ctrlFormBidEdit").each(function(index, element) {   // Перебираем все элементы редактирования, и закидываем их в строку
            // под форматирование в JSON-объект ...
            strObj = strObj + '"'+ $(this).attr("name") + '" : "' + htmlEscape($(this).val()) + '" ,';
        });

        strObj = strObj + '"gnCurrentUserId" : "'+ $("#txtCurrentUserId").val() +'",';  // ... сверху докидываем id пользователя ...
        strObj = strObj + '"row_count" : "'+ nRowCount_ +'",';
        strObj = strObj + '"col_count" : "'+ nColCount_ +'",';
        if (confirm("Пополнять справочник продукции?")){
            strObj = strObj + '"parse_goods" : "1",';
        }else{
            strObj = strObj + '"parse_goods" : "0",';
        }

        strObj = strObj + '"id_record" : "'+ nIdRecord_ +'"}';             // ... сверху докидываем id записи ...

        var dataObj = JSON.parse(strObj);                                               // ... и форматируем

        $("#pnlContent").html("");
        $("#divProgressBar").fadeIn();

        $.ajax({
            type: "POST",
            url: "bids/clearBidDetails.php",
            data: dataObj,
            success: function (data) {
                if (confirm("Сохранить содержание заявки?")) {
                    $.ajax({
                        type: "POST",
                        url: "bids/saveBidDetails.php",
                        data: dataObj,
                        success: function (data) {
                            $.ajax({
                                type: "POST",
                                url:  "bids/refreshBidDetails.php",
                                data: dataObj,
                                success: function(data){
                                    $("#pnlContent").html(data);
                                    $("#divProgressBar").fadeOut();
                                }
                            })
                        },
                        error:   function(e){alert("Error:"+ e.toString());}
                    })
                }
            },
            error:   function(e){alert("Error:"+ e.toString());}
        })

    }
}

//---------------------------------------------------------------------------------------------------------------------
//   Формирует номер договора договора
//
function getBidCode(){
    $.ajax({
        type: "POST",
        url:  "bids/generateBidCode.php",
        success: function(data){
            $("#txtBidCode").val(data);
        }
    })

}

function CreateBidReport(){
  document.location.href='bids/createBidReport.php';
}


//---------------------------------------------------------------------------------------------------------------------
//   Запуск формирования отчета.
//
function MakeBidReport(cBidId_){
  document.location.href='bids/createReport.php?id_record='+cBidId_;
}

