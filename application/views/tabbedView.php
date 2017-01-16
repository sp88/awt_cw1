<div class="panel with-nav-tabs panel-primary">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li id="tab1" class="active"><a href="#tab1primary" data-toggle="tab">Your Posts</a></li>
            <li id="tab2" ><a href="#tab2primary" data-toggle="tab">Posts you have Liked</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane fade in active" id="tab1primary">
                <?php
                    if(isset($posts)){
                        foreach($posts as $post){
                            echo "<div class='container'> "
                                . "<div class='form-group .col-md-1'>"
                                . "<a href=" . base_url() . "index.php/commentController/comment/$post->id>$post->description</a>"
                                . " at " . date("d/m/Y H:i:s", (($post->date) / 1000)) . "</p>"
                                . "<p>Likes: <span id='likes$post->id'> $post->likes </span>"
                                . " Dislikes: <span id='dislikes$post->id'> $post->dislikes </span>"
                                . "</p></div></div>";
                        }
                    }
                ?>
            </div>
            <div class="tab-pane fade" id="tab2primary"></div>
        </div>
    </div>
</div>