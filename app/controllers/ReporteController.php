<?php
use Facebook\FacebookSession;
use Facebook\Helpers\FacebookJavaScriptLoginHelper;
use Facebook\FacebookRequest;
use Facebook\Exceptions\FacebookAuthorizationException;

class ReporteController extends BaseController {

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

	public function index()
	{
            try {
                return View::make('reporte');
            } catch (\Exception $e) {
                return Redirect::to('/error')->with('message', 'Ha ocurrido un error.');
            }
	}
        
        public function participantes() {
            if (Input::get('inputPassword') != "addicted")
                return Redirect::back()->with('message', 'El password no es válido.');
            
            $userProfiles = DB::table('user')
                ->join('profile', 'user.id', '=', 'profile.user_id')
                ->where('user.inscrito', true)
                ->get();
            
            Excel::create('Reporte Concurso', function($excel) use($userProfiles) {

                // Set the title
                $excel->setTitle('Our new awesome title');

                // Chain the setters
                $excel->setCreator('Maatwebsite')
                      ->setCompany('Maatwebsite');
                
                $excel->sheet('Participantes', function($sheet) use($userProfiles) {

                    $sheet->setOrientation('landscape');
                    
                    $sheet->row(1, array(
                        'Nombre', 'Apellido', 'Fecha Nacimiento', 
                        'País', 'Email', 'Nro Votos', 
                        'Fecha Registro'
                    ));               
                    $sheet->row(1, function($row) {

                        // call cell manipulation methods
                        $row->setBackground('#c30773');

                    });                    
                    
                    $count = 3;
                    foreach ($userProfiles as $userProfile) {
                        $sheet->row($count, array(
                            $userProfile->form_nombre, $userProfile->form_apellido, $userProfile->form_fecha_nacimiento,
                            $userProfile->form_pais, $userProfile->form_email, $userProfile->votes, 
                            $userProfile->created_at,
                        ));
                        $count++;
                    }

                });

            })->export('xls');
        }
}
