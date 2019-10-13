<?php

namespace App\Http\Controllers;

use App\Ad;
use App\AdImage;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAd;
use App\Http\Requests\UpdateAd;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreAd $request)
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
        $authUser = auth()->user();

        $adUser = User::findOrFail($ad->user_id);

        $thread = '';

        foreach ($authUser->threads as $authUserThread) {
            foreach ($adUser->threads as $adUserThread) {
                if($authUserThread->id == $adUserThread->id) {
                    $thread = $adUserThread;
                }
            }
        }

        return view('ads.show', compact('ad', 'adUser', 'thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function edit(Ad $ad)
    {
        $adPost = Ad::findOrFail($ad->id);

        return view('ads.edit', compact('adPost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAd $request, Ad $ad)
    {
        $adPost = Ad::findOrFail($ad->id);

        $title       = $request->get('title');
        $description = $request->get('description');
        $category    = $request->get('category');
        $sex         = $request->get('sex');

        try {

            $adPost->title = $title;
            $adPost->description = $description;

            if ( $category !== null ) {
                $adPost->category = $category;
            }

            if( $sex !== null ) {
                $adPost->sex = $sex;
            }

            $adPost->user_id = $ad->id;

            $adPost->save();

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

            return redirect('/my-ads');

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ad $ad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ad $ad)
    {
        $adPost = Ad::findOrFail($ad->id);

        $adImages = AdImage::where('ad_id', $ad->id)->get();

        try {

            foreach ($adImages as $adImage) {
                $path = str_replace('/storage', '', $adImage->image_path);

                Storage::delete('/public'.$path);
            }

            $adPost->delete();

            return redirect('/my-ads');

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    public function myAds()
    {
        $userId = auth()->user()->id;

        $myAds = Ad::where('user_id', $userId)->get();

        return view('ads.my-ads', compact('myAds'));
    }

    public function deleteAdImage($id)
    {
        $adImage = AdImage::findOrFail($id);

        try {

            $path = str_replace('/storage', '', $adImage->image_path);

            Storage::delete('/public' . $path);

            $adImage->delete();

            return redirect()->back();

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }
}
