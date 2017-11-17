<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Models;
use Base\Model;
/**
 * Description of itemsexpenditure
 *
 * @author terentyev.m
 */
class Itemsexpenditure extends Model {
    public $table = 'dic_items_expenditure';
    
    public $attributes = [
        'id' => '',
        'name' => '',
        'user_id' => '',
        'not_active' => 0,
        'comment' => '',
        'parent_id' => NULL
    ];
    
    use Base\TraitModelFunc;

    public function GetHierarhicalList(){
        $tree = [];
        
        $this->CreateTree(NULL, $_SESSION['user_id'],$tree);
        
        return $tree;
    }
    
    //recursive function
    public function CreateTree($parent_id, $user_id, & $tree = []){
        
        if($parent_id === NULL){
            $query_parent_id = " parent_id IS NULL";
            $param = [
                'user_id' => $user_id
            ];
        }
        else{
            $query_parent_id = " parent_id = :parent_id";
            $param = [
                'user_id' => $user_id,
                'parent_id' => $parent_id
            ];
        }
        
        $sql = "Select id, parent_id, name, not_active, comment FROM dic_items_expenditure WHERE user_id = :user_id AND" . $query_parent_id;
        
        
        
        $result = $this->pdo->Query($sql, $param);
        
        if(!empty($result)){
            foreach ($result as $element){
                
                $tree_str = [
                    'elements' => $element,
                    'childs' => []
                ];
                
                $parent_id = $element['id'];
                $this->CreateTree($parent_id, $user_id, $tree_str['childs']);
                
                $tree[] = $tree_str;
            }
               
        }
        else{
            return;
        }
    }
}
