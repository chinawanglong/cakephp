<?php
/**
 * Created by PhpStorm.
 * User: elliot
 * Date: 26/09/2018
 * Time: 15:46
 */

namespace App\Controller\Component;


use Cake\Controller\Component;

class MySearchComponent  extends Component
{
    private $controller;
    public function initialize(array $config)
    {
        parent::initialize($config); // TODO: Change the autogenerated stub
        $this->controller = $controller = $this->_registry->getController();
    }

    public function getSearchCondition(){
        $condition = [];
        $searchArray = [];
        $controllerName = $this->controller->request->param('controller');
        $session = $this->controller->request->session();

        // post search
        if ($this->controller->request->is('post')){
            $searchArray = [$controllerName => $this->controller->request->data($controllerName)];
            $session->write('searchArray', $searchArray);
        } elseif ($session->check('searchArray.'. $controllerName)){
            // get search from session
            $searchArray = [$controllerName => $session->read('searchArray.'. $controllerName)];
        }
        // organize condition according to searchArray
        if (array_key_exists($controllerName, $searchArray)){
            if ($searchArray[$controllerName]){
                foreach ($searchArray[$controllerName] as $key => $value){
                    if (is_array($value)){
                        foreach ($value as $subType => $subValue){
                            if ($subValue === ''){
                                continue;
                            }
                            switch ($subType){
                                case 'from':
                                    $condition[$controllerName.'.'.$key.' >='] = "$subValue";
                                    break;
                                case 'to':
                                    $condition[$controllerName.'.'.$key.' <='] = "$subValue";
                                    break;
                                default:
                                    break;
                            }
                        }
                    } elseif (strpos($key, '_id') !== false) {
                        // foreignKey
                        if ($value && $value !== 'all'){
                            $conditions[$controllerName . '.' . $key] = $value;
                        }
                    } elseif (is_numeric($value)){
                        $condition[$controllerName.'.'.$key.' >'] = $value;
                    } elseif (!empty($value)){
                        $condition[$controllerName.'.'.$key.' like'] = "%$value%";
                    } else {
                        continue;
                    }
                }
            }
            
            $session->write('getSearch', 'ok');
        }

        return $condition;
    }

}