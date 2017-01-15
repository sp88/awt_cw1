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

    <script type="application/javascript">
        $(document).ready(function () {

        });
    </script>
</head>
<body>
<?php $this->view('navBar'); ?>
<!--<div class="navbar navbar-default" role="navigation">-->
<!--    <div class="navbar-header">-->
<!--        <a class="navbar-brand" href="/awt/">Idea Talk!</a>-->
<!---->
<!--        --><?php
//        if ($this->session->userdata('logged_in')) {
//            echo "<ul class='nav navbar-nav navbar-right'>" .
//                "<li>" .
//                "<li><a class='btn' href='#'>Welcome " . $this->session->userdata('username') . "! </a></li>" .
//                "<li><a class='btn' href='/awt/index.php/userController/visitProfile'>Visit Profile</a>" .
//                "</li>" .
//                "<li><a class='btn btn-launch' href='/awt/index.php/userController/logout'>Logout</a></li>" .
//                "</ul>";
//        } else {
//            echo '<ul class="nav navbar-nav navbar-right">'.
//                '<li><a class="btn btn-launch" href="" data-toggle="modal" data-target="#loginModal"> Sign in'.
//                '/ Sign up</a></li>'.
//                ' </ul>';
//        }
//        ?>
<!---->
<!--    </div>-->
<!--</div>-->
<div class="container">
    This is the profile!! Welcome

    <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>
</div>
</body>
</html>
