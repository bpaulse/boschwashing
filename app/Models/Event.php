<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	use HasFactory;

	public function athlete() {
		return $this->hasMany(Athlete::class);
	}

	public function wod() {
		return $this->hasMany(Wod::class);
	}

}
