<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    /** @use HasFactory<\Database\Factories\SpecialistFactory> */
	
	use HasFactory;
	protected $table = 'specialists';
	// Optional: allow mass assignment
	protected $fillable = ['name','phone'];

	public function services()
	{
		return $this->belongsToMany(Service::class);
	}

	public function appointments() : HasMany
	{
		return $this->hasMany(Appointment::class);
	}

}
