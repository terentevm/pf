<?php


namespace tm;

use tm\Controller;
use tm\Registry as Reg;

class RestController extends Controller
{
    public static $defaultAction = 'index';
    
    
    
    protected $limit = 50;
    protected $offset = 0;
    
    public function __construct($route)
    {
        parent::__construct($route);
       
    }
    
    public function actionIndex()
    {
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
        
        return $this->createResponse($this->createResponseData(true, $result, "OK"), 200);
    }
    
    public function actionShow()
    {
        $get = Reg::$app->request->get();
        
        if (!isset($get['id'])) {
            return $this->createResponse($this->createResponseData(false, null, "Param 'id' hsn't been transfered"), 404);
        }
        $className = static::$classModel;
        
        $result = $className::findById($id, false);
        
        if ($result === false) {
            return $this->createResponse($this->createResponseData(false, null, "Not found by id"), 404);
        }
        
        return $this->createResponse($this->createResponseData(true, $result, "OK"), 200);

    }
    
    public function actionCreate()
    {
        $post = Reg::$app->request->post();
        
        $upload_mode = $post['uploadMode'] ?? false;
        
        if (empty($post)) {
            return $this->createResponse($this->createResponseData(false, null, "Data for saving hasn't recieved"), 500);
        }

        $post['user_id'] = $this->user_id;
        $className = get_called_class()::$classModel;
        
        $model = new $className();
        $model->load($post);
        
        if (method_exists($model, "validate")) {
            $validated = $model->validate();
            if ($validated === false) {
                return $this->createResponse($this->createResponseData(false, null, "Validation errors"), 500);    
            }
        }

        $success = $model->save($upload_mode);
        
        if ($success === true) {
            return $this->createResponse($this->createResponseData(true, null, "OK"), 201);
        }
        
        return $this->createResponse($this->createResponseData(false, null, "Data haven't been saved"), 500);

    }
    
    public function actionUpdate()
    {
        $post = Reg::$app->request->post();
        
        if (empty($post)) {
            return $this->createResponse($this->createResponseData(false, null, "Data for updating hasn't recieved"), 500);
        }
        $post['user_id'] = $this->user_id;
        $className = get_called_class()::$classModel;
        
        $model = new $className();
        $model->load($post);
        
        if (method_exists($model, "validate")) {
            $validated = $model->validate();
            if ($validated === false) {
                return $this->createResponse($this->createResponseData(false, null, "Validation errors"), 500);    
            }
        }

        $success = $model->update();
        
        if ($success === true) {
            return $this->createResponse($this->createResponseData(true, null, "OK"), 200);
        }
        
        return $this->createResponse($this->createResponseData(false, null, "Data haven't been updated"), 500);
    }
    
    public function actionDelete()
    {
        $id = Reg::$app->request->get('id');
        
        if (is_null($id)) {
            return $this->createResponse($this->createResponseData(false, null, "Error. Params havo to contain id"), 500);
        }
        
        $className = get_called_class()::$classModel;
        
        $deleted = $className::find()->where(['id = :id'])->setParam('id', $id)->delete();
       
        if ($deleted === true) {
            return $this->createResponse($this->createResponseData(true, null, "Deleted"), 200);   
        }
        else {
           return $this->createResponse($this->createResponseData(true, null, "Not deleted"), 500); 
        }
        
        
    }
}
