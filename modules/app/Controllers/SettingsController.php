<?php

namespace app\Controllers;

use tm\Controller;
use tm\Validator;
use tm\Registry;
use app\Models\ProgramSettings;
use app\Models\Wallets;
use app\Models\Currency;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class SettingsController extends Controller
{
    public $layout = 'material';

    public static $defaultAction = 'actionGetSettings';

    public function actionGetSettings() {
        $this->view = 'ProgramSettings';
        
        $post = $post = Registry::$app->request->post();

        if (empty($post)) {
            
            $settings = ProgramSettings::getSettings($_SESSION['user_id']);

            return $this->createResponse($settings);
        }

        


    }
}
