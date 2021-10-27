<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainList extends Model
{
    use HasFactory;
    protected $table ="domain_list";
    public $timestamps = false;
    
    public static function contains($domain){
        $domainExists = DomainList::where('domain_name', '=', $domain)->first();
        return (!is_null($domainExists)) == 1;
    }
}
