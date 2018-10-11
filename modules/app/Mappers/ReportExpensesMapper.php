<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\mappers;

/**
 * Description of ReportExpensesMapper
 *
 * @author terentyev.m
 */
use tm\database\Connection;
use tm\database\DBCommand;

class ReportExpensesMapper
{

    private $dbConn = null;
    private $dbCommand = null;

    public function  execute(array $params)
    {
        $this->dbConn = Connection::init();
        $this->dbCommand = new DBCommand($this->dbConn);

        $oneMonth = isset($params['oneMonth']) && $params['oneMonth'] === true ? true: false;

        $sql = $oneMonth === true ? $this->getSQLOneMonth() : $this->getSQLPeriod();

        $paramsSQL = [
            'userId' => $params['userId'],
            'filterCurrency' => $params['filterCurrency']
        ];

        if ($oneMonth === true) {
            $paramsSQL['month'] = $params['month'] ;
        }
        else {
            $paramsSQL['beginDate'] = $params['beginDate'] ;
            $paramsSQL['endDate'] = $params['endDate'] ;
            $paramsSQL['periodMode'] = $params['periodMode'] ;

            if (isset($params['items'])) {
                $strItems =  $this->convertItemsToString($params['items']);
                $paramsSQL['items'] =$strItems;
            }
            else {
                $paramsSQL['items'] = "";
            }
        }

        $result = $this->dbCommand->query($sql, $paramsSQL);

        return $result;

    }

    private function getSQLPeriod()
    {
        return "CALL reportExpensesByPeriod(:userId, :beginDate, :endDate, :filterCurrency, :items, :periodMode);";
    }

    private function getSQLOneMonth()
    {
        return "CALL reportExpensesMonth(:userId, :month, :filterCurrency);";
    }

    private function convertItemsToString(array $items)
    {

        $addQuotes = function ($currentStr)
        {
            return "'" . $currentStr . "'";
        };

        $items = array_map($addQuotes, $items);

        $result = "" . implode(",", $items) . "";

        return $result;
    }
}
