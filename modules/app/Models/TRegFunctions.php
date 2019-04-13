<?php

namespace app\Models;


trait TRegFunctions
{
    private function storeToRegMoneyTransactions()
    {
        $regMoney = new RegMoneyTransactions();
        $regMoney->loadModel($this);
        $success = $regMoney->save(false);

        if ($success === false) {
            return false;
        }
    }
}