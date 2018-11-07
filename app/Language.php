<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use \Dimsav\Translatable\Translatable;
    
    public $translatedAttributes = ['title'];
    
    protected  $table = 'languages';
    
    protected $fillable = [
        'serial_no','locale'
        ];
}
