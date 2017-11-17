<?php

namespace Controllers;

use Base\Controller;
use Base\Validator;
use Models\ProgramSettings;
use Models\Wallets;
use Models\Currency;
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\ValidationException;

class SettingsController extends Controller
{

    public function actionGetElement(){
        
        $this->view = 'settings';
        
        $settings = ProgramSettings::find()->where('user_id', '=', $_SESSION['user_id'])->selectAll();
        $wallets =  Wallets::find()->where('user_id', '=', $_SESSION['user_id'])->selectAll();  
        $currencies =  Currency::find()->where('user_id', '=', $_SESSION['user_id'])->selectAll(); 

        $this->vars = [
            'settings' => $settings,
            'wallets' => $wallets,
            'currencies' => $currencies
        ];

    }
}
