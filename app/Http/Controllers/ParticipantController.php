<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Participant;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
  
   public function getParticipantsByContestId($contest_id)

   

   {
       
      

       $value= DB::table('entries')
        ->join('participants', 'entries.participant_id', '=', 'participants.id')
        ->select(DB::raw('entries.created_at AS date_created,participants.first_name AS first_name,participants.last_name AS last_name,participants.email AS email'))
        ->where('contest_id',$contest_id)
        ->get();

        return response ($value,200);

   }


   

}
