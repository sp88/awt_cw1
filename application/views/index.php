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
    <script type="application/javascript" src="/awt/js/underscore-min.js"></script>
    <script type="application/javascript" src="/awt/js/json2.js"></script>
    <script type="application/javascript" src="/awt/js/backbone-min.js"></script>
    <link href="/awt/css/style.css" rel="stylesheet">
    <link href="<?= base_url(); ?>bootstrap/css/bootstrap.css" rel="stylesheet">
    <script src="<?= base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
    <script type="application/javascript" src="/awt/js/indexFunctions.js"></script>
</head>
<body>

<div id="topNav"> <?php $this->view('navBar'); ?> </div>
<div class="container">

    <?php $this->view('loginModal'); ?>
    <div id="body">
        <br><br>
        User: <input type="text" id="user">
        Post: <input type="text" id="post">
        URL: <input type="url" id="url">
        <?php
            echo "<button id='enterPost' class='btn btn-success' ";
            if($this->session->userdata('logged_in') == 0){
                echo "disabled='1'";
            }
            echo ">New Post</button>";
        ?>
        <br><br>
        <input type="button" id="sortByDate" value="Sort By Date" class="btn btn-primary">
        <input type="button" id="sortByVote" value="Sort By Votes" class="btn btn-primary">
        <br><br>
    </div>

    <div id="test"></div>

    <div id="posts" class="posts">
        <?php
        if (isset($results)) {
            foreach ($results as $data) {
                echo "<div class='container'> "
                    . "<div class='form-group .col-md-1'>"
                    . "<a href=" . base_url() . "index.php/commentController/comment/$data->id>$data->description</a>"
                    . "<p> Submitted by: " . $data->user
                    . " at " . date("d/m/Y H:i:s", (($data->date) / 1000)) . "</p>"
                    . "<p>Likes: <span id='likes$data->id'>$data->likes </span>";

                echo "<input type='button' name='$data->id' value = 'Like' class='btn btn-success likePost' ";
                if ($this->session->userdata('logged_in') == 0) {
                    echo "disabled='1'";
                }
                echo ">";

//                    . "<input type='button' name='$data->id' value = 'Like' class='btn btn-success likePost' disabled='"
//                    . ($this->session->userdata('logged_in') != true). "'>"

                echo " Dislikes: <span id='dislikes$data->id'>$data->dislikes </span>";

                echo "<input type='button' name='$data->id' value = 'Dislike' class='btn btn-danger dislikePost' ";
                if ($this->session->userdata('logged_in') == 0) {
                    echo "disabled='1'";
                }
                echo "></div></div><br>";
//                    . " disabled='"
//                    . ($this->session->userdata('logged_in') != true). "'>"
//                    . "";
            }
        }
        ?>
        <p class="links">
            <?php
            if (isset($links)) {
                echo $links;
            }
            ?>
        </p>
    </div>

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>
</div>

</body>
</html>