<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * 
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $province_id
 * 
 * @property Province $province
 * @property Collection|Section[] $sections
 * @property Collection|Zip[] $zips
 *
 * @package App\Models
 */
class City extends Model
{
	protected $table = 'cities';
	public $timestamps = false;

	protected $casts = [
		'province_id' => 'int'
	];

	protected $fillable = [
		'name',
		'code',
		'province_id'
	];

	public function province()
	{
		return $this->belongsTo(Province::class);
	}

	public function sections()
	{
		return $this->hasMany(Section::class, 'comune_id');
	}

	public function zips()
	{
		return $this->hasMany(Zip::class);
	}
}
