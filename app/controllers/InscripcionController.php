<?php

class InscripcionController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function form(User $user)
	{
            
		return View::make('inscripcion')
                        ->with('user', $user);
	}
        
        public function update($id) {
            $user = User::find($id);

            $rules = array(
                'form_email'    => array('required', 'email', 'unique:user,email'),
                'form_acepta_term' => array('required')
            );

            $validation = Validator::make(Input::all(), $rules);

            if ($validation->fails())
            {
                // Validation has failed.
                return Redirect::back()->with_input()->with_errors($validation);
            }

    
            if (!$user->update(Input::all())) {
                return Redirect::back()
                        ->with('message', 'Sucedió un error en la inscripción.')
                        ->withInput();
            }
	    Auth::login($user);

            return Redirect::route('categorias');
            
        }

}
