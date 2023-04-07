<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function logo_path(){
        if($this->logo){
            return asset('/storage/companies/'.$this->logo);
        }
        return "-";
    }

    public function video_path(){
        if($this->video){
            return asset('/storage/companies/'.$this->video);
        }
        return "-";
    }
}
