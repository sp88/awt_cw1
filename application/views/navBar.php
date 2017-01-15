<div class="navbar navbar-inverse" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="/awt/">Idea Talk!</a>

        <?php
        if ($this->session->userdata('logged_in')) {
            echo "<ul class='nav navbar-nav navbar-right'>" .
                "<li><a class='btn' href='#'>Welcome " . $this->session->userdata('username') . "! </a></li>" .
                "<li><a class='btn btn-launch' href='/awt/index.php/profile'>Visit Profile</a>" .
                "</li>" .
                "<li><a class='btn btn-launch' href='javascript:logout();'>Logout</a></li>" .
                "</ul>";
        } else {
            echo '<ul class="nav navbar-nav navbar-right">'.
                '<li><a class="btn btn-launch" href="" data-toggle="modal" data-target="#loginModal"> Sign in '.
                '/ Sign up</a></li>'.
                ' </ul>';
        }
        ?>

    </div>
</div>