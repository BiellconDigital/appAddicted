<?php
class Category extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'category';

	public function victims()
	{
		return $this->hasMany('Victim');
	}
}
