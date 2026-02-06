<?php

namespace App\Models;
use App\Models\User;
use APP\Models\Auth;    
use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);

    }

    public function creator()
    {
        // dd('$entered');
        // die('here');
        return $this->belongsTo(User::class, 'created_by');
    }
}
