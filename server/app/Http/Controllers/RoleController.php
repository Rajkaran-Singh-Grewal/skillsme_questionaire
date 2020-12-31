<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Questionnaire;
class RoleController extends Controller
{
    //
    /**
     * Check role of user
     * @param Integer $user_id the id of the user
     * @param Integer $questionnaire_id The id of the qustionnaire
     * @return bool if user can edit the questionnaire according to its role 
     */
    public static function checkRoleEditable($user_id, $questionnaire_id){
        $user = User::where('id','=',$user_id)->first();
        if($user == null){
            $role = 'user';
        }else{
            $role = $user->role;
        }
        if($role == 'administrator'){
            return true;
        }
        $questionnaire = Questionnaire::where('id','=',$questionnaire_id);
        if($user_id == $questionnaire->user_id){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 
     */
}
