@extends('layouts.master')
<link href="/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="resources/js/like.js">
<i class="bi bi-envelope-fill"></i>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        // Sử dụng lớp "toggleBtn" cho các nút "Xem thêm"
    var toggleBtns = document.getElementsByClassName('toggleBtn');
    var commentBtns = document.getElementsByClassName('btn comment-button');

    // Lặp qua từng nút "Xem thêm" và thêm sự kiện cho mỗi nút
    document.addEventListener('DOMContentLoaded', function() {
    Array.from(toggleBtns).forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            var postId = this.getAttribute('data-postid');
            var content = document.getElementById('content' + postId);
            var fullContent = document.getElementById('fullContent' + postId);

            if (content.style.display === 'none') {
            content.style.display = 'block';
            fullContent.style.display = 'none';
            this.textContent = 'Xem thêm';
            } else {
            content.style.display = 'none';
            fullContent.style.display = 'block';
            this.textContent = 'Thu gọn';
            }
        });
    });

    Array.from(commentBtns).forEach(function(btn) {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            var postId = this.getAttribute('data-postid');
            var commentArea = document.getElementById('comment-area-' + postId);

            if (commentArea.style.display === "none") {
            // Nếu đang ẩn, hiển thị khu vực comment
            commentArea.style.display = "block";
            } else {
            // Nếu đang hiển thị, ẩn khu vực comment
            commentArea.style.display = "none";
            }
        });
    });
});
    
</script>

<article class="body">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-3"></div>
            <div class="col-6">
                @foreach($posts->sortByDesc('created_at') as $index => $post)
                    @include('partitals.post_card')
                @endforeach
            </div>
        </div>
    </div>
</article>
