<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use \App\Ldap\User as UserLdap;
// use \LdapRecord\Container;
// use LdapRecord\Auth\BindException;
// use LdapRecord\Models\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Microsoft\Graph\Graph;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Nueva instancia de controller.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function register() 
    {
        return view("auth.register");
    }

    /**
     * Cerrar sesion del usuario
     * 
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout() 
    {
        Auth::logout();


        return redirect('login')->with('success', 'Sesión cerrada.');
    }

    /**
     * Retorna la pagina de login del Sistemafca
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function login() 
    {
        return view("auth.login");
    }

    /**
     * Validar el input del usuario e intentar iniciar sesion con Microsoft Graph
     * 
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attempt(LoginRequest $request)
    {
        $request->validated();

        return $this->msGraph($request->name);
    }



    // Dudas preguntas, gran parte del código del login con Graph fue adaptado de este repositorio de Microsoft
    // https://github.com/microsoftgraph/msgraph-sample-phpapp/tree/main/graph-tutorial
    
    /**
     * Redireccionar a la pagina de login de Microsoft con los parametros necesarios
     * 
     * @param string $name nombre de usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    private function msGraph($name) 
    {
        $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
            'clientId'                => config('azure.appId'),
            'clientSecret'            => config('azure.appSecret'),
            'redirectUri'             => config('azure.redirectUri'),
            'urlAuthorize'            => config('azure.authority').config('azure.authorizeEndpoint'),
            'urlAccessToken'          => config('azure.authority').config('azure.tokenEndpoint'),
            'urlResourceOwnerDetails' => '',
            'scopes'                  => config('azure.scopes'),
        ]);

        // redireccionar directo a la pagina de login de la UV y saltarse la de microsoft
        $authUrl = $oauthClient->getAuthorizationUrl([
            'prompt' => 'login',
            'login_hint' => $this->getEmail($name)
        ]);

        // Salvar el estado para validar en callback
        session(['oauthState' => $oauthClient->getState()]);

        // Redireccionar a la pagina de login de Microsoft
        return redirect()->away($authUrl);
    } 


    /**
     * Una vez se hace el login en la pagina de Microsoft, se redirige a esta ruta
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function callback(Request $request)
    {

        // Validate state
        $expectedState = session('oauthState');
        $request->session()->forget('oauthState');
        $providedState = $request->query('state');
  
        if (!isset($expectedState)) {
            return redirect('/');
        }
  
        if (!isset($providedState) || $expectedState != $providedState) {
            return redirect('home')
                ->with('error', 'Estado de autenticación inválido')
                ->with('errorDetail', 'El estado de autenticación proporcionado no coincide con el valor esperado');
        }
    
        // El codigo de Autorizacion deberia estar en el parametro "code" de query
        $authCode = $request->query('code');

        if (isset($authCode)) {
        // Inicializar el cliente OAuth
            $oauthClient = new \League\OAuth2\Client\Provider\GenericProvider([
                'clientId'                => config('azure.appId'),
                'clientSecret'            => config('azure.appSecret'),
                'redirectUri'             => config('azure.redirectUri'),
                'urlAuthorize'            => config('azure.authority').config('azure.authorizeEndpoint'),
                'urlAccessToken'          => config('azure.authority').config('azure.tokenEndpoint'),
                'urlResourceOwnerDetails' => '',
                'scopes'                  => config('azure.scopes'),
            ]);

        try {
            // Token request
            $accessToken = $oauthClient->getAccessToken('authorization_code', [
            'code' => $authCode
            ]);

            $graph = new Graph();
            $graph->setAccessToken($accessToken->getToken());

            // Queries de MS Graph, puedes ver que atributos existen con MS Graph Explorer
            $userGraph = $graph->createRequest('GET', '/me?$select=givenName,surname,mail,userPrincipalName,officeLocation,jobTitle,employeeId,mailNickname,onPremisesExtensionAttributes')
            ->setReturnType(\ArrayObject::class)
            ->execute();

            // dd($userGraph);


            $user = User::where('email', $userGraph['mail'])->first();

            if ($user === null) {
                $user = $this->createUser($userGraph);
            }

            // si aun el usuario es nulo, es probable que alguien lo elimino del sistema
            if (!$user) {
                return redirect('login')->with('error', 'Usuario no encontrado, contacte al administrador.');
            }

            Auth::login($user);

            return redirect('/')->with('success', 'Sesión iniciada.');
        }
        catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            return redirect('login')
                ->with('error', 'Error al recuperar el token de acceso')
                ->with('errorDetail', json_encode($e->getResponseBody()));
        }
    }
  
        return redirect('login')    
            ->with('error', $request->query('error'))
            ->with('errorDetail', $request->query('error_description'));
    }

    /**
     * Crear un nuevo usuario.
     * Según si es acádemico o estudiante.
     *
     * @param  array  $user
     * 
     */
    private function createUser($user)
    {

        try{
            DB::beginTransaction();

            $idUsuarioDB = DB::table('Usuario')->insertGetId([
                'name'              => $user['mailNickname'],
                'email'             => $user['mail'],
                'password'          => capitalizeFirst($user['officeLocation']), // poner la carrera en campo contraseña como solucion temporal a lo de Trayectoria,
                'CreatedBy'         => 1,
                'UpdatedBy'         => 1
            ]);

            DB::table('DatosPersonales')->insert([
                'idDatosPersonales'                 => $idUsuarioDB,
                'NombreDatosPersonales'             => capitalizeFirst($user['givenName']),
                'ApellidoPaternoDatosPersonales'    => capitalizeFirst($user['surname']),
                'ApellidoMaternoDatosPersonales'    => '',
                'IdUsuario'                         => $idUsuarioDB,
                'CreatedBy'                         => 1,
                'UpdatedBy'                         => 1
            ]);

            // si es estudiante o egresado
            if (strpos($user['mail'], '@estudiantes.uv.mx') !== false || strpos($user['mail'], '@egresados.uv.mx') !== false) {

                $isEgresado = strpos($user['mail'], '@egresados.uv.mx') !== false;

                DB::table('Role_Usuario')->insert([
                    'IdUsuario'     => $idUsuarioDB,
                    'IdRole'        => $isEgresado ? 4 : 3,
                    'CreatedBy'     => 1,
                    'UpdatedBy'     => 1
                ]);

                DB::table('Estudiante')->insert([
                    'matriculaEstudiante'   => $user['employeeId'],
                    'IdUsuario'             => $idUsuarioDB,
                    'CreatedBy'             => 1,
                    'UpdatedBy'             => 1
                ]);
                
            }
            else {
                DB::table('Academico')->insert([
                    'idAcademico'           => $idUsuarioDB,
                    'NoPersonalAcademico'   => $user['employeeId'] ?? "",
                    'RfcAcademico'          => $user['onPremisesExtensionAttributes']['extensionAttribute1'] ?? "",
                    'IdUsuario'             => $idUsuarioDB,
                    'CreatedBy'             => 1,
                    'UpdatedBy'             => 1
                ]);
    
                DB::table('Role_Usuario')->insert([
                    'IdUsuario'     => $idUsuarioDB,
                    'IdRole'        => 2,
                    'CreatedBy'     => 1,
                    'UpdatedBy'     => 1
                ]);
            }

            DB::commit();

            return User::find($idUsuarioDB);
        }
        catch (\Throwable $throwable){
            DB::rollBack();
        }        
    }



    /**
     * Obtener el email de un usuario segun si es academico, estudiante o egresado
     * Si se introduce un email, entonces se retorna igual
     * 
     * @param string $name nombre de usuario
     * @return string email del usuario
     */
    private function getEmail(string $name) : string 
    {
        if (strpos($name, '@') !== false) {
            return $name;
        }
        elseif (preg_match('/^zs\d+$/i', $name)) {
            return $name . "@estudiantes.uv.mx";
        } 
        elseif (preg_match('/^gs\d+$/i', $name)) {
            return $name . "@egresados.uv.mx";
        }

        return $name . "@uv.mx";
    }  



     /* 
    // Login antiguo con LdapRecord si no quieren usar la API de MS Graph
    // buena suerte consiguiendo los datos de los usuarios
    public function attempt(LoginRequest $request) 
    {
        $credentials = $request->validated();

        // Intentar iniciar sesion en BD local
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect(route('home'))->with('success', 'Sesión iniciada.');
        } 

        // Si falla, intentar con LDAP
        try {
            $email = "";

            if (strpos($credentials['name'], '@') !== false) {
                $email = $credentials['name'];

                // quitar todo lo que sigue del @
                $credentials['name'] = strstr($credentials['name'], '@', true);
            }
            else {
                $email = $this->getEmail($credentials['name']);
            }
            
            Container::getDefaultConnection()->auth()->bind($email, $credentials['password']);
            // dd(Container::getDefaultConnection()->auth());

            // Validar si existe usuario en local
            $user = User::where('name', $credentials['name'])->first();
            
            if ($user) {
                // si existe actualizar contraseña
                $user->password = bcrypt($credentials['password']);
                $user->save();
            } 
            // Si no nuevo usuario
            else {
                $user = User::create([
                    'name' => $credentials['name'],
                    'email' => $email,
                    'password' => bcrypt($credentials['password']),
                ]);
            }

            Auth::guard('web')->login($user);
            return redirect(route('home'))->with('success', 'Sesión iniciada.');
        }
        catch(BindException|ModelNotFoundException) {
            throw ValidationException::withMessages([
                'loginError' => ['El usuario o la contraseña son incorrectos.']
            ]);  
        }
    }
    */
}
