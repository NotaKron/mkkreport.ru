<?php

/**
 * Created by PhpStorm.
 * User: Admindb
 * Date: 17.07.2017
 * Time: 11:13
 */
class table
{
    private $_dataArray;
    private $_headArray;
    private $_res;
    private $_query;
    private $_arrayFilteredColumns;
    private $_arrayDefaultValues;
    private $_headers;
    private $_countRow = 0;
    function __construct($res, $query)
    {
        $this->_dataArray = $res;
        $this->_res = $res;
        $this->_query = $query;
        $this->_arrayFilteredColumns = $this->getFilteredColumnsArray();
        $this->_headers = array_keys($this->_res[0]);
    }

    public function printTable()
    {
        echo "\r\n<table border =\"1\">\r\n";
        $this->printHead();
        $this->printBody();
        echo "</table>\r\n";
    }

    private function printHead()
    {
        $headArray = array_keys($this->_dataArray[0]);
        echo "\t<tr>\r\n";
        foreach ($headArray as $key => $value) {
            echo "\t\t<th>$value</th>\r\n";
        }
        echo "\t</tr>\r\n";
    }

    private function printBody()
    {
        foreach ($this->_dataArray as $key => $value) {
            echo "\t\t<tr>\r\n";
            foreach ($value as $data) {
                echo "\t\t\t<td>" . $this->checkOnDataType($data) . "</td>\r\n";
            }
            echo " \t\t</tr>\r\n";
        }
    }

    private function checkOnDataType($value)
    {
        if ($value instanceof DateTime) return $value->format('Y-m-d');
        else return $value;
    }
    //////////////////////////////////////////////////////////////


    // Формируем массив нулевыъ значений для сортируемых стобцов
    private function getDefaultArray()
    {

        foreach ($this->_headers as $key) {
            if (in_array($key, $this->_arrayFilteredColumns))
                $this->_arrayDefaultValues[$key] = $this->getContentArray();
        }
    }
    private function getContentArray()
    {

        $content["count"] = 0;
        $content["previousValue"] = 0;
        $uniqContent=$this->getUniqContent();
        return $contentarr = ['default' => array_merge($content,$uniqContent)];
    }
    private function getUniqContent(){
        foreach ($this->_headers as $key) {
            if (!(in_array($key, $this->_arrayFilteredColumns))) {
                $content[$key] = 0;
            }
        }
        return $content;
    }
    private function getFilteredColumnsArray()
    {
        preg_match_all('/\"(.*?)\"/sei', $this->_query, $matches);
        return $matches[1];
    }

//Сортируем таблицу пробегом по всем строкам
    private function countedRows() //переименовать
    {
        foreach ($this->_res as $key => $value) {
            $this->parceRow($value);
            $this->_countRow++;
        }

    }
    private function parceRow($row)
    {
        foreach ($row as $cell => $key) {
            $keyCell = array_search($key, $row);
            if (in_array($keyCell, $this->_arrayFilteredColumns)) {
                $this->checkRepeat($keyCell, $row);
            }
        }
    }
    private function checkRepeat($columnName, $row)
    {
        $key = $row[$columnName];
        $previousColumn = $this->getPreviousCount($this->checkOnDataType($columnName));
        $previousKey = $row[$previousColumn];
        $tmp = $this->getCheckedString($columnName, $key, $previousKey);
        if($columnName=="Cash") {
            print_r($tmp);
            echo "<br>";

        }
        if (($tmp == null) or ($key != key($tmp[$columnName]))) {

            return $this->countRepeats($columnName, $row);
        } else if ($previousKey != $tmp[$columnName][$key]['previousValue']) {
            return $this->countRepeats($columnName, $row);
        } else return '';
    }
    private function getCheckedString($columnName, $cell, $previousCell)
    {

        foreach ($this->_arrayDefaultValues as $key => $value) {
            if (key($value) ==  $this->checkOnDataType($columnName)) {
                $tmp = $value[key($value)];
                if ((key($tmp) == $this->checkOnDataType($cell)) and ($tmp[$cell]["previousValue"] == $previousCell)) {
                    return $value;
                }
            }
        }
    }
    private function countRepeats($columnName, $row)
    {
        $valueCell = $row[$columnName];
        $predColumn = $this->getPreviousCount($columnName);
        $predKey = $row[$predColumn];
        $count = 0;
        $content = $this->getUniqContent();
         for ($i = $this->_countRow; $i < count($this->_res); ++$i) {
            if (($valueCell == $this->_res[$i][$columnName]) and ($predKey == $this->_res[$i][$predColumn])) {
                $content = $this->summCells($this->_res[$i], $content);
                $count++;
            } else {
                break;
            }
        }
        $tmp = $this->getCheckedString($columnName, $valueCell, $predKey);
        if (($tmp == null) or (key($tmp[$columnName]) != 'default')) {
            $this->fillContent($valueCell, $count, $predKey, $content, $columnName);
        }
    }
    private function fillContent($cell, $count, $previousValue, $content, $colName)
    {
        $tmp = null;
        $columnName=$this->checkOnDataType($colName);
        $contentArray["count"] = $count;
        $contentArray["previousValue"] = $previousValue;
        foreach ($content as $key => $value) {
            $contentArray[$key] = $value;
        }
        $cell=$this->checkOnDataType($cell);

        $tmp[$columnName] = [$cell => $contentArray];
        array_push($this->_arrayDefaultValues, $tmp);
    }

    private function summCells($row, $content)
    {
        foreach ($content as $key => $value) {
            $content[$key] = $value + $row[$key];
        }
        return $content;
    }

    private function getPreviousCount($columnName)
    {
        $index = $this->checkOnDataType($columnName);
        foreach ($this->_arrayDefaultValues as $key => $value) {
            if ($columnName != $key) {
                $index = $key;

            } else {
                return $index;
            }
        }
        return $index;
    }

    public function test(){
        $this->getDefaultArray();
        $this->countedRows();
        $tmp = $this->_arrayDefaultValues;
        echo "<br>_________________________________________________________<br>";
         foreach ($tmp as $key) {
            if(key($key)=="Дата"){
                print_r($key);
                 echo "<br>___________________________________<br>";}
         }
    }

}