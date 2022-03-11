/**---------------------------------------------------------------------------------------------------------------------
 *   Функции работы с прикрепленными файлами
 * ---------------------------------------------------------------------------------------------------------------------
 * @User: E.Ryabov
 * @Date: 03.09.18
 * ---------------------------------------------------------------------------------------------------------------------
 */


/*---------------------------------------------------------------------------------------------------
 *  Сохраняет название для attach'a.
 */
function saveAttachName(nAttachId_){
    var dataObj = {
        "attach_name"  : $("#txtAttachName"+nAttachId_).val(),
        "id_record"    : nAttachId_
    };
    var cFuncName = "attach/saveAttachName.php";
    $.ajax({
        type: "POST",
        url:  cFuncName,
        data: dataObj,
        success: function(data){
        }
    })
}

/*---------------------------------------------------------------------------------------------------
 *  Удалить attach'a.
 */
function deleteAttach(nAttachId_){
    if (confirm("Bы уверены, что хотите удалить прикрепленный файл?")){
        var dataObj = {
            "id_record" : nAttachId_,
            "gnCurrentUserId"   : $("#txtCurrentUserId").val()
        };
        $.ajax({
            type: "POST",
            url:  "attach/deleteAttach.php",
            data: dataObj,
            success: function(data){
                $("#divAttach"+nAttachId_).fadeOut(100);
            },
            error:   function(e){alert("Error:"+ e.toString());}
        });
    }
}
