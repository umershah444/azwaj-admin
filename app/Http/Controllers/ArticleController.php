<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use App\Article;
use App\Language;
use App\Category;
use App\User;

class ArticleController extends Controller
{
    protected $article;
    
    
    public function __construct() {
        $this->article = new Article();
    }
    public function allArticles()
    {     
        $allArticles = Article::all();
       
        return view('Article.index',compact('allArticles'));
    }
    
    public function addArticleForm()
    {
        $locales = Language::all();
        $categories = Category::all();
        $users = User::all();
        
        return view('Article.add-article',compact('locales','categories','users'));
    }
    
     public function insertArticle(Request $request)
    {
     
         $validator = Validator::make($request->all(), [
            'title' => 'required',
             
             'status' => 'required',
             'description' => 'required',
             'serial_no' => 'numeric'
        ]);
       
         if ($validator->fails()) {
            return redirect('/Article/Add')
                        ->withErrors($validator)
                        ->withInput()
                   ->with([
                'message'    => 'Invalid Inputs!',
                'alert-type' => 'error',
            ]);         
        }
       
        $this->article->insertNewArticle($request);
       
        return redirect()
            ->route('article.all')
            ->with([
                'message'    => 'Article Added Successfully!',
                'alert-type' => 'success',
            ]);
    }
    
    public function editArticleForm($id)
    {
        $article = Article::where('id', $id)->with('articleTranslations','articleCategories','articleSuggestBy')->first();
        
        $locales = Language::all();
        $categories = Category::all();
        $users = User::all();
        
        $articleCategories =array();
        foreach($article->articleCategories as $aC)
        {
            array_push($articleCategories, $aC->category_id);
        }
        
        return view('Article.edit-article',compact('article','categories','users','locales','articleCategories'));
    }
    
    public function updateArticle(Request $request)
    {
        
       
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            
             'status' => 'required',
             'description' => 'required',
             'serial_no'=>'numeric'
        ]);
       
         if ($validator->fails()) {
            return redirect('/Article/Edit/'.$request->id)
                        ->withErrors($validator)
                        ->withInput()
                   ->with([
                'message'    => 'Invalid Inputs!',
                'alert-type' => 'error',
            ]);         
        }
        
         $this->article->updateArticle($request);
        
         
         return redirect()
            ->route('article.all')
            ->with([
                'message'    => 'Article Updated Successfully!',
                'alert-type' => 'success',
            ]);
         
    }
    
    public function detailArticle($id)
    {
        
        $article = Article::where('id', $id)->with('articleTranslations','articleCategories','articleSuggestBy')->first();
       
        return view('Article.detail-article',compact('article'));
    }
    
     public function deleteArticle($id)
    {
         Article::where('id',$id)->delete();
         
       return redirect()
            ->route('article.all')
            ->with([
                'message'    => 'Article Deleted Successfully!',
                'alert-type' => 'success',
            ]);
        
    }
    
    public function bulkDeleteArticles(Request $request)
    {
        
        $ids = explode(',', $request->ids);
       
        foreach($ids as $id)
        {
            Article::where('id',$id)->delete();
        }
        
        return redirect()
            ->route('article.all')
            ->with([
                'message'    => 'Articles Deleted Successfully!',
                'alert-type' => 'success',
            ]);
    }
}
