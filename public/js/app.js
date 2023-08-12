// Example POST method implementation:
async function likePost(postId) {
    // Default options are marked with *
    const response = await fetch('/reactions', {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, *cors, same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: "follow", // manual, *follow, error
        referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify({
            'post_id' : postId
        }
        ), // body data type must match "Content-Type" header
    });
    var unlikedic = document.getElementById('unliked-icon-' + postId);
    var likedic = document.getElementById('liked-icon-' + postId);
    result = await response.json();
    if(result.action == 'liked') {
        likedic.style.display = "block";
        unlikedic.style.display = "none";
    } else if(result.action == 'unliked'){
        likedic.style.display = "none";
        unlikedic.style.display = "block";
    }
    $("#like-count-" + postId).text(result.count);
    console.log(response.json()); // parses JSON response into native JavaScript objects
    return null;
}

async function addComment(postId, commentText) {
    const response = await fetch('/comments/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
            post_id: postId,
            comment_text: commentText
        })
    });

    if (response.ok) {
        const newComment = await response.json();
        // Thực hiện các hành động cần thiết sau khi thêm comment thành công
        // Ví dụ: cập nhật giao diện để hiển thị comment mới

        console.log(newComment); // Log thông tin của comment mới
    } else {
        console.log('Thêm comment thất bại');
    }
}

$(document).ready(function() {
    $('#add-comment-form').submit(function(event) {
        event.preventDefault(); // Ngăn chặn form gửi yêu cầu mặc định

        var form = $(this);
        var url = form.attr('action');
        var formData = form.serialize(); // Chuyển đổi dữ liệu form thành chuỗi query

        // Gửi yêu cầu Ajax
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json', // Đảm bảo phản hồi từ server là JSON
            success: function(response) {
                // Xử lý phản hồi từ server
                if (response.success) {
                    // Kiểm tra xung đột ID trước khi thêm comment mới
                    var commentId = response.comment.id;
                    if ($('#comment-' + commentId).length > 0) {
                        // Comment đã tồn tại, thực hiện cập nhật nội dung
                        $('#comment-' + commentId).text(response.comment.content);
                    } else {
                        // Comment chưa tồn tại, thêm mới vào danh sách hiển thị
                        var commentItem = '<li id="comment-' + commentId + '">' + response.comment.content + '</li>';
                        $('#comment-list').append(commentItem);
                    }

                    // Xóa nội dung trong textarea
                    $('#add-comment-form textarea').val('');
                } else {
                    // Xử lý khi thêm comment thất bại
                    alert('Thêm comment thất bại');
                }
            },
            error: function() {
                // Xử lý khi có lỗi xảy ra
                alert('Đã có lỗi xảy ra');
            }
        });
    });
});
