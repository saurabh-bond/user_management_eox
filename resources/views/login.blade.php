<style>
        <?php include public_path('../resources/css/login.css') ?>
</style>
<span style="text-align: center;"><h1>Welcome to EOX Vantage User Management !</h1></span>
<div class="log-form">
    <h2>Login to your account</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="post" action="/login">
        @csrf
        <input type="text" name="email" title="Email" placeholder="Email"/>
        <span style="color: red; font-size: 12px;">
            {{$errors->first('email')}}
        </span>
        <input type="password" name="password" title="Password" placeholder="Password"/>
        <span style="color: red; font-size: 12px;">
            {{$errors->first('password')}}
        </span>
        <button type="submit" class="btn">Login</button>
    </form>
</div><!--end log form -->
