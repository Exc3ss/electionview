<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Section
 * 
 * @property int $id
 * @property int $numero
 * @property int $schedebianche
 * @property int $schedenulle
 * @property int $aventidiritto
 * @property int $votanti
 * @property int $damico
 * @property int $m5s
 * @property int $pd
 * @property int $azione
 * @property int $verdisi
 * @property int $abruzzoinsieme
 * @property int $damicopresidente
 * @property int $marsilio
 * @property int $fdi
 * @property int $lega
 * @property int $forzaitalia
 * @property int $noimoderati
 * @property int $unionedicentro
 * @property int $marsiliopresidente
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $comune_id
 * @property int $provincia_id
 * 
 * @property City $city
 * @property Province $province
 *
 * @package App\Models
 */
class Section extends Model
{
	protected $table = 'sections';

	protected $casts = [
		'numero' => 'int',
		'schedebianche' => 'int',
		'schedenulle' => 'int',
		'aventidiritto' => 'int',
		'votanti' => 'int',
		'damico' => 'int',
		'm5s' => 'int',
		'pd' => 'int',
		'azione' => 'int',
		'verdisi' => 'int',
		'abruzzoinsieme' => 'int',
		'damicopresidente' => 'int',
		'marsilio' => 'int',
		'fdi' => 'int',
		'lega' => 'int',
		'forzaitalia' => 'int',
		'noimoderati' => 'int',
		'unionedicentro' => 'int',
		'marsiliopresidente' => 'int',
		'comune_id' => 'int',
		'provincia_id' => 'int'
	];

	protected $fillable = [
		'numero',
		'schedebianche',
		'schedenulle',
		'aventidiritto',
		'votanti',
		'damico',
		'm5s',
		'pd',
		'azione',
		'verdisi',
		'abruzzoinsieme',
		'damicopresidente',
		'marsilio',
		'fdi',
		'lega',
		'forzaitalia',
		'noimoderati',
		'unionedicentro',
		'marsiliopresidente',
		'comune_id',
		'provincia_id'
	];

	public function city()
	{
		return $this->belongsTo(City::class, 'comune_id');
	}

	public function province()
	{
		return $this->belongsTo(Province::class, 'provincia_id');
	}
}
