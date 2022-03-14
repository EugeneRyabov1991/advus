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
          }
    });
});


//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Сохранить" в форме редактирования состава заявки.
//
function SaveBidDetails(nIdBid_) {

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
        url:  "bids/saveBidDetails.php",
        data: dataObj,

        success: function(data){
          alert("Данные сохранены")
        }
    });
};

//---------------------------------------------------------------------------------------------------------------------
//   Запуск составления счета и акта (по заявке).
//
function PrintDoc(cType_){
    if (cType_ == "CONTRACT"){
       document.location.href='bids/createContract.php?id_record='+$("#txtRecordId").val();
    } else  if (cType_ == "BILL"){
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


//---------------------------------------------------------------------------------------------------------------------
//   Работа с составом заявки
//
function InsertBidSubj(nIdBid_){
    var dataObj = {
        "id_bid"            : nIdBid_,
        "gnCurrentUserId"   : $("#txtCurrentUserId").val()
    };
    $.ajax({
        type: "POST",
        url:  "bids/subject/insertBidSubject.php",
        data: dataObj,
        success: function(objRecord_){     // в параметр objRecord_ возвращается JSON-объект с данными по конкретной записи справочника
            $("#trBidSubjectHeader").after(objRecord_);
        },
        error:   function(e){alert("Error:"+ e.toString());}
    });
}

function DeleteBidSubj(nIdBidSubj_){
    if (confirm("Bы уверены, что хотите удалить позицию в предмете договора?")){
        var dataObj = {
            "id_record" : nIdBidSubj_,
            "gnCurrentUserId"   : $("#txtCurrentUserId").val()
        };
        $.ajax({
            type: "POST",
            url:  "bids/subject/deleteBidSubject.php",
            data: dataObj,
            success: function(data){
                $("#trRecord"+nIdBidSubj_).fadeOut(100);
            },
            error:   function(e){alert("Error:"+ e.toString());}
        });
    }
}

function showBidSubjEditForm(nIdBidSubj_){
    var dataObj = {
        "gnCurrentUserId"  : $("#txtCurrentUserId").val(),
        "id_record"        : nIdBidSubj_
    };
    $.ajax({
        type: "POST",
        url:  "bids/subject/formBidSubjEdit.php",
        data: dataObj,
        success: function(data){
            $("#frmBidSubjEdit").html(data);
            $("#dlgBidSubjEditForm").modal({backdrop: false});
        }
    })
}


//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Сохранить" в форме редактирования состава исполнитлей заявки.
//
$("#btnSaveBidSubj").click(function () {
    var strObj = "{";
    $(".ctrlFormBidSubj").each(function(index, element) {   // Перебираем все элементы редактирования, и закидываем их в строку
        // под форматирование в JSON-объект ...
        strObj = strObj + '"'+ $(this).attr("name") + '" : "' + htmlEscape($(this).val()) + '" ,';
    });

    strObj = strObj + '"gnCurrentUserId" : "'+ $("#txtCurrentUserId").val() +'",';  // ... сверху докидываем id пользователя ...
    strObj = strObj + '"id_record" : "'+ $("#txtBidSubjId").val() +'"}';             // ... сверху докидываем id записи ...

    var dataObj = JSON.parse(strObj);                                               // ... и форматируем

    $.ajax({type: "POST",
        url:  "bids/subject/saveBidSubj.php",
        data: dataObj,
        success: function(data){
            $("#tdBidSubjNum"+$("#txtBidSubjId").val()).html($("#txtBidSubjNum").val());
            $("#tdBidSubjName"+$("#txtBidSubjId").val()).html($("#txtBidSubjName").val());
        }
    });
});

