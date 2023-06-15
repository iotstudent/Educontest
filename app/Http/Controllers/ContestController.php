<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Contest;
use App\Models\Prize;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContestController extends Controller
{
    /*
    * Display a listing of the resource.
    */
   public function index()
   {
       // 
       return Contest::all();
   }


    // /**
    //  * Store a newly created resource in storage.
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */

   public function createBasic(Request $request)
    {
        //  
        $request->validate([

            'contest_name' => 'required',
            'user_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'contest_photo' => 'required|mimes:png,jpg|max:8048',
            'category' => 'required',
            'contest_description' => 'required',
            'sponsor_name' => 'required',
           
        ]);
        
        if($request->contest_photo) {
            $fileName = time().'_'.$request->contest_photo->getClientOriginalName();
            $filePath = $request->file('contest_photo')->storeAs('uploads', $fileName, 'public');
            $contest_photo= '/storage/' . $filePath;
        }

        $response = Contest::create([
            'contest_name'=>$request->contest_name,
            'user_id' =>$request->user_id,
            'start_date'=> $request->start_date,
            'end_date' => $request->end_date,
            'contest_photo' => $contest_photo,
            'category' => $request->category,
            'contest_description' =>  $request->contest_description,
            'sponsor_name' => $request->sponsor_name
        ]);

        return response($response,200);
    }

    public function createEntry(Request $request)

    {
        //  
        $request->validate([

            'user_id'=>'required',
            'contest_id' => 'required',
            'document_slug' => 'required',
            'document_type' => 'required',
            'document_to_upload' => 'required',
           
        ]);
        
        if($request->document_type) {

            $document_type = implode(", ", $request->document_type);
        }

        $UpdateDetails = Contest::where('id', $request->contest_id)->first();
 
        if (is_null($UpdateDetails)) {
            return response('Error', 401);
        }

        $UpdateDetails->update([

            'user_id' =>$request->user_id,
            'contest_id' =>$request->contest_id,
            'document_slug'=>$request->document_slug,
            'document_type' =>$document_type,
            'document_to_upload' =>  $request->document_to_upload,

        ]);

        return response("Sucessfuly created",200);
    }



    public function createDetails(Request $request)

    {
        //  
        $request->validate([

            'user_id'=>'required',
            'contest_id' => 'required',
            'age_limit' => 'required',
            'gender' => 'required',
            'number_entries' => 'required',
            'daily_limit' => 'required',
            'submission_details' => 'required',
           
        ]);
        
      
        $UpdateDetails = Contest::where('id', $request->contest_id)->first();
 
        if (is_null($UpdateDetails)) {
            return response('Error', 401);
        }

        $UpdateDetails->update([

            'user_id' =>$request->user_id,
            'contest_id' =>$request->contest_id,
            'age_limit'=>$request->age_limit,
            'gender'=>$request->gender,
            'number_entries'=>$request->number_entries,
            'daily_limit'=>$request->daily_limit,
            'submission_details' => $request->submission_details,

        ]);

        return response("Proceed to next section",200);
    }


    public function createSelection(Request $request)

    {
        //  
        $request->validate([

            'user_id'=>'required',
            'contest_id' => 'required',
            'selection_method'=>'required',
            'voter_limit' => 'required',
            'voting_start' => 'required',
            'voting_end' => 'required',
            'show_total_votes' => 'required',
            'criteria' => 'required',
           
        ]);
        
      
        $UpdateDetails = Contest::where('id', $request->contest_id)->first();
 
        if (is_null($UpdateDetails)) {
            return response('Error', 401);
        }

        $UpdateDetails->update([

            'user_id' =>$request->user_id,
            'contest_id' =>$request->contest_id,
            'selection_method' =>$request->selection_method,
            'voter_limit'=>$request->voter_limit,
            'voting_start'=>$request->voting_start,
            'voting_end'=>$request->voting_end,
            'show_total_votes'=>$request->show_total_votes,
            'criteria' => $request->criteria,

        ]);

        return response("Proceed to next section",200);
    }


    public function createPrizes(Request $request)
    {
        //  
        $request->validate([

            'contest_id' => 'required',
            'user_id' => 'required',
            'prize_name' => 'required',
            'prize_pic' => 'required|mimes:png,jpg|max:8048',
            'number_of_winners' => 'required'
            
        ]);
        
        if($request->prize_pic) {
            $fileName = time().'_'.$request->prize_pic->getClientOriginalName();
            $filePath = $request->file('prize_pic')->storeAs('uploads', $fileName, 'public');
            $prize_pic= '/storage/' . $filePath;
        }

        $response = Prize::create([
            'contest_id'=>$request->contest_id,
            'user_id' =>$request->user_id,
            'prize_name'=> $request->prize_name,
            'number_of_winners' => $request->number_of_winners,
            'prize_pic' => $prize_pic
        ]);

        return response($response,200);
    }


     // update user profile 
     public function update(Request $request)

     {   

         $request->validate([

            'id'=>'required',
            'contest_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'gender' => 'required',
            'age_limit' => 'required',
            'contest_photo' => 'required',
            'category' => 'required',
            'contest_description' => 'required',
            'sponsor_name' => 'required',
            'daily_limit' => 'required',
            'number_entries' => 'required',
            'login_options' => 'required',
            'criteria' => 'required',
            'voting_platform' => 'required',
            'selection_method' => 'required',
            'limits_per_vote' => 'required',
            'show_total_votes' => 'required',
            'document_to_upload' => 'required',
            'document_type' => 'required'
         ]);
 
         $UpdateDetails = Contest::where('id', $request->id)->first();
 
         if (is_null($UpdateDetails)) {
             return response('Error', 401);
         }
 
         $UpdateDetails->update([
           
             'contest_name' => $request->contest_name,
             'start_date' => $request->start_date,
             'end_date' => $request->start_date,
             'gender' => $request->gender,
             'age_limit' => $request->age_limit,
             'contest_photo' => $request->contest_photo,
             'category' => $request->category,
             'contest_description' => $request->contest_description,
             'sponsor_name' => $request->sponsor_name,
             'daily_limit' => $request->daily_limit,
             'number_entries' => $request->number_entries,
             'login_options' => $request->login_options,
             'criteria' => $request->criteria,
             'voting_platform' => $request->voting_platform,
             'selection_method' => $request->selection_method,
             'limits_per_vote' => $request->limits_per_vote,
             'show_total_votes' => $request->show_total_votes,
             'document_to_upload' => $request->document_to_upload,
             'document_type' => $request->document_type,
             'updated_at' => now()
         ]);
 
         return response('Contest Successfully Updated', 200);
     }
    
     public function search($name)
   
     {
        //find a prodcut by id
        $response = Contest::where('contest_name','like','%'.$name.'%')->get();

        if(($response)){
            return  response($response,200);
        } else{
            return response("No match found");
        }
    }

     /**
     * Display a listing of the resource. by ID
     */
    public function fetchContestById(Request $request)
    {
        
        $response=Contest::WHERE('user_id',$request->user_id)->get();

        if($response){
            return  response($response,200);
        } else{
            return response("You have not created any contest");
        }

    }

    
    public function fetchLiveContest()
    {
        // 
        $response = Contest::where('end_date','>',now())->get();
        
        
        if($response){
            return  response($response,200);
        } else{
            return response("You have not created any contest");
        }
    }

    public function fetchLiveContestByUserId(Request $request)
    {
        // 
        $response = Contest::where('end_date','>',now())->Where('user_id',$request->user_id)->get();
        
        
        if($response){
            return  response($response,200);
        } else{
            return response("You have not created any contest");
        }
    }

    public function countLiveContestByUserId(Request $request)
    {
        // 
        $response = Contest::where('end_date','>',now())->Where('user_id',$request->user_id)->count();
        
        
        if($response){
            return  response($response,200);
        } else{
            return response("You have not created any contest");
        }
    }


}
