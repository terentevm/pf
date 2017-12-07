<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;
use tm\Controller;
use Models\Tools;
/**
 * Description of ToolsController
 *
 * @author terentyev.m
 */
class ToolsController extends Controller {
    public $layout = 'material';
    
    public function actionImport1c(){
        $this->GetView();
    }
    public function actionGetfiles1c(){
        if(empty($_FILES)){
            echo json_encode(['error'=>'No files found for upload.']);
            exit();
        }
        
        if(!isset($_FILES['userfile'])){
            echo json_encode(['error'=>'No files found for upload.']);
            exit();   
        }
        
        if(is_array($_FILES['userfile'])){
            $files_names = $_FILES['userfile']['name'];
            $files_paths = $_FILES['userfile']['tmp_name'];
            $files_type = $_FILES['userfile']['type'];
        }
        else{
            echo json_encode(['error'=>'Upload error.']);
            exit();    
        }
        $actions = [];
        for($i=0; $i < count($files_names); $i++){
            $filename = $files_names[$i];
            $json_str = file_get_contents($files_paths[$i]);
            
            $actions[] = [
                'filename' => $filename,
                'json_str' => $json_str
            ];
        }
        
        $tools = new Tools();
        $tools->Load(['import_files' => $actions] );
        $result = $tools->ImportDataFrom1c();
        
        if($result == TRUE){
            $output = [];
            echo json_encode($output);
            exit();
        }
        else {
            echo json_encode(['error'=>'Error download files!']);
            exit();
        }
        
    }
    
    public function actionProgram_settings(){
        $this->view = 'ProgramSettings';
        $this->GetView();    
    }
}
