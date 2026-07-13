<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'member_id',
        'jadwal',
        'status',
        'closed_at',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
    public function messages()
    {
        return $this->hasMany(ConsultationMessage::class, 'booking_id')->orderBy('created_at', 'asc');
    }
}
