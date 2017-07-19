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

    function __construct($dataArray)
    {
        $this->_dataArray = $dataArray;
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
            echo " \t\t\<tr>\r\n";
            foreach ($value as $data) {
                echo "\t\t\t<td>" . $this->checkOnDataType($data) . "</td>\r\n";
            }
            echo " \t\t\</tr>\r\n";
        }
    }

    private function checkOnDataType($value)
    {
        if ($value instanceof DateTime) return $value->format('Y-m-d');
        else return $value;
    }
}