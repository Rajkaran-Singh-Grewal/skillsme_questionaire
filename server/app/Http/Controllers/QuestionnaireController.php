<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Models\Viewable;
use App\Models\Question;
use App\Models\Option;
use App\Models\Answer;
use App\Models\Response;
use Illuminate\Support\Facades\DB;
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
        DB::transaction();
        try{
            $title = $request->title;
            $description = $request->description;
            $visibility = $request->visibility;
            $user_id =  $request->user_id;
            $endDate = $request->endDate;
            $questionnaire = Questionnaire::create([
                'title'       => $title,
                'description' => $description,
                'visibility'  => $visibility,
                'user_id'     => $user_id,
                'endDate'     => $endDate
            ]);
            if($visibility == 0){
                $viewables = [];
                foreach($request->viewableusers as $viewableuser){
                    $viewable = Viewable::create([
                        'user_id' => $viewableuser,
                        'questionnaire_id' => $questionnaire->id
                    ]);
                    $viewables[] = $viewable;
                }
            }
            $j = 0;
            for($i = 0; $i < $request->questionsLength; $i++){
                $question = Question::create([
                    'title'    => $request->question_title[$i],
                    'type'     => $request->question_type[$i],
                    'required' => $request->question_required[$i],
                    'order'    => $request->question_order[$i],
                    'questionnaire_id' => $questionnaire->id
                ]);
                for(;$j < $request->optionsLength[$i];$j++){
                    $option = Option::create([
                        'title' => $request->option_title[$j],
                        'question_id' => $question->id,
                        'order' => $request->option_order[$j]
                    ]);
                }
            }
        }catch(\Exception $e){
            DB::rollBack();
            return response([
                'success' => false,
                'message' => 'Questionnaire was not saved successfully <br>' . $e->getMessage()
            ],401);
        }
        DB::commit();
        return response([
            'success' => true,
            'message' => 'Questionnaire saved successfully'
        ],200);
    }
    public function updateQuestionnaire(Request $request){
        DB::transaction();
        try{
            $id                         = $request->questionnaire_id;
            $questionnaire              = Questionnaire::where('id','=',$id)->first();
            $questionnaire->title       = $request->title;
            $questionnaire->description =  $request->description;
            $questionnaire->visibility  = $request->visibility;
            $questionnaire->user_id     = $request->user_id;
            $questionnaire->save();
            $questions = Question::where('questionnaire_id','=',$id)->get();
            $question_ids = array();
            foreach($questions as $question){
                $question_ids[] = $question->id;
            }
            $listed_question_ids = explode(",",$request->listed_question_id);
            foreach($question_ids as $question_id){
                if(!in_array($question_id,$listed_question_ids)){
                    Question::where('id','=',$question_id)->delete();
                    Option::where('question_id','=',$question_id)->delete();
                }
            }
            $j = 0;
            foreach($listed_question_ids as $index => $listed_question_id){
                if(!in_array($listed_question_id,$question_ids)){
                    $question = Question::create([
                        'questionnaire_id' => $id,
                        'title'            => $request->question_title[$index],
                        'type'             => $request->question_type[$index],
                        'required'         => $request->question_required[$index],
                        'order'            => $request->question_order[$index]
                    ]);
                    for(;$j < $request->optionsLength[$index];$j++){
                        Option::create([
                            'question_id' => $question->id,
                            'title'       => $request->option_title[$j],
                            'order'       => $request->option_order[$j]
                        ]);
                    }
                }
            }
        }catch(\Exception $e){
            DB::rollBack();
            return response([
                'success' => false,
                'message' => 'Questionnaire update was not successful <br>' . $e->getMessage()
            ],401);
        }
        DB::commit();
        return response([
            'success' => true,
            'message' => 'Questionnaire update was successful'
        ],200);
    }
    /**
     * Function to submit your response
     */
    public function submitQuestionnaire(Request $request){
        $user_id = 0;
        $oscpu = $request->oscpu;
        $user_ip = $_SERVER['HTTP_CLIENT_IP'];
        if(isset($request->user_id)){
            $user_id = $request->user_id;
            $answer = Answer::where('questionnaire_id','=',$request->questionnaire_id)->first();
        }else{
            $answer = Answer::where([
                ['questionnaire_id','=',$request->questionnaire_id],
                ['oscpu','=',$oscpu],
                ['user_ip','=',$user_ip]
            ])->first();
        }
        if($answer == null){
            $answer = Answer::create([
                'questionnaire_id' => $request->questionnaire_id,
                'user_id'          => $user_id,
                'oscpu'            => $oscpu,
                'user_ip'          => $user_ip
            ]);
            foreach($request->responses as $response){
                Response::create([
                    'answer_id'   => $answer->id,
                    'question_id' => $response->question_id,
                    'answer'      => $response->answer
                ]);
            }
            return response([
                'success' => true,
                'message' => 'answer submitted'
            ],200);
        }
        return response([
            'success' => false,
            'message' => 'answer already submitted'
        ],401);
    }
}
