<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('message'))
                    {{ session('message') }}
                @endif
                <h1>The post detail page</h1>
                <h3>Title: {{$post->title}}</h3>
                <h3>Content: {!! $post->content !!}</h3>
                <h3>Author: {{$post->user->name}}</h3>

                @foreach($tags as $tag)
                    <span style="background: lightblue ;margin: 2px ;padding: 2px " >{{$tag->name}}</span>
                @endforeach

                <br>
                <h3>Comments:</h3>
                @foreach($comments as $index => $comment)
                        <table><tr><p id="comment_{{$comment->id}}" ><td> #{{$index+1}}</td><td>  <img  src="/{{$comment->user->user_avatar}}" style=“width:25px;height:25px; ></td> <td>{{$comment->user->name}} said: {{$comment->content}}</td></p></tr></table>

                    @auth
                        @if(Auth::user()->id == $comment->user_id)
                            <form id="edit_comment_{{$comment->id}}" action="/comments/edit" method="post" style="display :none ">
                                @csrf
                                <br>
                                <p>#{{$index+1}}:</p>
                                <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                <textarea name="content" >{{$comment->content}}</textarea>
                                <button onclick="hideEditCommentForm({{$comment->id}})">cancle</button>
                                <button type="submit">update</button>
                            </form>
                            <button id="edit_{{$comment->id}}" onclick="displayEditCommentForm({{$comment->id}})" >edit</button>

                            <script>
                                function displayEditCommentForm(id){
                                    let el = document.getElementById("edit_comment_"+id);
                                    el.style.display = "block";
                                    let cmt = document.getElementById("comment_"+id);
                                    cmt.style.display = "none";
                                    document.getElementById("edit_"+id).style.visibility='hidden';
                                    document.getElementById("delete_"+id).style.visibility='hidden';
                                }

                                function hideEditCommentForm(id){
                                    let el = document.getElementById("edit_comment_"+id);
                                    el.style.display = "none";
                                }

                            </script>

                            
                        @endif
                    @endauth
                @endforeach

                <br>
                <h4>Add new comment:</h4>
                <form action="/comments" method="post" >
                    @csrf
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <textarea name="content"></textarea>
                    <button>send</button>
                </form>

                    @error('content')
                    <div class="alert alert-danger" style="color:red">{{ $message }}</div>
                    @enderror
                    <br>

                @auth
                    @if(Auth::user()->id == $post->user_id)
                        <form action="/post/{{$post->id}}" method="post">
                            @csrf
                            @method('delete')
                            <button>delete</button>
                        </form>
                        <br>

                        <form action="/post/{{$post->id}}/edit" method="get" >
                        @csrf
                            <button>edit</button>
                        </form>
                        <br>
                    @endif
                @endauth
                <a href="/post">back</a>
                 </div>
            </div>
        </div>
    </div>
</x-app-layout>



