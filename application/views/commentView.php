<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>AWT</title>

    <style type="text/css">

        ::selection {
            background-color: #E13300;
            color: white;
        }

        ::-moz-selection {
            background-color: #E13300;
            color: white;
        }

        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
            cursor: pointer;
        }

        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        #body {
            margin: 0 15px 0 15px;
        }

        p.footer {
            text-align: right;
            font-size: 11px;
            border-top: 1px solid #D0D0D0;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
        }

        .container {
            margin: 10px;
            overflow: hidden;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }
    </style>

    <script type="application/javascript" src="/awt/js/jquery.js"></script>
<!--    <link href="--><?//= base_url(); ?><!--css/style.css" rel="stylesheet">-->
    <link href="<?= base_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="<?= base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <script type="application/javascript">
        $(document).ready(function () {

            /**
             * Validate entered fields
             */
            function validateCommentData() {
                if ($('#user').val() == '' || $('#comment').val() == '') {
                    return false;
                }
                return true;
            }

            /*
             * Add entered comment to DB
             */
            $('#enterComment').click(function () {
                if (!validateCommentData()) {
                    alert('All fields must be filled');
                    return;
                }

                $.ajax({
                    url: '<?php echo base_url() ?>index.php/commentController/comment',
                    method: 'POST',
                    data: JSON.stringify(
                        {
                            'user': $('#user').val(),
                            'post': <?php echo $post->id; ?>,
                            'comment': $('#comment').val(),
                            'date': (new Date().getTime() + (3600000*4.5)) // add time zone difference
                        }),
                    success: function (data) {
                        console.log(data);
                        /*$('#dislikes'+id).text(  ++count );*/
                    },
                    error: function (data) {
                        console.log("something went wrong" + data);
                        alert('Something went wrong, Please try again later');
                        location.reload();
                    }
                });
            });


            /*
             * When a user hit reply button show necessary fields / toggle fields
             */
            $('.replyButton').click(function () {
                var id = parseInt($(this).attr('name'));
                $('#userInput'+id).toggle();
                $('#userReply'+id).toggle();
                $('#replyButton'+id).toggle();
            });

            function validateReplyData(id) {
                if($('#userInput'+id).val() == '' || $('#userReply'+id).val() == ''){
                    return false;
                }
                return true;
            }

            /*
             * Send Reply data to Controller to be saved
             */
            $('.sendReplyButton').click(function () {
                var id = parseInt($(this).attr('name'));
                if(!validateReplyData(id)){
                    alert('Fields must be filled!');
                    return;
                }
                $.ajax({
                    url: '<?php echo base_url() ?>index.php/commentController/reply',
                    method: 'POST',
                    data: JSON.stringify(
                        {
                            'user': $('#userInput'+id).val(),
                            'comment': $('#userReply'+id).val(),
                            'parentComment':id,
                            'date': (new Date().getTime() + (3600000*4.5)) // add time zone difference
                        }),
                    success: function (data) {
                        console.log(data);
                        location.reload();
                    },
                    error: function (data) {
                        console.log("something went wrong" + data);
                        alert('Something went wrong, Please try again later');
                        location.reload();
                    }
                });
            });

            /*
             * AJAX call when user likes post
             */
            $('.likePost').click(function () {
                var id = parseInt($(this).attr('name'));
                var count = $('#likes'+id).text();
                $.ajax({
                    url: '<?php echo base_url() ?>index.php/postController/likePost',
                    method: 'POST',
                    data: 	JSON.stringify({'id': id }),
                    success: function(data){console.log(data); $('#likes'+id).text(  ++count );},
                    error: function(data){console.log(data)}
                });
            });

            /*
             * AJAX call when user dislikes post
             */
            $('.dislikePost').click(function () {
                var id = parseInt($(this).attr('name'));
                var count = $('#dislikes'+id).text();
                $.ajax({
                    url: '<?php echo base_url() ?>index.php/postController/dislikePost',
                    method: 'POST',
                    data: 	JSON.stringify({'id': id }),
                    success: function(data){console.log(data); $('#dislikes'+id).text(  ++count );},
                    error: function(data){console.log("something went wrong" + data)}
                });
            });

            /*
             * Navigate to Previous page when title is clicked
             */
            $('h1').click(function () {
                location.replace(document.referrer);
            });

        }); // END
    </script>
</head>
<body>
<div class="container">
    <div id="body">
    <h1>Idea Talk!</h1>
    <div class="eachPost">
        <?php
        if (isset($post)) {
//            print_r($post);
            echo "<div class='container'> "
                . "<div class='form-group .col-md-1'>"
                . "<h2>$post->description</h2>"
                . "<p> Submitted by: " . $post->user
                . " at " . date("d/m/Y H:i:s", (($post->date) / 1000)) . "</p>"
                . "<p>Likes: <span id='likes$post->id'>$post->likes </span>"
                . "<input type='button' name='$post->id' value = 'Like' class='btn btn-success likePost'> "
                . "Dislikes: <span id='dislikes$post->id'>$post->dislikes"
                . "</span><input type='button' name='$post->id' value = 'Dislike' class='btn btn-danger dislikePost'></p>"
                . "</div></div><br>";
        }
        ?>
    </div>

    <div class="container form-group">
        <h3> Enter Comment here : </h3><br>
        <input type="text" placeholder="Username" id="user"> <br><br>
        <textarea id="comment" class="form-control" rows="4" placeholder="Comment"></textarea><br>
        <button id="enterComment" class="btn btn-primary">Comment</button> <br><br>
    </div>

        <?php
        echo "<h3>User Comments</h3>";
        if (isset($comments)) {

            function printChildComments($childComments)
            {
                foreach ($childComments as $childComment)
                {
                    printComment($childComment);
                }
            }

            function printComment($comment)
            {
                echo "<div class='container'>"
                    . "<p>$comment->comment</p>"
                    . "<p>Submitted by: $comment->user "
                    . " at " . date("d/m/Y H:i:s", (($comment->date)/1000)) . " "
                    . "<button class='btn btn-link replyButton' id='showReplyArea$comment->id' name='$comment->id'>"
                    . "Reply</button></p>"
                    . "<div><input type='text' id='userInput$comment->id' placeholder='User' style='display:none'></div>"
                    . "<div><textarea type='text' id='userReply$comment->id' placeholder='Reply' class='form-control'
                            style='display:none'></textarea></div>"
                    . "<div><input type='button' id='replyButton$comment->id' value = 'Reply' name='$comment->id'
                            class='btn btn-primary sendReplyButton' style='display:none'></div>"
                ;
                printChildComments($comment->childComments);
                echo "</div>";
            }

            foreach ($comments as $comment) {
                printComment($comment);
            }
        }
        ?>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. </p>
</div>
</body>
</html>