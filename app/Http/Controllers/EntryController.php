<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Entry;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class EntryController extends Controller
{
    public function getEntiresByContestId(Request $request)
   {
       
    // /
    //    $value =DB::raw("SELECT entries.document_uploaded AS document,participants.email AS particepant_email FROM entries INNER JOIN participants ON entries.participant_id=participants.id WHERE ontest_id = $request->contest_id");

      

        $value= DB::table('entries')
        ->join('participants', 'entries.participant_id', '=', 'participants.id')
        ->select(DB::raw('entries.document_uploaded AS document,participants.email AS participant_email'))
        ->where('contest_id',$request->contest_id)
        ->get();

        return response ($value,200);

   }

}
