<?php
namespace app\Controllers;

use tm\Registry as Reg;
use tm\RestController;
use tm\helpers\DateHelper;
use Respect\Validation\Validator as v;
use app\Models\Wallet;
use app\Reports\Expenses;

class ReportsController extends RestController
{
    /**
     * Returns all wallets balance on date
     * parametres should be get from POST
     * parametres:
     * data - balance on this data
     *        If date hasn't been pointed out, current date will be used as date parametr
     * filterCurrency - currency id (uid). Amounts should be recalculated to this currency.
     *                  If currency id hasn't been pointed out, ammounts will be racalculated to system currency
     */
    public function actionBalance()
    {
        $post = Reg::$app->request->post();
        if (isset($post['date']) && v::date('Y-m-d')->validate($post['date'])) {
            $date = strtotime($post['date']);
        }
        else {
            $date = time();
        }
        
        $userId = $this->user_id;
        
        $currencyId = null;
        
        if (isset($post['filterCurrency'])) {
            $currencyId = filter_var($post['filterCurrency'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        $dataset = Wallet::balanceAllWallets($userId, $date, $currencyId);
        
        return $this->createResponse($this->createResponseData(true, $dataset, "OK"), 200);
    }


    /**
     * Returns expences by items for period.
     * The following parameters are allowed
     *  beginDate string 'Y-m-d'
     *  endDate string 'Y-m-d'
     *  period int 0 - without period, 1: byDay 2: byMonth
     *  items array contains items id
     *  filterCurrency - currency id (uid). Amounts should be recalculated to this currency.
     *                  If currency id hasn't been pointed out, ammounts will be racalculated to system currency
     */
    public function actionExpenses()
    {
        $post = Reg::$app->request->post();

        if (isset($post['beginDate']) && v::date('Y-m-d')->validate($post['beginDate'])) {
            $beginDate = strtotime($post['beginDate']);
        }
        else {
            $beginDate = time();
        }

        if (isset($post['endDate']) && v::date('Y-m-d')->validate($post['endDate'])) {
            $endDate = strtotime($post['endDate']);
        }
        else {
            $endDate = time();
        }

        $byMonth = $post['byMonth'] ?? 0;

        $itemsFilter = [];

        if (isset($post['items']) && is_array($post['items']) && !empty($post['items'])) {
            $itemsFilter = $post['items'];
        }

        $filterCurrency = $post['$filterCurrency'] ?? null;

        $report = new Expenses();
        $report->setBeginDate($beginDate);
        $report->setEndDate($endDate);
        $report->setCurrencyId($filterCurrency);
        $report->setByMonth($byMonth);
        $report->setFilterItems($itemsFilter);

        try {
            $result = $report->execute();
            return $this->createResponse($this->createResponseData(true, $result, "OK"), 200);
        }
        catch (Exception $e) {
            return $this->createResponse($this->createResponseData(false, [], "Some Error"), 500);
        }



    }

    /**
     * Returns expences by items for period.
     * The following parameters are allowed
     *  beginData string 'Y-m-d' 
     *  endData string 'Y-m-d'
     *  period int 0 - without period, 1: byDay 2: byMonth
     *  items array contains items id
     *  filterCurrency - currency id (uid). Amounts should be recalculated to this currency.
     *                  If currency id hasn't been pointed out, ammounts will be racalculated to system currency
     */
    public function actionIncomes()
    {
        $post = Reg::$app->request->post();
    }
}