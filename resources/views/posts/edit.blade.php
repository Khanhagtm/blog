<x-app-layout>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <link href="{{ asset('ckeditor/sample/css/sample.css') }}" rel="stylesheet">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900"


                <h1>Update this post</h1>
                <form action="/post/{{$post->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <p>Post title</p>
                    <input type="text" name="title" value="{{ $post->title }}" >
                    <br>
                    <p>Post content</p>
                    <textarea name="content" >{{ $post->content }}</textarea>
                    <script>
                        ClassicEditor
                            .create( document.querySelector( 'textarea[name="content"]' ) )
                            .catch( error => {
                                console.error( error );
                            } );
                    </script>
                    <br>
                    @foreach($tags as $tag)
                        <input type="checkbox" value="{{$tag->id}}" name="tags[]" {{ $post->tags->contains($tag)  ? "checked" : ""}}> {{$tag->name}} <br>
                    @endforeach
                    <br>
                    Select image to upload:
                    <img src="/{{$post->post_images}}" style=“width:128px;height:128px; alt="">
                    <br>
                    <input type="file" name="image" id="">
                    <br>
                    <br>
                    <button type="submit">Edit</button>
                </form>


            </div>
        </div>
    </div>
    </div>
</x-app-layout>

