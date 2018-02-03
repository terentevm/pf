<?php


namespace tm;

use tm\Controller;
use tm\Registry as Reg;

class RestController extends Controller
{
    public static $defaultAction = 'index';
    
    protected $user_id = null;
    
    public function __construct($route) {
        parent::__construct($route);
        $this->user_id = Reg::$app->user_id;
    }
    
    public function actionIndex() {
        
        $get = Reg::$app->request->get();
        
        $limit = $get['limit'] ?? 50;
        $offset = $get['offset'] ?? 0;
        
        $className = get_called_class()::$classModel;
        
        $result = $className::find()
                ->where(['user_id = :user_id'])
                ->setParams(['user_id' => $this->user_id])
                ->limit($limit)
                ->offset($offset)
                ->all();
        
        return $this->createResponse($result, 200);
    }
    
    public function actionShow($id) {
        
        $className = self::$classModel;    
        
        $result = $className::findById($id, false);
        
        if ($result === false) {
            return $this->createResponse("Not found", 404);    
        }
        
        return $this->createResponse($result, 200);
    }
    
    public function actionCreate() {
        
        $post = Reg::$app->request->post();
        
        $upload_mode = $post['uploadMode'] ?? false;
        
        if (empty($post)) {
            return $this->createResponse("Data for saving hasn't recieved", 500);
        }
        $post['user_id'] = $this->user_id;
        $className = get_called_class()::$classModel;
        
        $model = new $className();
        $model->load($post);
        
        $success = $model->save($upload_mode);
        
        if ($success === true) {
            return $this->createResponse("OK", 201);    
        } 
        
        return $this->createResponse("Error", 500);
    }
    
    public function actionUpdate() {
        
    }
    
    public function actionDelete($id) {
        
    }
}