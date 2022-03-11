
<?php
/*----------------------------------------------------------------------------------------------------------------------
  Базовый модуль системы EsstimateA
  ----------------------------------------------------------------------------------------------------------------------
  User: E. Ryabov
  Date: 19.10.2021
  Time: 22:57:00
  ----------------------------------------------------------------------------------------------------------------------
*/

include("db_connect.php");

// Типы картинок
$arPictureTypes = array ("Фон [ЗАГОЛОВОК]", "Иконки (80x66)", "Комплексы L", "Комплексы M");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="E.Ryabov">

    <title>AdvusNeva. Админка.</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="vendor/bootstrap/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="vendor/bootstrap/css/sb-admin.css" rel="stylesheet">
    <link href="css/admin.css" rel="stylesheet">

    <!-- Bootstrap Core JavaScript -->
    <script type='text/javascript' src="vendor/bootstrap/js/jquery.js"></script>
    <script type='text/javascript' src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type='text/javascript' src="vendor/bootstrap/js/bootstrap-datetimepicker.min.js"></script>

</head>

<body>

    <div id="wrapper">

        <INPUT ID='txtCurrentUserId' NAME='txtCurrentUserId' type='hidden' Value='-1'>
        <INPUT ID='txtCurrentUserName' NAME='txtCurrentUserName' type='hidden' Value=''>
        <INPUT ID='txtCurrentUserLogin' NAME='txtCurrentUserLogin' type='hidden' Value=''>
        <INPUT ID='txtCurrentUserRole' NAME='txtCurrentUserRole' type='hidden' Value='-1'>
        <INPUT ID='txtCurrentUserEmail' NAME='txtCurrentUserEmail' type='hidden' Value=''>
        <INPUT ID='txtCurrentUserPhone' NAME='txtCurrentUserPhone' type='hidden' Value=''>


        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Панель управления</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">AdvusNeva. Админка</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><span id="lblUserName">Admin P.S.</span><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><i class="fa fa-fw fa-user"></i> Профиль</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-fw fa-power-off"></i> Выход</a></li>
                    </ul>
                </li>
            </ul>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li><a onclick="SelectTabBids()" href="#"><i class="fa fa-fw fa-edit"></i> Договора (заявки)</a></li>
                    <li><a onclick="SelectTabDocs(0, '')" href="#">   <i class="fa fa-fw fa-book "></i> Документы компании</a></li>
                    <li><a onclick="SelectTab('tabUsers', '')" href="#">   <i class="fa fa-fw fa-users "></i> Сотрудники</a></li>


                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#lstSpra"><i class="fa fa-fw fa-book"></i> Справочники ... <b class="caret"></b></a>
                        <ul id="lstSpra" class="collapse">
                            <li><a onclick="SelectTab('tabInsurances', 'name')" href="#">   <i class="fa fa-fw fa-book"></i> Страховки</a></li>
                            <li><a onclick="SelectTab('tabCustomers', 'name')" href="#">      <i class="fa fa-fw fa-book"></i> Клиенты</a></li>
                        </ul>
                    </li>
                    <li><a onclick="SelectOptions()" href="#"><i class="fa fa-fw fa-cog"></i> Настройки</a></li>
                    <li><a href="bids/test.php">   <i class="fa fa-fw fa-users "></i> TEST</a></li>

                </ul>
            </div>
                <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12" id="pnlLeftPage">
                        <!-- Content -->
                        <h3 id="divHeader" class="page-header" style="padding-bottom: 50px; !important"></h3>
                        <div id="divProgressBar" class="progress">
                          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:80%">Идет загрузка данных...</div>
                        </div>
                        <div id="pnlContent">
                        </div>
                    </div>

                </div> <!-- /.row -->
            </div>    <!-- /.container-fluid -->
        </div>     <!-- /#page-wrapper -->
    </div>        <!-- /#wrapper -->



    <!-- Modal -->
    <!--  Форма ввода пароля @frmLogin  -->
    <div class="modal fade form-group-sm" id="frmLogin" role="dialog" data-backdrop="true">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content modal-sm">
                <div class="modal-header" style="padding:10px 50px;">
                    <h4><span class="glyphicon glyphicon-lock"></span> Вход в систему</h4>
                </div>
                <div class="modal-body" style="padding:20px 50px;">
                    <form role="form">
                        <div class="form-group" id="fgPassword" >
                            <input type="password" class="form-control" name="txtPassword" id="txtPassword" placeholder="Введите пароль">
                        </div>
                        <div class="alert alert-danger hide" id="divWrongPassword">
                            <strong>Внимание!</strong> Пароль не корректен!
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" id="btnLogin">Вход</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Редактирвоание позиции списке скриптов  @dlgUploadForm  (БЕЗ КНОПКИ) -->
    <div class="modal fade" id="dlgUploadForm" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header hdrDialog">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="HeaderSection" id="headerUploadForm">Загрузка заглавного фото сайта</h4>
                </div>
                <div class="modal-body" id="frmUploadEdit" style="padding-bottom: 150px">
                </div>
            </div>
        </div>
    </div>


    <script>

        $(document).ready(function(){

//            SelectTab("tabCustomers");
// Activate authorisation
            $(".nav li a").addClass("disabled");
            $("#frmLogin").modal({backdrop: false, keyboard: false});
            $("#txtPassword").focus();
//Disactivate!!!!!!!!!!
            /*
             $("#lblUserName").html("Иванов П.С.");
             $("#txtCurrentUserId").val("19");
             */


            $("#txtPassword").keypress(function(e) {
                if (e.keyCode == 13) {
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
                            $("#lblUserName").html(data.Name);
                            $("#txtCurrentUserId").val(data.Id);
                            $("#txtCurrentUserName").val(data.Name);
                            $("#txtCurrentUserLogin").val(data.Login);
                            $("#txtCurrentUserRole").val(data.Role);
                            $("#txtCurrentUserEmail").val(data.Email);
                            $("#txtCurrentUserPhone").val(data.Phone);

                            // Заполняем страницу ключей
                            $("#txtLoginSuccess").val("1");
                            $(".nav li a").removeClass("disabled");

                            SelectTabBids();

                            $('#frmLogin').modal('hide')
                        }else{
                            $("#divWrongPassword").removeClass("hide").html("<strong>Внимание!</strong> Пароль неверный!").fadeIn();
                        }
                    }
                })
            }
        })

    </script>


    <!-- Редактирвоание позиции справочника  @dlgSpraEditForm  -->
    <div class="modal fade" id="dlgSpraEditForm" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header hdrDialog">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="HeaderSection" id="headerForm">Редактирование позиции справочника</h4>
                </div>
                <div class="modal-body">
                    <form role="form" >
                        <div class="form-group" id="frmSpraEdit">
                        </div>
                        <div class="modal-footer">
                            <button type="button" btn-default class="btn btn-primary" data-dismiss="modal" id="btnSaveSpraEditForm"><i class='fa fa-fw fa-save'></i>Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Редактирвоание позиции базе аналогов  -->
    <div class="modal fade" id="dlgAnalogueEditForm" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header hdrAnalogueDialog">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="HeaderSection" id="headerAnalogueForm">Редактирование позиции в базе аналогов</h4>
                </div>
                <div class="modal-body">
                    <form role="form" >
                        <div class="form-group" id="frmAnalogueEdit">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnSaveAnalogueEditForm"><i class='fa fa-fw fa-save'></i>Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Выбор позиции из базы аналогов  -->
    <div class="modal fade" id="dlgGetAnalogueForm" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header hdrGetAnalogueDialog">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="HeaderSection" id="headerGetAnalogueForm">Выбор позиции из базы аналогов</h4>
                </div>
                <div class="modal-body">
                    <form role="form" >
                        <div class="form-group" id="frmGetAnalogue">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Редактирвоание позиции в базе заявок @dlgBidEditForm  -->
    <div class="modal fade" id="dlgBidEditForm" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header hdrDialog">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="HeaderSection" id="headerSiteForm">Редактирование заявки</h4>
                </div>
                <div class="modal-body">
                    <form role="form" >
                        <div class="form-group" id="frmBidEdit">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnPrintBill" onclick="PrintDoc('CONTRACT')"><i class='fa fa-fw fa-print'></i>Печатать договор</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnSaveBidEditForm"><i class='fa fa-fw fa-save'></i>Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Редактирвоание состава команды по договору @dlgBidUserForm  -->
    <div class="modal fade" id="dlgBidUserForm" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header hdrDialog">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="HeaderSection" id="headerSiteForm">Состав исполнителей</h4>
                </div>
                <div class="modal-body">
                    <form role="form" >
                        <div class="form-group" id="frmBidUser">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" id="btnSaveBidUserForm"><i class='fa fa-fw fa-save'></i>Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Редактирвоание позиции списке скриптов  @dlgUploadForm  (БЕЗ КНОПКИ) -->
    <div class="modal fade" id="dlgUploadForm" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header hdrDialog">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="HeaderSection" id="headerUploadForm">Загрузка заглавного фото сайта</h4>
                </div>
                <div class="modal-body" id="frmUploadEdit" style="padding-bottom: 150px">
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Core JavaScript -->
    <script type='text/javascript' src='js/navigation.js'></script>
    <script type='text/javascript' src='js/spra.js'></script>
    <script type='text/javascript' src='js/bids.js'></script>
    <script type='text/javascript' src='js/attach.js'></script>


    <script type='text/javascript' src="vendor/bootstrap/js/moment-with-locales.min.js"></script>
    <script type='text/javascript' src="vendor/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
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


</body>

</html>
