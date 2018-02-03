select
items.name,
tab.sum
FROM (SELECT
    t1.item_id,
	SUM(t1.sum) AS sum
FROM doc_expend_rows as t1
	INNER JOIN (Select doc.id FROM doc_expend as doc
    WHERE doc.date between STR_TO_DATE('01,12,17 00:00:00', '%d,%m,%y %H:%i:%s') and STR_TO_DATE('31,12,17 23:59:59', '%d,%m,%y %H:%i:%s')
    ) as t2 ON t1.doc_id = t2.id
	
    


group by t1.item_id) as tab
LEFT JOIN ref_items_expenditure as items ON tab.item_id = items.id