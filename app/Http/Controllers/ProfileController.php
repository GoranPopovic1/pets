<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $name  = $user['name'];
        $email = $user['email'];
        $city  = $user['city'];
        $phone = $user['phone'];
        $image = $user['image'];

        return view('profile', compact('name', 'email', 'city', 'phone', 'image'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['string', 'min:8', 'confirmed'],
            'phone'    => ['regex:/^[0-9+\-\.\/\(\) ]{6,30}$/']
        ]);
    }

    public function update(Request $request)
    {
        $validationData = array();
        $userData       = Auth::user();

        $name     = $request->get('name');
        $email    = $request->get('email');
        $city     = $request->get('city');
        $phone    = $request->get('phone');
        $password = $request->get('password');

        if ( $name !== $userData['name'] ) {
            $validationData['name'] = $name;
        }

        if ( $email !== $userData['email'] ) {
            $validationData['email'] = $email;
        }

        if ( $phone !== null ) {
            $validationData['phone'] = $phone;
        }

        if ( $password === null ) {
            $password = $userData['password'];
        } else {
            $password = Hash::make($password);
            $validationData['password'] = $password;
        }

        try {

            if ( $this->validator($validationData)->fails() ) {
                return redirect()->back()->withErrors($this->validator($validationData));
            } else {

                $user = \App\User::find($userData['id']);

                if ($request->hasfile('image')) {
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move('storage/images/user/', $filename);
                }

                $user->name = $name;
                $user->email = $email;
                $user->city = $city;
                $user->phone = $phone;
                $user->password = $password;

                $user->save();

                return redirect('/profile');
            }

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }
}
