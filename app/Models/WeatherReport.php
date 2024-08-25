<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherReport extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'weather_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'city_id', 'timezone', 'temperature', 'feels_like', 'temp_min', 'temp_max', 'pressure', 'humidity', 'visibility', 'timestamp', 'sunrise', 'sunset', 'created_at', 'updated_at'];

    // Relacionamento das tabelas
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    
    public function conditions()
    {
        return $this->hasMany(WeatherCondition::class, 'report_id');
    }
    
    public function wind()
    {
        return $this->hasOne(Wind::class, 'report_id');
    }
    
    public function cloud()
    {
        return $this->hasOne(Cloud::class, 'report_id');
    }    
}
