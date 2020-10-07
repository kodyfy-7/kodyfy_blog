<div class="form-group">
    {{Form::label('category_name', 'Category Name')}}
    {{Form::text('category_name', old('category_name') ?? $category->category_name, ['id' => 'category_name', 'class' => 'form-control', 'placeholder' => ''])}}
</div>

<div class="col-md-12">
    {{Form::submit('Submit', ['id' => 'action_button', 'class' => 'btn btn-success btn-block'])}}
</div>  