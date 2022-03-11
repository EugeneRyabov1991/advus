/**
 * Created by E.Ryabov on 29.11.2016.
 */

$(document).ready(function(){



// Activate authorisation
    /*
    $("#wrapper").addClass("hide");
    $(".nav li a").addClass("disabled");
    $("#frmLogin").modal({backdrop: false, keyboard: false});
    $("#txtPassword").focus();
     */
//Disactivate!!!!!!!!!!
     $("#lblUserName").html("Иванов П.С.");
     $("#txtCurrentUserId").val("19");


    $("#txtPassword").keypress(function(e) {
        if (e.keyCode == 13) {  // <Enter>
            bOk = true;
            $('#btnLogin').click();
            return false;          // Обязательно возвращаем FALSE!!!
                                   // В противном случае после всех дел произойдет перзагрузка страницы и окно появится заново
        }
        return true;
    });
});


$('#btnLogin').click(function(){
    if ($("#txtPassword").val() == ""){
        $("#fgPassword").addClass("has-error");
        $("#divWrongPassword").removeClass("hide").html("<strong>Внимание!</strong> Пароль не может быть пустым!").fadeIn();
    }else{
        var dataObj = {
            "txtPassword"   : $("#txtPassword").val()
        };
        $.ajax({
            type: "POST",
            url:  "checkpassword.php",
            data: dataObj,
            dataType: "JSON",
            success: function(data){
                if (data.bOk == "1"){
                    $("#wrapper").removeClass("hide");
                    $("#lblUserName").html(data.cName);
                    $("#txtCurrentUserId").val(data.nId);
                    // Заполняем страницу ключей
                    $("#txtLoginSuccess").val("1");
                    $(".nav li a").removeClass("disabled");
                    SelectTab("tabHouse", "", 0);
                    $('#frmLogin').modal('hide')
                }else{
                    $("#divWrongPassword").removeClass("hide").html("<strong>Внимание!</strong> Пароль неверный!").fadeIn();
                }
            }
        })
    }
})
