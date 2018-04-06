<?php

namespace mappers;

use tm\Mapper;
use tm\Model;


class ItemExpenditureMapper extends Mapper
{
    public static $db_columnes = ['id', 'user_id','name', 'not_active', 'parent_id', 'comment'];
    
    public static function setTable() {
        return "ref_items_expenditure";
    }
    
    public function hierarchically($expand = true, $parentId = null) {
        
        if (is_null($parentId)) {
            $this->andWhere(['parent_id IS NULL']);    
        }
        else {
            $this->andWhere(['parent_id = :parent_id']);
            $this->setParams(['parent_id' => $parentId]);
        }
        
        list($sql, $params) = $this->qb->build($this);
        
        $head_items = $this->db->query($sql, $params, true);
        
        $sql_childs = "SELECT id,user_id,name,not_active,parent_id,comment FROM ref_items_expenditure  WHERE user_id = :user_id AND parent_id = :parent_id";
        $this->db->prepare($sql_childs);
        
        $this->selectByParent($head_items, $sql_childs, $params);
        
        return $head_items;
        
    }
    
    private function selectByParent(&$items, &$sql, $params, $parent =[]) {
        
        foreach ($items as &$item) {
            $params['parent_id'] = $item['id'];
            $childs = $this->db->query($sql, $params, false);
            $item['items'] = $childs;
            unset($parent['items']);
            $item['parent'] = $parent;
            if (empty($childs)) {
                $item['hasChild'] = false;
                continue;    
            }
            $item['hasChild'] = true;
            $this->selectByParent($item['items'], $sql, $params, $item);
        }
        
    }

   public function delete(Model $obj) {
        if ($this->delete_stmt === null) {
            $this->where = ['id = :id'];

            $sql = $this->qb->buildDelete($this);
            $this->delete_stmt = $this->db->prepare($sql);
        }
        
        $param = $this->mapModelToDb($obj);
        $success = $this->create_stmt->execute($param);

        return $success;    
    }

    protected function getPrimaryKey() {
        return "id";
    }

    public function mapModelToDb(Model $obj) {
     
        return [
            'id' => $obj->getId(),
            'user_id' => $obj->getUser_id(),
            'name' => $obj->getName(),
            'not_active'=> intval($obj->getNotActive()),
            'parent_id' => $obj->getParentId(),
            'comment' => $obj->getComment()
        ];
    }

   

}