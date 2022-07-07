<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;
    
    protected $table = 'tenants';
    protected $hidden = ['pivot'];   
    protected $guarded = [];
    
    // //////////////////////////////////////////////Relations
    public function users()
    {
        return $this->belongsToMany(User::class,'user_tenants','tenant_id','user_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class,'tenant_id');
    }   
    
    public static function boot() {
        parent::boot();
        static::deleting(function($model) { 
            foreach ($model->products as $value) {$value->delete();}
            foreach ($model->users as $user) {
                $user->tenants()->detach($model->id);  
                if(count($user->tenants)==0){
                    $user->delete();
                }
            }
        });
    }
}
