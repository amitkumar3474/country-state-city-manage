<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    </head>
<body>
    @if(Session::has('success'))
        <div class="success-message">{{ Session::get('success') }}</div>
    @endif
    @if(Session::has('error'))
        <div class="error-message">{{ Session::get('error') }}</div>
    @endif
    <form action="{{route('loginPost')}}" id="Sign-in" method="post">
        @csrf
        <h1>Sign in</h1>

        <div class="first-input">
            <div class="error">
                @error('email')
                    {{$message}}
                @enderror
            </div>
            <input type="email" name="email" placeholder="Username or Email">
            
            <div class="icon-user">
                <ion-icon name="person"></ion-icon>
            </div>
        </div>

        <div class=second-input>
            <div class="error">
                @error('password')
                    {{$message}}
                @enderror
            </div>
            <input type="password" name="password" value="" placeholder="Password">
            <div class="icon-password">
                <ion-icon name="lock-closed"></ion-icon>            
            </div>
        </div>

        <div class="bottum">
            <input type="checkbox" value="">
            <label for="check">Remember me</label>
            <a href="#">Forgot password?</a>
        </div>

        <button type="submit" name="login">Sign IN</button>

        <div class="creat-account">
            <p>New here? <a href="{{route('registration')}}">Create an Account</a></p>
        </div>
    </form>

    <!-- <script>
        $(document).ready(function(){
            $('#Sign-in').validate({

                rules:{
                    email:{
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages:{
                    email:{
                        required: 'Email required',
                        email: 'Enter Valid Email'
                    },
                    password: {
                        required: 'Password is required',
                        minlength: 'Minimum 6 Character'
                    }
                }
            });
        });
    </script> -->
</body>
</html>