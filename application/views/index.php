<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>AWT</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

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

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>

	<script type="application/javascript" src="/awt/js/jquery.js"></script>
	<script type="application/javascript">
		$(document).ready(function () {

			/**
			 * Validate the inputs for empty
			 */
            function validatePostData() {
                return !($('#post').val() === '' || $('#url').val() === '' || $('#user').val() === '');
            }

			/**
			 * For Posting data on button click
			 */
			$('#enterPost').click(function () {
                if(!validatePostData()){
                    alert('All sections need to be filled!') ;
                    return;
                }

				$.ajax({
					url: 'index.php/postController/post',
					method: 'POST',
					dataType: 'json',
					data: 	JSON.stringify({	'id': null,
                                'date': new Date().getTime(),
								'description': $('#post').val(),
								'url': $('#url').val(),
								'user': $('#user').val()
							})
				}).done(function (data) {
                    if(data.error){
                        alert(data.error);
                    } else {
						location.reload();
                        console.log('Inserted: ' + data + ' Post.');
                    }
				});
			}); //

            /*
             * AJAX call when user likes post
             */
            $('.likePost').click(function () {
                $.ajax({
                    url: '<?php echo base_url() ?>index.php/postController/likePost',
                    method: 'POST',
                    data: 	JSON.stringify({'id': parseInt($(this).attr('name')) }),
                    success: function(data){console.log(data)},
                    error: function(data){console.log(data)}
                });
            });

            /*
             * AJAX call when user dislikes post
             */
            $('.dislikePost').click(function () {
                $.ajax({
                    url: '<?php echo base_url() ?>index.php/postController/dislikePost',
                    method: 'POST',
                    data: 	JSON.stringify({'id': parseInt($(this).attr('name')) }),
                    success: function(data){console.log(data)},
                    error: function(data){console.log("something went wrong" + data)}
                });
            });

		}); // END
	</script>
</head>
<body>

<div id="container">
	<h1>AWT!</h1>

	<div id="body">
		User: <input type="text" id="user">
		Post: <input type="text" id="post">
		URL: <input type="url" id="url">
		<button id="enterPost">New Post</button>
	</div>

	<div id="test"></div>

    <div id="posts" class="posts">
		<?php
		if(isset($results)) {
			foreach ($results as $data) {
				echo "<div class='eachPost'> "
					. anchor('commentController/'.$data->id, $data->description)
                    . "<p> Submitted by: " . $data->user
                    . " at " . date("d/m/Y H:i:s", (($data->date)/1000)) . "</p>"
                    . "<p><input type='button' name='$data->id' value = 'Like' class='likePost'> "
                    . "<input type='button' name='$data->id' value = 'Dislike' class='dislikePost'></p>"
                    . "</div><br>";
			}
		}
		?>
		<p class="links">
			<?php
			if(isset($links)){
				echo $links;
			}
			?>
		</p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>