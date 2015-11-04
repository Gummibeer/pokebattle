<?php
namespace App\Http\Controllers\Auth;

use App\Pokemon;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectAfterLogout = 'auth/login';
    protected $loginPath = 'auth/login';
    protected $redirectTo = 'app';

    public function __construct()
    {
        $this->middleware('guest', [
            'except' => [
                'getLogout',
                'getSlack',
                'getSlackcallback',
                'getFacebook',
                'getFacebookcallback',
                'getGithub',
                'getGithubcallback',
            ],
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getRegister()
    {
        return view('auth.register')->with([
            'startPokemons' => Pokemon::starter()->get()->keyBy('id')->pluck('display_name'),
        ]);
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $user = $this->create($request->all());
        $user->pokemons()->attach(\Input::get('pokemon_id', 1), ['active' => true]);

        \Auth::login($user);

        return redirect($this->redirectPath());
    }

    public function getSlack(Request $request)
    {
        if (\Auth::check() && !is_null(\Auth::User()->slack)) {
            return redirect('auth/slackcallback');
        } else {
            $params = [
                'client_id' => config('services.slack.client_id'),
                'redirect_uri' => config('services.slack.redirect'),
                'scope' => 'identify,read',
                'team' => config('services.slack.team'),
            ];
            $url = 'https://slack.com/oauth/authorize?' . http_build_query($params);
            return redirect($url);
        }
    }

    public function getSlackcallback(Request $request)
    {
        $code = \Input::get('code', false);
        if ($code) {
            $data = [
                'client_id' => config('services.slack.client_id'),
                'client_secret' => config('services.slack.client_secret'),
                'redirect_uri' => config('services.slack.redirect'),
                'code' => $code,
            ];
            $url = 'https://slack.com/api/oauth.access?' . http_build_query($data);
            $response = \Curl::get($url);
            $response['body'] = json_decode($response['body'], true);
            if ($response['body']['ok']) {
                $token = $response['body']['access_token'];

                $data = [
                    'token' => $token,
                ];
                $url = 'https://slack.com/api/auth.test?' . http_build_query($data);
                $response = \Curl::get($url);
                $response['body'] = json_decode($response['body'], true);
                if ($response['body']['ok']) {
                    $userId = $response['body']['user_id'];
                }
            }
        } elseif (\Auth::check() && !is_null(\Auth::User()->slack)) {
            $userId = \Auth::User()->slack;
            $token = config('services.slack.token');
        }

        if (isset($token) && isset($userId)) {
            $data = [
                'token' => $token,
                'user' => $userId,
            ];
            $url = 'https://slack.com/api/users.info?' . http_build_query($data);
            $response = \Curl::get($url);
            $response['body'] = json_decode($response['body'], true);
            if ($response['body']['ok']) {
                $userData = $response['body']['user'];
                $user = new \Laravel\Socialite\Two\User();
                $user->id = $userData['id'];
                $user->nickname = $userData['name'];
                $user->name = $userData['real_name'];
                $user->email = $userData['profile']['email'];
                $user->avatar = $userData['profile']['image_192'];
                return $this->handleOauthUser($request, 'slack', $user);
            }
        }
    }

    public function getFacebook()
    {
        return \Socialite::driver('facebook')->redirect();
    }

    public function getFacebookcallback(Request $request)
    {
        $response = \Socialite::driver('facebook')->user();
        return $this->handleOauthUser($request, 'facebook', $response);
    }

    public function getGithub()
    {
        return \Socialite::driver('github')->redirect();
    }

    public function getGithubcallback(Request $request)
    {
        $response = \Socialite::driver('github')->user();
        return $this->handleOauthUser($request, 'github', $response);
    }

    private function handleOauthUser($request, $provider, $oAuthUser)
    {
        if (\Auth::check()) {
            \Auth::User()->saveOauthId($provider, $oAuthUser->getId());
            return redirect('app/profile/edit/' . \Auth::User()->id);
        } else {
            $user = User::$provider($oAuthUser->getId())->first();
            if (is_null($user)) {
                $user = User::email($oAuthUser->getEmail())->first();
                if (!is_null($user)) {
                    $user->saveOauthId($provider, $oAuthUser->getId());
                }
            }
            if (is_null($user)) {
                $user = User::create([
                    $provider => $oAuthUser->getId(),
                    'username' => is_null($oAuthUser->getNickname()) ? $oAuthUser->getName() : $oAuthUser->getNickname(),
                    'email' => $oAuthUser->getEmail(),
                ]);
            }

            \Auth::login($user);
            return $this->handleUserWasAuthenticated($request, $this->isUsingThrottlesLoginsTrait());
        }
    }
}
