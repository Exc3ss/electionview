<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Province
 * 
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $region_id
 * 
 * @property Region $region
 * @property Collection|City[] $cities
 * @property Collection|Section[] $sections
 *
 * @package App\Models
 */
class Province extends Model
{
	protected $table = 'provinces';
	public $timestamps = false;

	protected $casts = [
		'region_id' => 'int'
	];

	protected $fillable = [
		'name',
		'code',
		'region_id'
	];

	public function region()
	{
		return $this->belongsTo(Region::class);
	}

	public function cities()
	{
		return $this->hasMany(City::class);
	}

	public function sections()
	{
		return $this->hasMany(Section::class, 'provincia_id');
	}
}
