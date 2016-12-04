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
            /*padding: 0 10px 0 10px;*/
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
//                var id = parseInt($(this).attr('name'));
//                var count = $('#dislikes'+id).text();
                $.ajax({
                    url: '<?php echo base_url() ?>index.php/commentController/comment',
                    method: 'POST',
                    data: JSON.stringify(
                        {
                            'user': $('#user').val(),
                            'post': <?php echo $post->id; ?>,
                            'comment': $('#comment').val()/*,
                         'parentComment': 0*/
                        }),
                    success: function (data) {
                        console.log(data);
                        /*$('#dislikes'+id).text(  ++count );*/
                    },
                    error: function (data) {
                        console.log("something went wrong" + data)
                    }
                });
            });

        }); // END
    </script>
</head>
<body>
<div class="container">
    <div id="body">
    <h1>AWT!</h1>
    <div class="eachPost">
        <?php
        if (isset($post)) {
//            print_r($post);
            echo "<div class='eachPost'> "
                . "<div class='form-group .col-md-1'>"
                . "<h2>$post->description</h2>"
                . "<p> Submitted by: " . $post->user
                . " at " . date("d/m/Y H:i:s", (($post->date) / 1000)) . "</p>"
                . "<p>Likes: <span id='likes$post->id'>$post->likes </span>"
                . "<input type='button' name='$post->id' value = 'Like' class='btn btn-success'> "
                . "Dislikes: <span id='dislikes$post->id'>$post->dislikes"
                . "</span><input type='button' name='$post->id' value = 'Dislike' class='btn btn-danger'></p>"
                . "</div></div><br>";
        }
        ?>
    </div>

    <div class="commentBox form-group">
        Enter Comment here : <br>
        <input type="text" placeholder="Username" id="user">
        <textarea id="comment" class="form-control" rows="4" placeholder="Comment"></textarea><br>
        <button id="enterComment" class="btn btn-primary">Comment</button>
    </div>

        <?php
        if (isset($comments)) {

            function printChildComments($childComments)
            {
                foreach ($childComments as $childComment)
                {
                    echo "<div class='container'>"
                        . "<p>$childComment->comment</p>"
                        . "<p>Submitted by: $childComment->user "
                        . "<button class='btn btn-primary' id='$childComment->id'>Reply</button></p>";
                    printChildComments($childComment->childComments);
                    echo "</div>";
                }
            }

            foreach ($comments as $comment) {
                echo "<div class='container'>"
                    . "<p>$comment->comment</p>"
                    . "<p>Submitted by: $comment->user "
                    . "<button class='btn btn-primary' id='$comment->id'>Reply</button></p>";
                    printChildComments($comment->childComments);
                    echo "</div>";
            }
        }
        ?>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. </p>
</div>
</body>
</html>