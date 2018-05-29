select 
	temp.wallet_id,
    wallets.name as wallet,
    temp.balance
FROM (select
	trans.wallet_id,
    ROUND(SUM(trans.sum), 2) as balance
from 
	regMoneyTrans as trans
group by
	trans.wallet_id) as temp
left join wallets on temp.wallet_id = wallets.id
where temp.balance <> 0