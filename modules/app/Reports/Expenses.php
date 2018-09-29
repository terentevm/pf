<?php


namespace app\Reports;

use tm\IReport;

use app\mappers\ReportExpensesMapper;

class Expenses implements  IReport
{
    private $beginDate;
    private $endDate;
    private $filterItems = [];
    private $byMonth = 0;
    private $currencyId = null;

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


    public function execute(): array
    {
        // TODO: Implement execute() method.
    }
}