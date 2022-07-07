<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $guarded = [];
    protected $casts = ['tenant_id'=>'integer','user_id'=>'integer'];

    // //////////////////////////////////////////////Relations
    public function tenant()
    {
        return $this->belongsTo(Tenant::class,'tenant_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    
}
