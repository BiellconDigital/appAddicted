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

	public function form($id)
	{
             $user = User::find($id);
	     $paises = array(
		"Colombia" => "Colombia",
		"Costa Rica" => "Costa Rica",
		"Chile" => "Chile",
		"Ecuador" => "Ecuador",
		"El Salvador" => "El Salvador",
		"Guatemala" => "Guatemala",
		"México" => "México",
		"Panamá" => "Panamá",
		"Perú" => "Perú",
		"Puerto Rico" => "Puerto Rico",
		"República Dominicana" => "República Dominicana",
		"Venezuela" => "Venezuela"
		);
		return View::make('inscripcion', array('user' => $user, 'paises' => $paises));
//                        ->with('user', $user);
	}
        
        public function update($id) {
            $user = User::find($id);
            $rules = array(
                'form_email'    => 'required|email',//, 'unique:user,email'
                'form_nombre' => array('required', 'min:2'),
                'form_ape_paterno' => array('required', 'min:2'),
                'form_ape_materno' => array('required', 'min:2'),
                'form_fecha_nacimiento' => array('required'),
                'form_pais' => 'required|min:3',
                'form_acepta_term' => array('required')
            );

            $validation = Validator::make(Input::all(), $rules);
            if ($validation->fails() )
            {
                // Validation has failed.
                //return Redirect::back()->with_input(Input::except('_token'))->with_errors($validation);
                return Redirect::back()->with_input(Input::all())
                        ->with('message', 'Ingrese todos los campos correctamente.');
            }
            
            if (!$user->update(Input::except('_token'))) {
                return Redirect::back()
                        ->with('message', 'Sucedió un error en la inscripción.')
                        ->withInput();
            }
            Auth::login($user);

            return Redirect::route('categorias');
        }

}
