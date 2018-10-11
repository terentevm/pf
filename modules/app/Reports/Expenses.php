<?php


namespace app\Reports;

use tm\IReport;

use app\mappers\ReportExpensesMapper;
use tm\helpers\DateHelper;

class Expenses implements  IReport
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
            $this->mapper = new ReportExpensesMapper();
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
        // TODO: Implement execute() method.
        $oneMonth = false;

        $month = DateHelper::startOfMonth($this->beginDate, "Y-m-d");

//        if (DateHelper::startOfMonth($this->beginDate, "Y-m-d") == DateHelper::startOfDay($this->beginDate, "Y-m-d")
//            && DateHelper::endOfMonth($this->endDate, "Y-m-d") == DateHelper::endOfDay($this->endDate, "Y-m-d")) {
//            $oneMonth = true;
//        }

        $params =[
            'userId' => $this->userId,
            'filterCurrency' =>$this->currencyId
        ];

        if ($oneMonth === false) {
            $params['beginDate'] =  DateHelper::startOfDay($this->beginDate, "Y-m-d");
            $params['endDate'] =  DateHelper::startOfDay($this->endDate, "Y-m-d");
            $params['items'] = $this->filterItems;
            $params['periodMode'] = $this->periodMode;
        }
        else {
            $params['oneMonth'] = true;
            $params['month'] = $month;
        }

        $result = $this->mapper->execute($params);

        return $result;

    }
}