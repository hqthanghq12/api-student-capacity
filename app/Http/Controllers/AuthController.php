<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function studentLogin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'min:6'],
            ],
            [
                'email.required' => 'Vui lòng nhập email',
                'email.email' => 'Email không đúng định dạng',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'payload' => $validator->errors(),
            ]);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->hasRole([config('util.STUDENT_ROLE')])) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => true,
                    'payload' => [
                        'token' => $token,
                        'token_type' => 'Bearer',
                        'user' => $user->toArray(),
                    ],
                ]);
            }
            return response()->json([
                'status' => false,
                'payload' => "Tài khoản không tồn tại hoặc không có quyền truy cập",
            ]);
        } else {
            return response()->json([
                'status' => false,
                'payload' => "Tài khoản không tồn tại hoặc mật khẩu không đúng",
            ]);
        }
    }

    public function adminLogin()
    {
        $campuses = Campus::all();
//        $emails = [
//            'tuannda3@fpt.edu.vn',
//            'tamdtb@fpt.edu.vn',
//            'huongdtt43@fpt.edu.vn',
//            'trungnt173@fpt.edu.vn',
//            'linhntt136@fpt.edu.vn',
//            'sontv8@fpt.edu.vn',
//        ];
//        $users = User::query()->whereIn('email', $emails)->with(['campus', 'roles'])->get();
//        return view('auth.login', compact('campuses', 'users'));
        return view('auth.login', compact('campuses'));
    }

    public function redirectToGoogle(Request $request)
    {
        if ($request->login_type == 0) {
            $rules = [
//                'campus_id' => ['required'],
                'email' => ['required'],
            ];
            $messages = [
//                'campus_id.required' => 'Vui lòng chọn cơ sở',
                'email.required' => 'Vui lòng chọn tài khoản',
            ];
            Validator::make($request->all(), $rules, $messages)->validate();
        }
        $dataPut = [
            'campus_id' => $request->campus_id,
            'email' => $request->email,
            'login_type' => $request->login_type ?? null,
        ];
        Session::flash('data', $dataPut);
        if ($request->login_type == 0) return redirect()->route('google-auth.callback');
        return Socialite::driver('google')->redirect();
    }

    public function adminGoogleCallback()
    {
        if (!isset(session('data')['login_type'])) return redirect(route('login'))->with('msg', "Vui lòng chọn loại tài khoản!");
//        Session::forget('token');
//        $ggUser = Socialite::driver('google')->user();
//        $ggUser = Socialite::driver('google')->stateless()->user();
        if (session('data')['login_type'] == 0) {
            [$email, $role_id] = explode('|', session('data')['email']);
            if ($role_id == config('util.SUPER_ADMIN_ROLE')) {
                $user = User::where([
                    'email' => $email
                ])->first();
                if ($user && $user->hasRole([config('util.SUPER_ADMIN_ROLE')])) {
                    $this->loginUser($user);
//                    Auth::login($user);
//                    if (!session()->has('token')) {
//                        auth()->user()->tokens()->delete();
//                        $token = auth()->user()->createToken("token_admin")->plainTextToken;
//                        session()->put('token', $token);
//                    }
                    return redirect()->route('admin.chart');
                }
                return redirect(route('login'))->with('msg', "Tài khoản của bạn không có quyền truy cập!");
            }
        } else {
            $ggUser = Socialite::driver('google')->user();
            $email = $ggUser->email;

//            $emails = [
//                'thanghq12@fpt.edu.vn',
//                'minhdq8@fpt.edu.vn',
//                'trungnt173@fpt.edu.vn',
//                'haudvph20519@fpt.edu.vn',
//                'vinhndqph26105@fpt.edu.vn',
//            ];
//
//            if (!in_array($email, $emails)) return redirect(route('login'))->with('msg', "Tài khoản của bạn không có quyền truy cập!");
        }
//        $user = User::where('email', $ggUser->email)->where('campus_id', session('campus_id'))->first();
        $user = User::where([
            'email' => $email,
        ])->first();

        if ($user && $user->hasRole([config('util.SUPER_ADMIN_ROLE')])) {
            $this->loginUser($user);
//            Auth::login($user);
//            if (!session()->has('token')) {
//                auth()->user()->tokens()->delete();
//                $token = auth()->user()->createToken("token_admin")->plainTextToken;
//                session()->put('token', $token);
//            }
            return redirect()->route('admin.chart');
        }

        $validator = Validator::make(
            \session('data'),
            [
                'campus_id' => ['required'],
            ],
            [
                'campus_id.required' => 'Vui lòng chọn cơ sở',
            ],
        );
        if ($validator->fails()) {
            return redirect(route('login'))->withErrors($validator)->with(\session('data'));
        }

        if ($user?->campus_id == session('data')['campus_id']) {

            $this->loginUser($user);
            if ($user && $user->hasRole([config('util.ADMIN_ROLE')])) {
                return redirect(route('admin.chart'));
            }

            if ($user && $user->hasRole([config('util.TEACHER_ROLE')])) {
                return redirect(route('admin.semeter.index'));
            }
        }
//        return redirect(route('login'))->with('msg', "Tài khoản của bạn không có quyền truy cập!");
        return redirect(route('login'))->with('msg', "Tài khoản của bạn không có quyền truy cập!");
    }

    private function handleLoginForEachRole($user)
    {
        $route = 'login';
        switch ($user->roles->first()->id) {
            case config('util.SUPER_ADMIN_ROLE'):
            case config('util.ADMIN_ROLE'):
                $route = 'admin.chart';
                break;
            case config('util.TEACHER_ROLE'):
                $route = 'admin.semeter.index';
                break;
        }
//        dd(route($route));
        Auth::login($user);
        if (!session()->has('token')) {
            auth()->user()->tokens()->delete();
            $token = auth()->user()->createToken("token_admin")->plainTextToken;
            session()->put('token', $token);
        }
        return redirect()->route($route);
    }



    private function loginUser($user)
    {
        Auth::login($user);
        if (!session()->has('token')) {
            auth()->user()->tokens()->delete();
            $token = auth()->user()->createToken("token_admin")->plainTextToken;
            session()->put('token', $token);
        }
    }

    public function postLoginToken(Request $request)
    {
        try {

            $client = new \Google_Client(['client_id' => config('util.GOOGLE_CLIENT_ID')]);

            $googleUser = $client->verifyIdToken($request->token);

            if (!$googleUser) {
                return response()->json([
                    'status' => false,
                    'payload' => "Tài khoản không tồn tại hoặc xác thực thất bại",
                ]);
            }

        } catch (Exception $ex) {
            Log::info("=================================");
            Log::error("Lỗi đăng nhập: " . $ex->getMessage());
            Log::error("Token: " . $request->token);
            log::info("=================================");

            return response()->json([
                'status' => false,
                'payload' => "Tài khoản không tồn tại hoặc xác thực thất bại",
            ]);
        }
        // if (!Str::contains($googleUser->email, config('util.END_EMAIL_FPT'))) return response()->json([
        //     'status' => false,
        //     'payload' => "Tài khoản không tồn tại hoặc xác thực thất bại",
        // ]);

        $user = User::with(['roles', 'campus'])->where('email', $googleUser['email'])->first();
//        return response()->json(
//            [
//                'status' => false,
//                'payload' => $user->status,
//            ]
//        );
        if ($user) {
            if ($user->status == 0) return response()->json(
                [
                    'status' => false,
                    'payload' => "Xác thực thất bại",
                ]
            );
            $user->save();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'payload' => [
                    "token" => $token,
                    "token_type" => 'Bearer',
                    'user' => $user->toArray(),
                ],
            ]);
        }
        $flagRoleAdmin = false;
        $MSSV = null;
        if (strlen($googleUser['email']) < 8) $flagRoleAdmin = true;
