<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Vote;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class VotesController extends Controller
{
    //
    public function vote(Request $request){

        $request->validate([

            'entry_id'=>'required',
            'voter_email' => 'required',
            'contest_id' => 'required'
            
         ]);

         $response = Vote::create([
            'entry_id'=>$request->entry_id,
            'voter_email' =>$request->voter_email,
            'contest_id'=> $request->contest_id
        ]);

        return response("You have voted successfully",200);

    }
}
