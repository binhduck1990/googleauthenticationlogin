<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container" style="margin-top: 100px">
    <div class="row">
        <form method="post" enctype="multipart/form-data" class="form-horizontal">
            <div class="col-md-12"
                 style="border: 3px solid black; text-align: left; padding-top: 20px; padding-bottom: 20px">
                <div class="col-md-2">
                    <img style="border-radius: 50%; display: block; margin: auto; cursor: pointer"
                         src="/images/{{$user['avatar']}}" width="100px" height="100px" id="avatar">
                    <p style="text-align: center; font-weight: 700" id="avatar-name">Avatar</p>
                    <input name="avatar" type="file" id="uploadfile" style="display: none" onchange="changeAvatar()"
                           accept="image/x-png,image/gif,image/jpeg"/>
                </div>

                <div class="form-group">
                    <div class="col-md-8">
                        <div class="col-md-12" style="margin-bottom: 10px">
                            <label>Your email address:</label>
                            <input type="text" name="email" class="form-control input-submit" value="{{$user['email']}}">
                        </div>

                        <div class="col-md-12" style="margin-bottom: 10px">
                            <label>Your phone:</label>
                            <input type="text" name="phone" class="form-control input-submit" value="{{$user['phone']}}">
                        </div>

                        <div class="col-md-12" style="margin-bottom: 10px">
                            <label>Full name:</label>
                            <input type="text" name="name" class="form-control input-submit" value="{{$user['name']}}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-2" style="text-align: right">
                        <a href="/logout" class="btn btn-default" style="; font-weight: 700; font-size: 20px">Logout</a>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-10 col-md-2" style="text-align: right; font-weight: 600">
                        <button id="button-submit" type="submit" class="btn btn-default" style="; font-weight: 700; font-size: 20px">Save
                            Profile
                        </button>
                    </div>
                </div>

                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
            </div>
            {!! csrf_field() !!}
        </form>
    </div>
</div>
</body>
</html>

<script>
    $("#avatar").click(function () {
        $("#uploadfile").click();
    });

    function changeAvatar() {
        var avatar = document.querySelector('#avatar');
        var file = document.querySelector('#uploadfile').files[0];
        var reader = new FileReader();

        reader.addEventListener("load", function () {
            avatar.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
            $("#avatar-name").text(file.name);
        }
    }

    $('.input-submit').keypress(function (e) {
        if (e.which == 13) {
            $('#button-submit').click();
            return false;
        }
    });
</script>