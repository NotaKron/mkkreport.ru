<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Отчет по гостям</title>
    <style>
        table {
            width: 80%;
            border-spacing: 1px;
            align-content: center;
            margin-left: 40px;
        }
    </style>
</head>
<body>
<h2 align="center"> ОТЧЕТ</h2>
<!--<table border="1">
    <tr>
        <th rowspan="2">Дата смены</th>
        <th rowspan="2">Подразделение</th>
        <th rowspan="2">Час</th>
        <th colspan="3">Кол-во чеков</th>
        <th colspan="3">Кол-во гостей</th>
    </tr>
    <tr>
        <th>Создано за час </th>
        <th>Закрыто за час </th>
        <th>Разница чеков</th>
        <th>Пришло за час </th>
        <th>Ушло за час </th>
        <th>Разница гостей</th>
    </tr>*/!-->
    <?php
    /**
     * Created by PhpStorm.
     * User: Admindb
     * Date: 06.04.2017
     * Time: 9:32
     */

    $firstDate = new DateTime($_POST['firstDate']);
    $secondDate = new DateTime($_POST['secondDate']);
    $difference = date_diff($firstDate, $secondDate)->days + 1;
    $first=$firstDate->format('d-m-Y H:i');
    $second=$secondDate->format('d-m-Y H:i');
    echo "<br> first: $first <br>";
    echo "second: $second <br>";
    require_once './Modules/MsSQL.php';
    $sqlQuery="set DATEFORMAT dmy

declare @Date1 DateTime ='$first'
declare @Date2 DateTime = '$second'
Select 
    DateAdd(day,DateDiff(day,0,T.[DATE]),0) as \"Дата\",
	X.CTG1_N as \"Категория\",
	X.NAME,
	sum(case when T.ACTIVITY=1 and T.QUANT > 0 then 1 else T.QUANT end) as [Количество игр],
    sum(case when T.ACCOUNT_TYPE not in (2, 33) then -T.VALUE else 0 end) as [Количество очков],
    sum(case when T.ACCOUNT_TYPE=2 then T.VALUE else 0 end) as COUPONS,
   sum(case when T.ACCOUNT_TYPE=33 then T.VALUE else 0 end) as TicketsDispense
FROM 
	[gkArcade].[gk].[GK_TRANSACTS] T
	left join (Select *, -ISNULL(LogicMidnight,0) as LM From gk.ARCADE) AR on AR.ID = T.ARCADE
	left join gk.MachinesViewX X on T.CREATORADDR = X.MACHINE
WHERE 
	(DateAdd(Hour,LM,T.[DATE])>=@Date1 and DateAdd(Hour,LM-24,T.[DATE])<=@Date2)
	and T.CREATOR=1 and T.ACCOUNT_TYPE not in (3, 32)

Group by DateAdd(day,DateDiff(day,0,T.[DATE]),0),
X.CTG1_N,
X.NAME
ORDER BY  DateAdd(day,DateDiff(day,0,T.[DATE]),0),X.CTG1_N, X.NAME";
    $con = new MsSQL('Password=12Fltzkja;Persist Security Info=True;User ID=sa;Initial Catalog=gkArcade;Data Source=172.16.42.18;');
    $dataArray = $con->getResult($sqlQuery);
    /*       foreach ($dataArray as $key =>$value){
           echo $key.":    ";
@@ -113,9 +113,9 @@ ORDER BY  DateAdd(day,DateDiff(day,0,T.[DATE]),0)';
    $con = new MsSQL('Password=12Fltzkja;Persist Security Info=True;User ID=sa;Initial Catalog=gkArcade;Data Source=172.16.42.18;');
    echo $sqlQuery;
    $dataArray = $con->getResult($sqlQuery);
    /*       foreach ($dataArray as $key =>$value){
           echo $key.":    ";
           print_r($value);
           echo "<br>"     }
     /*  $categoryArray = array_unique(array_column($dataArray, 'ORDERCATEGORY'));
       $countDate = 0;
       $countCategory = count($categoryArray);
       $dateSize = $countCategory * 24;
       $maxSize = $difference * $dateSize;
       $currentDateCount = 0;
       $currentCategoryCount = 0;
       $f = new DateTime('09:00');
      for ($i = 0; $i < $maxSize; $i++) {
           echo "<tr>";
           if ($i == $currentDateCount) {
               echo "<td rowspan=\"$dateSize \">" . date_format($firstDate->modify("+$countDate day"), 'd-m-Y') . " </td>";
               $countDate++;
               $currentDateCount += $dateSize;
               reset($categoryArray);
           }
           if ($i == $currentCategoryCount) {
               echo "<td rowspan=\"24\">" . current($categoryArray) . " </td>";
               next($categoryArray);
               $f = new DateTime('09:00');
               $currentCategoryCount += 24;
           }

           $s = $f->modify("+1 hour");
           echo "<td>" . date_format($s, "H:i") . " </td>";
           echo "<td> </td>";
           echo "<td> </td>";
           echo "<td> </td>";
           echo "<td> </td>";
           echo "<td> </td>";
           echo "<td> </td>";
           echo "</tr>";
       }

   */
  echo"<br>___________________________________________________________<br>_______________________________________________________<br>";
    require_once 'table.php';
    require_once  'Modules/textModules.php';
    $union = new textModules();
    $union->getUnionFieldsFromMsSQL($sqlQuery);
    $table=new table($dataArray,$sqlQuery);
    $table->test();
    ?>
<!--</table>!-->
</body>
</html>