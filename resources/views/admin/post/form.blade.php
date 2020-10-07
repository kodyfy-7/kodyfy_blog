<div class="form-group">
    {{Form::label('title', 'Post Title')}}
    {{Form::text('title', old('post_title') ?? $post->post_title, ['id' => 'title', 'class' => 'form-control', 'placeholder' => ''])}}
  </div>

  <div class="form-group">
    {{Form::label('category', 'Select Category')}}
    {{Form::select('category', App\Category::pluck('category_name', 'id'), old('post_title') ?? $post->category_id,['id' => 'category', 'class' => 'form-control', 'placeholder' => 'Select Post Category'])}}
  </div>
  
  <div class="form-group">
    {{Form::label('content', 'Post Content')}}
    {{Form::textarea('content', old('post_title') ?? $post->post_content, ['id' => 'content', 'class' => 'form-control content', 'placeholder' => ''])}}                          
  </div>

  <div class="form-group">
    {{Form::label('status', 'Post Status')}}
    {{Form::select('status', ['draft' => 'Draft', 'active' => 'Active'], null,['id' => 'status', 'class' => 'form-control', 'placeholder' => 'Select Post Status'])}}
  </div>

  <div class="col-md-12">
    {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success btn-block'])}}
  </div>  