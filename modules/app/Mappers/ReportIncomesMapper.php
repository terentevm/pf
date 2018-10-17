<?php
/**
 * Created by PhpStorm.
 * User: zaich
 * Date: 17-Oct-18
 * Time: 22:43:06
 */

namespace app\mappers;

use tm\database\Connection;
use tm\database\DBCommand;

class ReportIncomesMapper
{
    private $dbConn = null;
    private $dbCommand = null;

    public function  execute(array $params)
    {
        $this->dbConn = Connection::init();
        $this->dbCommand = new DBCommand($this->dbConn);

        $sql = $this->getSQL();

        $paramsSQL = [
            'userId' => $params['userId'],
            'filterCurrency' => $params['filterCurrency']
        ];


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

        $result = $this->dbCommand->query($sql, $paramsSQL);

        return $result;

    }

    private function getSQL()
    {
        return "CALL reportIncomesByPeriod(:userId, :beginDate, :endDate, :filterCurrency, :items, :periodMode);";
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