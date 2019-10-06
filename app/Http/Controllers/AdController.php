<?php

namespace App\Http\Controllers;

use App\Ad;
use App\AdImage;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAds;

class AdController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::all();

        return view('ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAds $request)
    {
        $userId = auth()->user()->id;

        $title       = $request->get('title');
        $description = $request->get('description');
        $category    = $request->get('category');
        $sex         = $request->get('sex');

        try {
            $ad = Ad::create([
                'title'       => $title,
                'description' => $description,
                'category'    => $category,
                'sex'         => $sex,
                'user_id'     => $userId
            ]);

            if($request->hasfile('images')) {
                $files = $request->file('images');
                foreach ($files as $file) {
                    // Handle File Upload

                    // Get filename with the extension
                    $filenameWithExt = $file->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just ext
                    $extension = $file->getClientOriginalExtension();
                    // Filename to store
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    // Upload Image
                    $file->storeAs('public/images/post', $fileNameToStore); // post = ads, added because of ad blocker

                    AdImage::create([
                        'image_path' => '/storage/images/post/' . $fileNameToStore,
                        'ad_id'      => $ad->id,
                    ]);
                }
            }

            return redirect('/ads/' . $ad->id);

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        $user = User::findOrFail($ad->user_id);

        return view('ads.show', compact('ad', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        //
    }
}
