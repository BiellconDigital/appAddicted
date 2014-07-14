<?php
class Victim extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'victim';

        public function user()
        {
            return $this->belongsTo('User');
        }

        public function category()
	{
		return $this->belongsTo('Victim');
	}
}
