<?php
namespace app\Controllers;

use tm\Registry as Reg;
use tm\RestController;
use tm\helpers\DateHelper;
use Respect\Validation\Validator as v;
use app\Models\Wallet;

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
     *  beginData string 'Y-m-d' 
     *  endData string 'Y-m-d' 
     *  items array contains items id
     *  filterCurrency - currency id (uid). Amounts should be recalculated to this currency.
     *                  If currency id hasn't been pointed out, ammounts will be racalculated to system currency
     */
    public function actionExpenses()
    {
        $post = Reg::$app->request->post();
    }

    /**
     * Returns expences by items for period.
     * The following parameters are allowed
     *  beginData string 'Y-m-d' 
     *  endData string 'Y-m-d' 
     *  items array contains items id
     *  filterCurrency - currency id (uid). Amounts should be recalculated to this currency.
     *                  If currency id hasn't been pointed out, ammounts will be racalculated to system currency
     */
    public function actionIncomes()
    {
        $post = Reg::$app->request->post();
    }
}