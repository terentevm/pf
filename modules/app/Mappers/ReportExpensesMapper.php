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
class ReportExpensesMapper
{
    //put your code here
    
    private function getSQL()
    {
        return "select
            reg.docDate,
            reg.walletId,
            wallets.currency_id as currency_id,
            reg.docId,
            expRows.item_id,
            items.name,
            SUM(expRows.sum)
        FROM 
                (SELECT 
                        reg.expend_id as docId,
                        reg.date as docDate,
                        reg.wallet_id as walletId
                FROM
                        money.regMoneyTrans as reg
                WHERE
                        reg.date >= date('20180101') AND reg.date <= date('20181231') AND reg.expend_id IS NOT NULL
                group by
                        reg.expend_id, reg.date, reg.wallet_id) as reg

        left join doc_expend_rows as expRows ON reg.docId = expRows.doc_id
        left join wallets on reg.walletId = wallets.id
        left join ref_items_expenditure as items on expRows.item_id = items.id
        group by
                reg.docDate,
            reg.walletId,
            wallets.currency_id,
            reg.docId,
            expRows.item_id,
            items.name";
    }
}
