<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
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

        #container {
            margin: 10px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }
    </style>

    <script type="application/javascript" src="/awt/js/jquery.js"></script>
    <link href="<?= base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="<?= base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <script type="application/javascript">
        $(document).ready(function () {


        }); // END
    </script>
</head>
<body>
<div id="container">
    <h1>AWT!</h1>
    <div class="eachPost">
        <?php
        if (isset($post)) {
//            print_r($post);
            foreach ($post as $data) {
                echo "<div class='eachPost'> "
                    . "<div class='form-group .col-md-1'>"
                    . "<h2>$data->description</h2>"
                    . "<p> Submitted by: " . $data->user
                    . " at " . date("d/m/Y H:i:s", (($data->date)/1000)) . "</p>"
                    . "<p>Likes: <span id='likes$data->id'>$data->likes </span>"
                    . "<input type='button' name='$data->id' value = 'Like' class='likePost .col-md-6'> "
                    . "Dislikes: <span id='dislikes$data->id'>$data->dislikes"
                    . "</span><input type='button' name='$data->id' value = 'Dislike' class='dislikePost'></p>"
                    . "</div></div><br>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>