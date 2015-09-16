<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestStatuses extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'request_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('*');

    public static function getDefaultRequestStatus() {
        $status = RequestStatuses::where('name',  'open')->first();
        return $status->id;
    }
}
