<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUser;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $name  = $user['name'];
        $email = $user['email'];
        $city  = $user['city'];
        $phone = $user['phone'];
        $image = $user['image'];

        return view('users.show', compact('name', 'email', 'city', 'phone', 'image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $id)
    {
        $user = User::findOrFail($id);

        $name     = $request->get('name');
        $email    = $request->get('email');
        $city     = $request->get('city');
        $phone    = $request->get('phone');
        $password = $request->get('password');

        if ($password === null) {
            $password = $user['password'];
        } else {
            $password = Hash::make($password);
        }

        try {

            $user->name     = $name;
            $user->email    = $email;
            $user->city     = $city;
            $user->phone    = $phone;
            $user->password = $password;

            if($request->hasfile('image')) {
                // Delete previous image
                $path = str_replace('/storage', '', $user->image);
                Storage::delete('/public' . $path);

                // Handle File Upload
                $file = $request->file('image');

                // Get filename with the extension
                $filenameWithExt = $file->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $file->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                // Upload Image
                $file->storeAs('public/images/user', $fileNameToStore);
                // Store Image
                $user->image = '/storage/images/user/' . $fileNameToStore;
            }

            $user->save();

            return redirect('users/' . $id);

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        try {
            $password = $request->get('password-delete');
            $userPass = $user->password;

            if ( Hash::check($password, $userPass) ) {
                $user->delete();

                return redirect()->to('/');
            } else {
                return redirect()->back();
            }

        }  catch (Exception $e) {
            report($e);

            return false;
        }
    }
}
