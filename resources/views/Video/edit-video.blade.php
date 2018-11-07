@extends('layouts.master')

@section('title')
Videos / Update - Azwaj
@stop

@section('breadcrumb')
 <div class="navbar-header">
            <button class="hamburger btn-link no-animation">
                <span class="hamburger-inner"></span>
            </button>
                        <ol class="breadcrumb hidden-xs">
                                    <li class="active">
                        <a href="{{route('home')}}"><i class="voyager-boat"></i> Dashboard</a>
                    </li>
                      <li class="active">
                        <a href="{{route('video.all')}}"> Videos</a>
                    </li>
                                                                                                                                                
                                                    <li>Edit</li>
                        
                                                </ol>                                                                   </ol>
                    </div>
@stop

@section('page_header')
 <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-video"></i> Edit Video
        </h1>
 </div>        
@stop

@section('content')
                  <div id="voyager-notifications"></div>
                    <div class="page-content container-fluid">
        <form class="form" role="form"
              action="{{route('video.update')}}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
                  {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel ">
                    <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Video Details</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <input type='hidden' name='id' value='{{$video->id}}'>  
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                       value="{{$video->title}}">
                                 @if ($errors->has('title'))
                                    <span class="help-block" >
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">Description</label>
                                <textarea class='form-control' name='description' id='description' cols="3" rows="5" placeholder="Description">{{$video->description}}</textarea>
                                 @if ($errors->has('description'))
                                    <span class="help-block" >
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">Link</label>
                                <textarea class='form-control' name='link' id='link' cols="2" rows="3" placeholder="Video Link">{{$video->link}}</textarea>
                                 @if ($errors->has('link'))
                                    <span class="help-block" >
                                        <strong>{{ $errors->first('link') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                    <label for="additional_roles">Category</label>
                                    <select class="form-control  select2 " name="category_ids[]" multiple="
                                            "
                            >
                        @foreach($categories as $category)
                        @if($videoCategories)
                        @if(in_array(strval($category->id),$videoCategories))
                        <option value="{{$category->id}}" selected>{{$category->title}}</option>
                        @else
                        <option value="{{$category->id}}">{{$category->title}}</option>
                        @endif
                        @else
                        <option value="{{$category->id}}">{{$category->title}}</option>
                        @endif
                        @endforeach
                        
                </select>
                          </div>

                            <div class="form-group">
                                <label for="password">Serial No</label>
                                                                <input type="integer" class="form-control" id="serial_no" name="serial_no" value="{{$video->serial_no}}" >
                            @if ($errors->has('serial_no'))
                                    <span class="help-block" >
                                        <strong>{{ $errors->first('serial_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                             <div class="form-group">
                                    <label for="additional_roles">Suggest By (optional)</label>
                                    <select class="form-control  select2 " name="suggest_by"                                            "
                            > <option value="">None</option>
                        @foreach($users as $user)
                        @if($video->videoSuggestBy)
                        @if($video->videoSuggestBy->id == $user->id)
                        <option value="{{$user->id}}" selected="">{{$user->name}}</option>
                        @else
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endif
                        @else
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endif
                        
                        @endforeach
                        
                </select>
                          </div>

                                                        
                                <div class="form-group">
                                    <label for="additional_roles">Status</label>
                                                                        <select
                    class="form-control  select2 "
                    name="status">
                               @if($video->status == 1 )
                                        <option value="1" selected="selected">Published</option>
                                            <option value="0" >Un Published</option>
                                            @else
                                             <option value="1" >Published</option>
                                            <option value="0" selected="selected" >Un Published</option>
                                            @endif
                </select>
                                     @if ($errors->has('status'))
                                    <span class="help-block" >
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @endif
                                </div>
                                                                          
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-bordered panel-primary">
                         <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Video Thumbnail</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                                                    <img src="{{asset('upload'.$video->img_url)}}" style="width:300px; height:300px; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                                                <input type="file" data-name="avatar" name="img_url">
                             @if ($errors->has('img_url'))
                                    <span class="help-block" >
                                        <strong>{{ $errors->first('img_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                  
                  <div class="row">
                <div class="col-md-8">
                <div class="panel panel-bordered panel-info">
                    <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i>Locales</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                     <div class="panel-body">
                         
                         
                 <div class="input_fields_wrap" >
                      
                     <button type="button" class="add_field_button btn btn-success fileinput-button " style="width:200px;margin-left: 300px;">Add New Language</button><br><br>
                     
                     @foreach($video->videoTranslations as $cT)
                     
                     @if($cT->locale !== 'en')
                     <div>
                         <div class="form-group">
                                    <label for="additional_roles">Locale</label>
                    <select class="form-control  select2 " name="locales[]"
                            ><option value="" selected disabled>None</option>
                        @foreach($locales as $locale)
                        @if($cT->locale == $locale->locale)
                        <option value="{{$locale->locale}}" selected>{{$locale->title}}</option>
                        @else
                        <option value="{{$locale->locale}}">{{$locale->title}}</option>
                        @endif
                        
                        @endforeach
                        
                </select>
                          </div>
                         
                      <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="title_trans" name="title_trans[]" placeholder="Title"
                                       value="{{$cT->title}}">
                                
                            </div>
                          <div class="form-group">
                                <label for="name">Description</label>
                                <input type="text" class="form-control" id="description_trans" name="description_trans[]" placeholder="Description"
                                       value="{{$cT->description}}">
                                 
                            </div>
                          
                          
                    
                    <a href="#" class="remove_field">Remove</a>

                    <br><br>
                   </div>
                     @endif
                     @endforeach
                  </div>
                     </div>
                    </div>
                </div>
                </div>

            <button type="submit" class="btn btn-primary pull-right save">
                Save
            </button>
        </form>

        
    </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('javascript')

       <script>
       


     
        
        $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
$(wrapper).append('<div><div class="form-group"><label for="additional_roles">Locale</label><select class="form-control  select2" name="locales[]"> <option value="" selected disabled>None</option>@foreach($locales as $locale)<option value="{{$locale->locale}}">{{$locale->title}}</option>@endforeach</select></div><div class="form-group"><label for="name">Title</label><input type="text" class="form-control" id="title_trans" name="title_trans[]" placeholder="Title" value=""></div><div class="form-group"><label for="name">Description</label><input type="text" class="form-control" id="description_trans" name="description_trans[]" placeholder="Title" value=""></div><a href="#" class="remove_field">Remove</a><br><br>'); //add input box
        $('.select2').select2();
		}
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });
});
        
    </script>

    

@stop



