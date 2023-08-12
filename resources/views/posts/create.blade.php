<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create post page</title>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

</head>
<body>
<h1>Create new post</h1>


<form action="/post" method="post" enctype="multipart/form-data">
    @csrf
    <p>Post title</p>
    <input type="text" name="title" value="{{old('title')}}" >
    @error('title')
    <div class="alert alert-danger" style="color:red;" >{{ $message }}</div>
    @enderror
    <p>Post content</p>
    <textarea name="content">{{old('content')}}</textarea>
    <script>
        ClassicEditor
            .create( document.querySelector( 'textarea[name="content"]' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
    @error('content')
    <div class="alert alert-danger" style="color:red;">{{ $message }}</div>
    @enderror
    <br>
    @foreach($tags as $tag)
        <input type="checkbox" name="tags[]" value="{{$tag->id}}" > {{$tag->name}} <br>
    @endforeach
    <br>
    Select image to upload:
    <img src="{{}}" style=“width:128px;height:128px; alt="">
    <br>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <br>
    <button type="submit">Create</button>
    <br> <br>
    <a href="/post">back</a>

</form>

</body>
</html>
