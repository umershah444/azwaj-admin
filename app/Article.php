<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Article extends Model
{
    use \Dimsav\Translatable\Translatable;
    
    public $translatedAttributes = ['title','description'];
    
    protected  $table = 'articles';
    
    
    protected $fillable = [
        'reference','status','serial_no','img_url','suggest_by'
        ];
    
    public function articleTranslations()
    {
        return $this->hasMany('App\ArticleTranslation');
    }
    
    public function articleCategories()
    {
        return $this->hasMany('App\ArticleCategory')->with('category');
    }
    
    public function articleSuggestBy()
    {
        return $this->belongsTo('App\User' ,'suggest_by');
    }
    
    public function insertNewArticle($request)
    {
        $article =  Article::create(Input::except('img_url','title','description'));
        
        if($request->category_ids){
        foreach($request->category_ids as $category)
        {
            DB::table('article_categories')->insert(['article_id'=>$article->id,'category_id'=>$category]);
        }}
       
        $imgPath = upload_image($article->id, 'Article', 'img_url', 224, 427);
     
        Article::where('id', $article->id)->update(['img_url' => $imgPath]);
        
        
        DB::table('article_translations')->insert(['article_id'=>$article->id,'title'=>$request->title,
                    'description'=>$request->description,'locale'=>'en']);
        
        for($i = 0; $i < count($request->title_trans); $i++)
        {
            if($request->locales[$i] != null){
            DB::table('article_translations')->insert(['article_id'=>$article->id,'title'=>$request->title_trans[$i],
                    'description'=>$request->description_trans[$i],'locale'=>$request->locales[$i]]);
        }}
    }
    
    public function updateArticle($request)
    {
        DB::table('articles')->where('id',$request->id)->update(['reference'=>$request->reference,'status'=>$request->status,'serial_no'=>$request->serial_no,'updated_at'=>date('Y-m-d H:i:s')]);
       
        DB::table('article_categories')->where('article_id',$request->id)->delete();
        
        if($request->category_ids){
        foreach($request->category_ids as $category)
        {
            DB::table('article_categories')->insert(['article_id'=>$request->id,'category_id'=>$category]);
        }}
        
        if (Input::hasFile('img_url'))
         {
             $imgPath = upload_image($request->id, 'Article', 'img_url', 224, 427);
             Article::where('id', $request->id)->update(['img_url' => $imgPath]);
             
         }
        
         DB::table('article_translations')->where('article_id',$request->id)->delete();
        
        DB::table('article_translations')->insert(['article_id'=>$request->id,'title'=>$request->title,
                    'description'=>$request->description,'locale'=>'en'
                ]);
        
        for($i = 0; $i < count($request->title_trans); $i++)
        {
            if($request->locales[$i] != null){
            DB::table('article_translations')->insert(['article_id'=>$request->id,'title'=>$request->title_trans[$i],
                    'description'=>$request->description_trans[$i],'locale'=>$request->locales[$i]
                ]);
        }}
    }
}
