<?php
/**
 * Created by PhpStorm.
 * User: zaich
 * Date: 17-Oct-18
 * Time: 22:47:13
 */

namespace app\Reports;

use tm\IReport;

use app\mappers\ReportIncomesMapper;
use tm\helpers\DateHelper;

class Incomes implements IReport
{
    private $beginDate;
    private $endDate;
    private $filterItems = [];
    private $byMonth = 0;
    private $currencyId = null;
    private $userId = null;
    private $periodMode = 0;

    private $mapper = null;

    public function __construct()
    {
        if ($this->mapper == null) {
            $this->mapper = new ReportIncomesMapper();
        }
    }

    /**
     * @return mixed
     */
    public function getBeginDate()
    {
        return $this->beginDate;
    }

    /**
     * @param mixed $beginDate
     */
    public function setBeginDate($beginDate): void
    {
        $this->beginDate = $beginDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return array
     */
    public function getFilterItems(): array
    {
        return $this->filterItems;
    }

    /**
     * @param array $filterItems
     */
    public function setFilterItems(array $filterItems): void
    {
        $this->filterItems = $filterItems;
    }

    /**
     * @return int
     */
    public function getByMonth(): int
    {
        return $this->byMonth;
    }

    /**
     * @param int $byMonth
     */
    public function setByMonth(int $byMonth): void
    {
        $this->byMonth = $byMonth;
    }

    /**
     * @return null
     */
    public function getCurrencyId()
    {
        return $this->currencyId;
    }

    /**
     * @param null $currencyId
     */
    public function setCurrencyId($currencyId): void
    {
        $this->currencyId = $currencyId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function setPeriodMode(int $mode) : void
    {
        $this->periodMode = $mode;
    }

    public function execute(): array
    {

        $params =[
            'userId' => $this->userId,
            'filterCurrency' =>$this->currencyId
        ];


        $params['beginDate'] =  DateHelper::startOfDay($this->beginDate);
        $params['endDate'] =  DateHelper::endOfDay($this->endDate);
        $params['items'] = $this->filterItems;
        $params['periodMode'] = $this->periodMode;

        try {
            $result = $this->mapper->execute($params);
        }
        catch (\Throwable  $e) {
            throw new \Exception($e->getMessage()) ;
        }


        return $result;

    }
}