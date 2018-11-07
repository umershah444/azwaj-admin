<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use DB;

class Book extends Model
{
     use \Dimsav\Translatable\Translatable;
    
    public $translatedAttributes = ['title','description','pdf'];
    
    protected  $table = 'books';
    
    
    protected $fillable = [
        'reference','status','serial_no','img_url','suggest_by'
        ];
    
    public function bookTranslations()
    {
        return $this->hasMany('App\BookTranslation');
    }
    
    public function bookCategories()
    {
        return $this->hasMany('App\BookCategory')->with('category');
    }
    
    public function bookSuggestBy()
    {
        return $this->belongsTo('App\User' ,'suggest_by');
    }
    
    public function insertNewBook($request)
    {
        $book =  Book::create(Input::except('img_url','title','description','pdf'));
        
        if($request->category_ids){
        foreach($request->category_ids as $category)
        {
            DB::table('book_categories')->insert(['book_id'=>$book->id,'category_id'=>$category]);
        }}
       
        $imgPath = upload_image($book->id, 'Book', 'img_url', 224, 427);
     
        Book::where('id', $book->id)->update(['img_url' => $imgPath]);
        
        
        $id = DB::table('book_translations')->insertGetId(['book_id'=>$book->id,'title'=>$request->title,
                    'description'=>$request->description,'pdf'=>$request->pdf,'locale'=>'en']);
       
        if (Input::hasFile('pdf'))
        {
            $extension = Input::file('pdf')->getClientOriginalExtension();
            $filename = $id. '.' . $extension;
            $fullPath = '/Book/files/'.$filename;
            $request->file('pdf')->move(base_path() . '/public/upload/Book/files/', $filename);
          
            DB::table('book_translations')->where('id',$id)->update(['pdf'=>$fullPath]);
        }
        $ids =array();
        for($i = 0; $i < count($request->title_trans); $i++)
        {
            if($request->locales[$i] != null){
            $bk_id = DB::table('book_translations')->insertGetId(['book_id'=>$book->id,'title'=>$request->title_trans[$i],
                    'description'=>$request->description_trans[$i],'pdf'=>$request->pdf_trans[$i],'locale'=>$request->locales[$i]]);
           
           array_push($ids, $bk_id);
           
            }
            
            }
        $count =0;
         if($request->file('pdf_trans')){
        foreach($request->file('pdf_trans') as $file)
            {
                if ($file)
               {
               $extension = $file->getClientOriginalExtension();
               $filename = $ids[$count]. '.' . $extension;
               $fullPath = '/Book/files/'.$filename;
               $file->move(base_path() . '/public/upload/Book/files/', $filename);
               
               DB::table('book_translations')->where('id',$ids[$count++])->update(['pdf'=>$fullPath]);
               
               }
         }}
    }
    
    public function updateBook($request)
    {
        DB::table('books')->where('id',$request->id)->update(['reference'=>$request->reference,'status'=>$request->status,'serial_no'=>$request->serial_no,'updated_at'=>date('Y-m-d H:i:s')]);
       
        DB::table('book_categories')->where('book_id',$request->id)->delete();
        
        if($request->category_ids){
        foreach($request->category_ids as $category)
        {
            DB::table('book_categories')->insert(['book_id'=>$request->id,'category_id'=>$category]);
        }}
        
         if($request->has('img_url'))
         {
             $imgPath = upload_image($request->id, 'Book', 'img_url', 224, 427);
             Book::where('id', $request->id)->update(['img_url' => $imgPath]);
             
         }
        
        DB::table('book_translations')->where('id',$request->book_trans_en_id)->update(['title'=>$request->title,
                    'description'=>$request->description
                ]);
        if (Input::hasFile('pdf'))
        {
            $extension = Input::file('pdf')->getClientOriginalExtension();
            $filename = $request->book_trans_en_id. '.' . $extension;
            $fullPath = '/Book/files/'.$filename;
            $request->file('pdf')->move(base_path() . '/public/upload/Book/files/', $filename);
          
            DB::table('book_translations')->where('id',$request->book_trans_en_id)->update(['pdf'=>$fullPath]);
        }
        
        $ids =array();
        for($i = 0; $i < count($request->title_trans); $i++)
        {
            
            if($request->locales[$i] != null){
                if($request->book_trans_id[$i] !== null){
                    DB::table('book_translations')->where('id',$request->book_trans_id[$i])->update(['title'=>$request->title_trans[$i],
                    'description'=>$request->description_trans[$i]]);
                    $bk_id = $request->book_trans_id[$i];
            }
            else
            {
             $bk_id = DB::table('book_translations')->insertGetId(['book_id'=>$request->id,'title'=>$request->title_trans[$i],
                    'description'=>$request->description_trans[$i],'locale'=>$request->locales[$i]]);
            }
           array_push($ids, $bk_id);
           
            }
            
            }
        $count =0;
        
        if($request->file('pdf_trans')){
        foreach($request->file('pdf_trans') as $file)
            {
                if ($file)
               {
               $extension = $file->getClientOriginalExtension();
               $filename = $ids[$count]. '.' . $extension;
               $fullPath = '/Book/files/'.$filename;
               $file->move(base_path() . '/public/upload/Book/files/', $filename);
               
               DB::table('book_translations')->where('id',$ids[$count++])->update(['pdf'=>$fullPath]);
               
               }
        }}
    }
}
