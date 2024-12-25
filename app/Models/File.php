<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $table='files';
    protected $fillable = ['name','mime','size','file_id','folder_id','created_time','webContentLink'];

}
