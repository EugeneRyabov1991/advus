/**---------------------------------------------------------------------------------------------
 * @Author  E.Ryabov on 29.11.2021.
 * @Project CRM Advus
 *-----------------------------------------------------------------------------------------------
 *    Диспетчер, загружает содержимое страниц,  при нажании на соответствующий раздел
 */
function SelectTab(TabName, cSortField_, nFilterId_) {
    var nInvoiceType = -1;
    var cHeader = "", cFuncName = "", cInsertFuncName = "", cInsertButtonCaption = "";
    var bGo = true;
    var cMode = "";
    switch (TabName){
        case "tabUsers":
            cHeader = "Сотрудники";
            cFuncName = "spra/refreshSpraList.php";
            cMode = "USERS";
            cInsertFuncName = "InsertSpraRecord(\""+cMode+"\")";
            cInsertButtonCaption = "Новый сотрудник";
            break;
        case "tabInsurances":
            cHeader = "Страховки";
            cFuncName = "spra/refreshSpraList.php";
            cMode = "INSURANCES";
            cInsertFuncName = "InsertSpraRecord(\""+cMode+"\")";
            cInsertButtonCaption = "Новая страховка";
            break;
        case "tabDocuments":
            if (nFilterId_ == 0) cHeader = "Документы компании";
            else                 cHeader = "Документы сотрудника ["+nFilterId_+"]";

            cFuncName = "spra/refreshSpraList.php";
            cMode = "DOCS";
            cInsertFuncName = "InsertSpraRecord(\""+cMode+"\")";
            cInsertButtonCaption = "Новый документ";
            break;
        default :
            bGo = false;
    }
    if (bGo){
      $("#pnlContent").html("");
      $("#divProgressBar").fadeIn();
      $("#divHeader").html(cHeader);
      $("#divHeader").html("<div class='col-sm-9'>"+cHeader+"</div>" +
            "<div class='col-sm-3'><a class='btn btn-primary btn-lg marginB10' role='button'  onClick='"+cInsertFuncName+"'><i class='fa fa-lg fa-plus-square marginR5'></i>"+cInsertButtonCaption+"</a></div>");


      var dataObj = {
        "gnCurrentUserId"   : $("#txtCurrentUserId").val(),
        "gcMode"            : cMode,
        "gcSortField"       : cSortField_,
        "gcFilter"          : nFilterId_,
        "nInvoiceType"      : nInvoiceType
      };
      $.ajax({
             type: "POST",
             data: dataObj,
             url:  cFuncName,
             success: function(data){     // в параметр [data] возвращается отформатированная строка таблицы с данными по новому городу
                        $("#pnlContent").html(data);
                        $("#divProgressBar").fadeOut();
                     },
             error:   function(e){alert("Error:"+ e.toString());}
      });
    }
}

/*-----------------------------------------------------------------------------------------------
*    Запускает страницу "настройки"
*/
function SelectOptions() {
        $("#pnlContent").html("");
        $("#divProgressBar").fadeIn();
        $("#divHeader").html("Настройки");
        $.ajax({
            type: "POST",
            url:  "options/tools.php",
            success: function(data){     // в параметр [data] возвращается отформатированная строка таблицы с данными по новому городу
                $("#pnlContent").html(data);
                $("#divProgressBar").fadeOut();
            },
            error:   function(e){alert("Error:"+ e.toString());}
        });
}

/*-----------------------------------------------------------------------------------------------
*    Диспетчер, загружает список документов
*/
function SelectTabDocs(nFilterId_, cUserName_) {
    var nInvoiceType = -1;
    var cHeader = "", cFuncName = "", cInsertFuncName = "", cInsertButtonCaption = "";
    var bGo = true;
    var cMode = "";
    if (nFilterId_ == 0) cHeader = "Документы компании";
    else                 cHeader = "<a class='btn btn-primary btn-lg marginB10' role='button'  onClick='SelectTab(\"tabUsers\", \"\")' title='К списку сотрудников'><i class='fa fa-lg fa-backward marginR5'></i></a> Документы сотрудника ["+ cUserName_+"]";

    $("#pnlContent").html("");
    $("#divProgressBar").fadeIn();

    $("#divHeader").html("<div class='col-sm-9'>"+cHeader+"</div>" +
            "<div class='col-sm-3'><a class='btn btn-primary btn-lg marginB10' role='button'  onClick='InsertSpraRecord(\"DOCS\")'><i class='fa fa-lg fa-plus-square marginR5'></i>Новый документ</a></div>");


    var dataObj = {
        "gnCurrentUserId"   : $("#txtCurrentUserId").val(),
        "gcMode"            : "DOCS",
        "gcSortField"       : "caption",
        "userName"          : cUserName_,
        "gcFilter"          : nFilterId_
    };

        $.ajax({
            type: "POST",
            data: dataObj,
            url:  "spra/refreshSpraList.php",
            success: function(data){     // в параметр [data] возвращается отформатированная строка таблицы с данными по новому городу
                $("#pnlContent").html(data);
                $("#divProgressBar").fadeOut();
            },
            error:   function(e){alert("Error:"+ e.toString());}
        });
}

//---------------------------------------------------------------------------------------------------------------------
//   Обработчик нажания кнопки "Сохранить" в форме настройки.
//
//$("#btnSaveTools").click(function () {
 function saveTools() {
    var strObj = "{";
    $(".ctrlFormToolsEdit").each(function(index, element) {   // Перебираем все элементы редактирования, и закидываем их в строку
        // под форматирование в JSON-объект ...
        strObj = strObj + '"'+ $(this).attr("name") + '" : "' + htmlEscape($(this).val()) + '" ,';
    });

    $(".ctrlFormToolsCheckbox").each(function(index, element) {   // Перебираем все checkbox'ы
        strObj = strObj + '"'+ $(this).attr("name") + '" : "' + ($(this).prop("checked") ? "on" : "off") + '" ,';
    });

   strObj = strObj + '"id_record" : "'+ $("#txtRecordId").val() +'"}';             // ... сверху докидываем id записи ...


    var dataObj = JSON.parse(strObj);                                               // ... и форматируем

    $.ajax({type: "POST",
        url:  "options/saveTools.php",
        data: dataObj,
        success: function(data){
        }
    });
};

function TestExcel(){
	    var dataObj = {
        "gnCurrentUserId"   : $("#txtCurrentUserId").val(),
        "nGoodId"           : 24
    };
    alert("Go!!!!");
    $("#divProgressBar").fadeIn();
    $.ajax({
        type: "POST",
        data: dataObj,
        url:  "parseAnalogueFile.php",
        success: function(data){     // в параметр [data] возвращается отформатированная строка таблицы с данными по новому городу
            $("#pnlContent").html(data);
//            $("#tdRecordDetail"+nId_).html(data);
            $("#divProgressBar").fadeOut();
        },
        error:   function(e){alert("Error:"+ e.toString());}
    });


}