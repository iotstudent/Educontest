<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Entry;
use App\Models\Contest;
use \Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class EntryController extends Controller
{
    public function getEntiresByContestId($contest_id)
   {
       
    
        $value= DB::table('entries')
        ->join('participants', 'entries.participant_id', '=', 'participants.id')
        ->select(DB::raw('entries.document_uploaded AS document,participants.email AS participant_email'))
        ->where('contest_id',$contest_id)
        ->get();

        return response ($value,200);

   }

   public function entry(Request $request){

   

      $checkContestType=Contest::WHERE('id',$request->contest_id)->get();
      $checkContest = json_decode($checkContestType);
      $value = Arr::pluck($checkContest, 'document_type');
      $value=implode($value);
     //  return response($value,200);
      
          $request->validate([

               'full_name' => 'required',
               'email' => 'required',
               'contest_id' => 'required',
               'document_uploaded' => "required|mimes:$value|max:10000",
               'entry_extras' => 'required'
              
           ]);   
     
      
      if($request->document_uploaded) {
          $fileName = time().'_'.$request->document_uploaded->getClientOriginalName();
          $filePath = $request->file('document_uploaded')->storeAs('entries', $fileName, 'public');
          $document_uploaded= 'http://127.0.0.1:8000/storage/' . $filePath;
      }

      $response = Entry::create([
          'full_name'=>$request->full_name,
          'contest_id' =>$request->contest_id,
          'email'=> $request->email,
          'entry_extras' => $request->entry_extras,
          'document_uploaded' => $document_uploaded
      ]);

      Mail::send('email.entry', ['id' => $response->id], function($message) use($request){
        $message->to($request->email);
        $message->subject('Your Entry Link');
    });

      return response($response,200);
   }

}