//        $campus_code = Campus::find($request->campus_code)->code;
        $campus_id = $request->campus_code;
        if (!$flagRoleAdmin) {
//            foreach (config('util.MS_SV') as $ks) {
            $username = \Str::of($googleUser['email'])
//                ->before(config('util.END_EMAIL_FPT'))
                ->before('@')
                ->toString();
            $regexMSSV = "/^(\D*)(\D{2}\d*)$/";
            $MSSV = null;
            preg_match($regexMSSV, $username, $matches);
            if ($matches) {
                $MSSV = strlen($matches[2]) <= 2 ? $username : $matches[2];
            }
//            $MSSV = \Str::lower($campus_code) . \Str::afterLast(
//                    \Str::of($googleUser->email)
//                        ->before(config('util.END_EMAIL_FPT'))
//                        ->toString(),
//                    \Str::lower($ks)
//                );

//                $campus_code = \Str::lower($campus_code);
//            }
        }
//        return $campus_code;
        try {
            $user = null;
            DB::transaction(function () use ($MSSV, $googleUser, &$user, $campus_id) {
                $user = User::create([
                    'mssv' => $MSSV,
                    'name' => $googleUser['name'] ?? 'no name',
                    'email' => $googleUser['email'],
                    'status' => 1,
                    'avatar' => null,
                    'campus_id' => $campus_id,
                ]);
            });
            $user->load('campus');
            if ($flagRoleAdmin && $user) $user->assignRole('admin');
            if (!$flagRoleAdmin && $user) $user->assignRole('student');
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'payload' => [
                    "token" => $token,
                    "token_type" => 'Bearer',
                    'user' => $user->toArray(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'payload' => $e,
            ]);
        }
    }

    public function fake_login(Request $request)
    {
//        $user = User::with('roles')->where('email', $request->email)->first();
        $user = User::with(['roles', 'campus'])->where('email', $request->email_user)->first();
        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'status' => true,
                'payload' => [
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user->toArray(),
                ],
            ]);
        }

        return response()->json([
            'status' => false,
            'payload' => "email không tồn tại",
        ]);
    }

    public function logout()
    {
        if (auth()->check() == false) return redirect(route('login'));
        auth()->user()->tokens()->delete();
        Auth::logout();
        return redirect(route('login'));
    }
}
