<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use App\Video;
use App\Language;
use App\Category;
use App\User;


class VideoController extends Controller
{
    protected $video;
    
    
    public function __construct() {
        $this->video = new Video();
    }
    public function allVideos()
    {     
        $allVideos = Video::all();
       
        return view('Video.index',compact('allVideos'));
    }
    
    public function addVideoForm()
    {
        $locales = Language::all();
        $categories = Category::all();
        $users = User::all();
        
        return view('Video.add-video',compact('locales','categories','users'));
    }
    
     public function insertVideo(Request $request)
    {
     
         $validator = Validator::make($request->all(), [
            'title' => 'required',
             'link' => 'required',
             'status' => 'required',
             'description' => 'max:100',
             'serial_no' => 'numeric'
        ]);
       
         if ($validator->fails()) {
            return redirect('/Video/Add')
                        ->withErrors($validator)
                        ->withInput()
                   ->with([
                'message'    => 'Invalid Inputs!',
                'alert-type' => 'error',
            ]);         
        }
       
        $this->video->insertNewVideo($request);
       
        return redirect()
            ->route('video.all')
            ->with([
                'message'    => 'Video Added Successfully!',
                'alert-type' => 'success',
            ]);
    }
    
    public function editVideoForm($id)
    {
        $video = Video::where('id', $id)->with('videoTranslations','videoCategories','videoSuggestBy')->first();
        
        $locales = Language::all();
        $categories = Category::all();
        $users = User::all();
        
        $videoCategories =array();
        foreach($video->videoCategories as $vC)
        {
            array_push($videoCategories, $vC->category_id);
        }
        
        return view('Video.edit-video',compact('video','categories','users','locales','videoCategories'));
    }
    
    public function updateVideo(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'link' => 'required',
             'status' => 'required',
             'description' => 'max:100',
             'serial_no'=>'numeric'
        ]);
       
         if ($validator->fails()) {
            return redirect('/Video/Edit/'.$request->id)
                        ->withErrors($validator)
                        ->withInput()
                   ->with([
                'message'    => 'Invalid Inputs!',
                'alert-type' => 'error',
            ]);         
        }
        
         $this->video->updateVideo($request);
        
         
         return redirect()
            ->route('video.all')
            ->with([
                'message'    => 'Video Updated Successfully!',
                'alert-type' => 'success',
            ]);
         
    }
    
    public function detailVideo($id)
    {
        
        $video = Video::where('id', $id)->with('videoTranslations','videoCategories','videoSuggestBy')->first();
       
        return view('Video.detail-video',compact('video'));
    }
    
     public function deleteVideo($id)
    {
         Video::where('id',$id)->delete();
         
       return redirect()
            ->route('video.all')
            ->with([
                'message'    => 'Video Deleted Successfully!',
                'alert-type' => 'success',
            ]);
        
    }
    
    public function bulkDeleteVideos(Request $request)
    {
        
        $ids = explode(',', $request->ids);
       
        foreach($ids as $id)
        {
            Video::where('id',$id)->delete();
        }
        
        return redirect()
            ->route('video.all')
            ->with([
                'message'    => 'Videos Deleted Successfully!',
                'alert-type' => 'success',
            ]);
    }
}
