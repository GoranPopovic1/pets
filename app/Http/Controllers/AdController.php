<?php

namespace App\Http\Controllers;

use App\Ad;
use App\AdImage;
use App\User;
use App\Category;
use App\Sex;
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

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Ad::orderBy('id', 'desc')->take(5)->get();
        $categories = Category::all();
        $sexes = Sex::all();

        return view('ads.index', compact('ads', 'categories', 'sexes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $sexes = Sex::all();

        return view('ads.create', compact('categories', 'sexes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAd $request)
    {
        $validated = $request->validated();
        $userId = auth()->user()->id;

        $title = $validated['title'];
        $description = $validated['description'];
        $category_id = $validated['category'];
        $sex_id = $validated['sex'];

        try {

            $ad = Ad::create([
                'title'       => $title,
                'description' => $description,
                'category_id' => $category_id,
                'sex_id'      => $sex_id,
                'user_id'     => $userId
            ]);

            if ($request->hasfile('images')) {
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
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
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

        if (!empty($authUser->threads) && !empty($adUser->threads)) {

            foreach ($authUser->threads as $authUserThread) {

                foreach ($adUser->threads as $adUserThread) {

                    if ($authUserThread->id == $adUserThread->id) {
                        $thread = $adUserThread;
                    }
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

        $categories = Category::all();
        $sexes = Sex::all();

        return view('ads.edit', compact('adPost', 'categories', 'sexes'));
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
        $validated = $request->validated();
        $adPost = Ad::findOrFail($ad->id);

        $title = $validated['title'];
        $description = $validated['description'];
        $category_id = $validated['category'];
        $sex_id = $validated['sex'];

        try {

            $adPost->title = $title;
            $adPost->description = $description;

            if ($category_id !== '') {
                $adPost->category_id = $category_id;
            }

            if ($sex_id !== '') {
                $adPost->sex_id = $sex_id;
            }

            $adPost->user_id = $ad->id;

            $adPost->save();

            if ($request->hasfile('images')) {
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
                    $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                    // Upload Image
                    $file->storeAs('public/images/post', $fileNameToStore); // post = ads, added because of ad blocker

                    AdImage::create([
                        'image_path' => '/storage/images/post/' . $fileNameToStore,
                        'ad_id'      => $ad->id,
                    ]);
                }
            }

            return redirect('/user/ads');

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

                Storage::delete('/public' . $path);
            }

            $adPost->delete();

            return redirect('/my-ads');

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    public function userAds()
    {
        $userId = auth()->user()->id;

        $userAds = Ad::where('user_id', $userId)->get();

        return view('ads.user_ads', compact('userAds'));
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

    public function usersAds($id)
    {
        $usersAds = Ad::where('user_id', $id)->get();

        return view('ads.users_ads', compact('usersAds'));
    }

    public function searchFormData(Request $request)
    {
        try {

            $params = $request->except('_token');

            if(!array_filter($params)) {
                return redirect('/search?page=1');
            }

            return redirect('/search?' . http_build_query($params) . '&page=1');

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    public function searchResults(Request $request)
    {
        try {
            $params = $request->query();

            $sort = [
                'column' => 'created_at',
                'direction' => 'desc'
            ];

            if(isset($params['sort'])) {
                switch ($params['sort']) {
                    case 'date-asc':
                        $sort['column'] = 'created_at';
                        $sort['direction'] = 'asc';
                        break;
                    case 'name-asc':
                        $sort['column'] = 'title';
                        $sort['direction'] = 'asc';
                        break;
                    case 'name-desc':
                        $sort['column'] = 'title';
                        $sort['direction'] = 'desc';
                        break;
                }
            }

            $ads = Ad::filter($params)->orderBy($sort['column'], $sort['direction'])->paginate(2);

            if(array_filter($params)) {
                $ads->appends($params);
            }

            foreach ($ads as $ad) {
                $ad['images'] = $ad->images;
                $ad['user'] = $ad->user;
                $ad['sex'] = $ad->sex;
            }

            $categories = Category::all();
            $sexes = Sex::all();

            $data = [
                'ads' => $ads,
                'categories' => $categories,
                'sexes' => $sexes,
            ];

            return response()->json($data);

        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    public function search()
    {
        return view('ads.search');
    }
}
