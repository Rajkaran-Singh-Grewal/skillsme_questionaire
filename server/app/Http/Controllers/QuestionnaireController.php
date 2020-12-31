<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionnaire;
class QuestionnaireController extends Controller
{
    //
    /**
     * Check all Questionnaires created by the user
     */
    public function usersQuestionnaires(Request $request){
        $questionnaires = Questionnaire::where('user_id','=', $request->user_id)->get();
        if(count($questionnaires) == 0){
            return response([
                'success' => false,
                'message' => 'No Questionnaies for user'
            ],200);
        }else{
            return response([
                'success' => true,
                'message' => 'Success in retrieving users',
                'questionnaires' => $questionnaires
            ],200);
        }
    }
    /**
     * All Questionnaires the current users can participate in
     */
    public function viewableQuestionnaires(Request $request){
        $questionnaires = DB::table('QUESTIONNAIRES')->
                            join('VIEWABLES','VIEWABLES.questionnaire_id','=','QUESTIONNAIRES.id')->
                            select('QUESTIONNAIRES.*')->
                            where('QUESTIONNAIRES.visibility','=','1')->
                            orWhere('VIEWABLES.user_id','=',$request->user_id)->
                            get();
        if(count($questionnaires) == 0){
            return response([
                'success' => false,
                'message' => 'No Questionnaires for user'
            ],200);
        }else{
            return response([
                'success' => true,
                'message' => 'Success in retrieving users',
                'questionnaires' => $questionnaires
            ],200);
        }
    }
    /**
     * Add Questionnaires
     */
    public function addQuestionnaires(Request $request){
        
    }
}
