<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Отчет R-keeper</title>
    <!-- ... -->  <!-- 1. Подключить библиотеку jQuery -->
    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <!-- 2. Подключить скрипт moment-with-locales.min.js для работы с датами -->
    <script type="text/javascript" src="js/moment-with-locales.min.js"></script>
    <!-- 3. Подключить скрипт платформы Twitter Bootstrap 3 -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- 4. Подключить скрипт виджета "Bootstrap datetimepicker" -->
    <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
    <!-- 5. Подключить CSS платформы Twitter Bootstrap 3 -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <!-- 6. Подключить CSS виджета "Bootstrap datetimepicker" -->
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css"/>
    <script type="text/javascript">
        <!--

        function validate_form() {
            var valid = true;
            var firstDate = document.dateForm.firstDate.value;
            var secondDate = document.dateForm.secondDate.value;
            if (firstDate == "") {
                alert("Выберите начальную дату.");
                valid = false;
                return valid;
            }

            if (secondDate == "") {
                alert("Выберите конечную дату.");
                valid = false;
                return valid;
            }
            //var dateOne=new Date(firstDate);
            var dateOne = new Date(firstDate.replace(/(\d+).(\d+).(\d+)/, '$3/$2/$1'));
            var dateSecond = new Date(secondDate.replace(/(\d+).(\d+).(\d+)/, '$3/$2/$1'));
            if (dateOne > dateSecond) {
                alert("Начальная дата больше конечной");
                valid = false;
                return valid;
            }
            return valid;
        }

        //-->
    </script>
</head>
<body style="margin:40px">
<h3 align="center">Формирование отчета</h3>
<p>Выберите пожалуйста отчетный месяц и год</p>
<form name="dateForm" action="report.php" method="post" id="reportBuild" onsubmit="return validate_form();">
    <h2>Начальная дата</h2>
    <div style="width: 250px; float: left;background: #d2d0d2" class="form-group">
        <div class="input-group date" id="datetimepicker1">

            <input name="firstDate" type="text" class="form-control"/>
            <span class="input-group-addon">
      <span class="glyphicon glyphicon-calendar"></span>
    </span>
        </div>
    </div>
    <br>
    <div style="width: 250px;" class="form-group">
        <h2>Конечная дата</h2>
        <div class="input-group date" id="datetimepicker2">
            <input name="secondDate" type="text" class="form-control"/>
            <span class="input-group-addon">
      <span class="glyphicon glyphicon-calendar"></span>
    </span>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            //Установим для виджета русскую локаль с помощью параметра language и значения ru
            $('#datetimepicker1').datetimepicker(
                {minDate: "19/10/2016", pickTime: false, language: 'ru'}
            );
            $('#datetimepicker2').datetimepicker(
                {minDate: "19/10/2016", pickTime: false, language: 'ru'}
            );
        });
    </script>
    <div style="margin-top: 100px">
        <input type="submit" name="send" value="Отправить данные"></p>
    </div>
</form>

</body>
</html>