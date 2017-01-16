$(document).ready(function () {


    /**
     * Captures when user clicks sign up tab
     */
    $(document).on('click', '.signup-tab', function (e) {
        e.preventDefault();
        $('#signup-taba').tab('show');
    });

    /**
     * Captures when user clicks sign in tab
     */
    $(document).on('click', '.signin-tab', function (e) {
        e.preventDefault();
        $('#signin-taba').tab('show');
    });

    /**
     * Captures when user clicks forgot tab
     */
    $(document).on('click', '.forgetpass-tab', function (e) {
        e.preventDefault();
        $('#forgetpass-taba').tab('show');
    });

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
        if (!validatePostData()) {
            alert('All sections need to be filled!');
            return;
        }

        $.ajax({
            url: '/awt/index.php/postController/post',
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify({
                'id': null,
                'date': (new Date().getTime() + (3600000 * 4.5)), // add time zone difference
                'description': $('#post').val(),
                'url': $('#url').val()
            })
        }).done(function (data) {
            if (data.error) {
                alert(data.error);
            } else {
                location.reload();
                $('.likePost').prop('disabled', false);
                $('.dislikePost').prop('disabled', false);
                $('#enterPost').prop('disabled', false);
                console.log('Inserted: ' + data + ' Post.');
            }
        });
    }); //

    /*
     * AJAX call when user likes post
     */
    $('.likePost').click(function () {
        var id = parseInt($(this).attr('name'));

        var votepost = new VotePostModel({
            user: '',
            post: id,
            vote: 1
        });
        votepost.save({}, {
            success: function (model, response, options) {
                // console.log("ok: " + response.likes + " "+ response.dislikes);
                $('#likes' + id).text(response.likes);
                $('#dislikes' + id).text(response.dislikes);
            },
            error: function (model, xhr, options) {
                console.log("no");
            }
        });
    });

    /*
     * AJAX call when user dislikes post
     */
    $('.dislikePost').click(function () {
        var id = parseInt($(this).attr('name'));

        var votepost = new VotePostModel({
            user: '',
            post: id,
            vote: 0
        });
        votepost.save({}, {
            success: function (model, response, options) {
                // console.log("ok: " + response.likes + " "+ response.dislikes);
                $('#likes' + id).text(response.likes);
                $('#dislikes' + id).text(response.dislikes);
            },
            error: function (model, xhr, options) {
                console.log("no");
            }
        });
    });

    /*
     * Sort by Date
     */
    $('#sortByDate').click(function () {
        window.location = '/awt/index.php/postController/post?sort=date';
    });

    /*
     * Sort by Vote
     */
    $('#sortByVote').click(function () {
        window.location = '/awt/index.php/postController/post?sort=vote';
    });

    /*
     * Navigate to Home page when title is clicked
     */
    $('.navbar-brand').click(function () {
        window.location = '/awt/index.php';
    });


    $('#register_btn').click(function () {
        var username = $('#username').val();
        var email = $('#remail').val();
        var password = $('#rpassword').val();

        $.ajax({
            url: '/awt/index.php/user',
            method: 'POST',
            data: JSON.stringify({'username': username, 'email': email, 'password': password}),
            success: function (data) {
                $("#closeModalBTN").click();
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('#topNav').html(data);
                $('.likePost').prop('disabled', false);
                $('.dislikePost').prop('disabled', false);
                $('#enterPost').prop('disabled', false);
                $('#enterComment').prop('disabled', false);
                $('.replyButton').prop('disabled', false);
            },
            error: function (data) {
                console.log(data);
            }
        });
    });

    $('#login_btn').click(function () {
        login();
    });



}); // END


/**
 * Get user entered inputs and validate user via AJAX
 */
function login() {
    var username = $('#login_username').val();
    var password = $('#password').val();

    $.ajax({
        url: '/awt/index.php/login',
        method: 'POST',
        data: JSON.stringify({'username': username, 'password': password}),
        success: function (data) {
            console.log(data);
            $("#closeModalBTN").click();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('#topNav').html(data);
            $('.likePost').prop('disabled', false);
            $('.dislikePost').prop('disabled', false);
            $('#enterPost').prop('disabled', false);
            $('#enterComment').prop('disabled', false);
            $('.replyButton').prop('disabled', false);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * Logout user from the system
 */
function logout() {
    $.ajax({
        url: '/awt/index.php/logout',
        method: 'GET',
        success: function (data) {
            console.log("logout");
            $('#topNav').html(data);
            $('.likePost').prop('disabled', true);
            $('.dislikePost').prop('disabled', true);
            $('#enterPost').prop('disabled', true);
            $('#enterComment').prop('disabled', true);
            $('.replyButton').prop('disabled', true);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

/**
 * Backbone Model
 * @type {any}
 */
var VotePostModel = Backbone.Model.extend({
    urlRoot: '/awt/index.php/votePost',
    defaults: {
        user: '',
        post: '',
        vote: '',
        likes: '',
        dislikes: ''
    }
});


function getUserSpecificPosts() {
    $.ajax({
        url: '',
        method: 'GET',
        success: function (data) {
            console.log("logout");
            $('#topNav').html(data);
            $('.likePost').prop('disabled', true);
            $('.dislikePost').prop('disabled', true);
            $('#enterPost').prop('disabled', true);
            $('#enterComment').prop('disabled', true);
            $('.replyButton').prop('disabled', true);
        },
        error: function (data) {
            console.log(data);
        }
    });
}