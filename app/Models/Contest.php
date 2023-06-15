<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contest extends Model
{
    use HasFactory;

    protected $table = 'contest';

    protected $fillable = ['contest_name','user_id','start_date','end_date',
                            'gender','age_limit','contest_photo','category','contest_description',
                            'sponsor_name','daily_limit','number_entries','submission_details','criteria',
                            'voting_platform','selection_method','limits_per_vote','show_total_votes','document_slug',
                            'document_to_upload','document_type'
                            
                          ];
}
