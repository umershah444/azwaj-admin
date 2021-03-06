@extends('layouts.master')

@section('title')
Article / Add - Azwaj
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
                        <a href="{{route('article.all')}}"> Articles</a>
                    </li>
                                                                                                                                                
                                                    <li>Create</li>
                        
                                                </ol>                                                                   </ol>
                    </div>
@stop

@section('page_header')
 <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-news"></i> Articles
        </h1>
 </div>        
@stop

@section('content')
                  <div id="voyager-notifications"></div>
                    <div class="page-content container-fluid">
        <form class="form" role="form"
              action="{{route('article.insert')}}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
                  {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel ">
                    <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Article Details</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Title"
                                       value="{{old('title')}}">
                                 @if ($errors->has('title'))
                                    <span class="help-block" >
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">Reference</label>
                                <textarea class='form-control' name='reference' id='reference' cols="2" rows="3" placeholder="Article Reference">{{old('reference')}}</textarea>
                                 @if ($errors->has('reference'))
                                    <span class="help-block" >
                                        <strong>{{ $errors->first('reference') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                    <label for="additional_roles">Category</label>
                                    <select class="form-control  select2 " name="category_ids[]" multiple="
                                            "
                            >
                        @foreach($categories as $category)
                        @if(old('category_ids'))
                        @if(in_array(strval($category->id),old('category_ids')))
                        <option value="{{$category->id}}" selected>{{$category->title}}</option>
                        @else
                        <option value="{{$$category->id}}">{{$category->title}}</option>
                        @endif
                        @else
                        <option value="{{$category->id}}">{{$category->title}}</option>
                        @endif
                        @endforeach
                        
                </select>
                          </div>
                            
                            <div class="form-group">
                                    <label for="additional_roles">Suggest By (optional)</label>
                                    <select class="form-control  select2 " name="suggest_by"                                            "
                            > <option value="">None</option>
                        @foreach($users as $user)
                        @if(old('suggest_by') == $user->id)
                        <option value="{{$user->id}}" selected="">{{$user->name}}</option>
                        @else
                        <option value="{{$user->id}}">{{$user->name}}</option>
                        @endif
                        
                        @endforeach
                        
                </select>
                          </div>

                            <div class="form-group">
                                <label for="password">Serial No</label>
                                                                <input type="integer" class="form-control" id="serial_no" name="serial_no" value="{{old('serial_no')}}" >
                            @if ($errors->has('serial_no'))
                                    <span class="help-block" >
                                        <strong>{{ $errors->first('serial_no') }}</strong>
                                    </span>
                                @endif
                            </div>

                                                         
                                <div class="form-group">
                                    <label for="additional_roles">Status</label>
                                                                        <select
                    class="form-control  select2 "
                    name="status">
                               @if(old('status') == 1 )
                                        <option value="1" selected="selected">Active</option>
                                            <option value="0" >InActive</option>
                                            @else
                                             <option value="1" >Active</option>
                                            <option value="0" selected="selected" >InActive</option>
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
                    
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Article Content</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>

                        <div class="panel-body">
                                                                                    <textarea   class="form-control richTextBox" name="description" id="richtextbody"></textarea>

                        </div>
                    </div><!-- .panel -->
                </div>

                <div class="col-md-4">
                     <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i> Article Thumbnail</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                                                        <input type="file" name="img_url">
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
                     <div class="panel-body" style='display:none'>
                 <div class="input_fields_wrap" >
                      
                     <button type="button" class="add_field_button btn btn-success fileinput-button " style="width:200px;margin-left: 34%;">Add New Language</button><br><br>
                      <div>
                           <div class="form-group">
                                    <label for="additional_roles">Locale</label>
                    <select class="form-control  select2 " name="locales[]"
                            ><option value="" selected disabled>None</option>
                        @foreach($locales as $locale)
                        <option value="{{$locale->locale}}">{{$locale->title}}</option>
                        @endforeach
                        
                </select>
                          </div>
                      <div class="form-group">
                                <label for="name">Title</label>
                                <input type="text" class="form-control" id="title_trans" name="title_trans[]" placeholder="Title"
                                       value="{{old('title')}}">
                                
                            </div>
                          <div class="form-group">
                                <label for="name">Content</label>
                                 <textarea row="10"  class="form-control richTextBox" name="description_trans[]" id="richtextbody"></textarea>
                        
                            </div>
                          
                         
                    
                    <a href="#" class="remove_field">Remove</a>

                    <br><br>
                   </div>
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
$(wrapper).append('<div><div class="form-group"><label for="additional_roles">Locale</label><select class="form-control  select2" name="locales[]"> <option value="" selected disabled>None</option>@foreach($locales as $locale)<option value="{{$locale->locale}}">{{$locale->title}}</option>@endforeach</select></div><div class="form-group"><label for="name">Title</label><input type="text" class="form-control" id="title_trans" name="title_trans[]" placeholder="Title" value=""></div><div class="form-group"><label for="name">Content</label><textarea   class="form-control richTextBox" name="description_trans[]" id="richtextbody"></textarea></div><a href="#" class="remove_field">Remove</a>'); //add input box
 $('.select2').select2();
		}
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });
});
        
    </script>

    

@stop



