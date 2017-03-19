<?php include 'head_common.php'; ?>
<body>
<nav>
    <ul class="row">
        <li class="col-md-4"><h1>Sign In!</h1></li>
        <li class="col-md-4"><h3>Sign Up!</h3></li>
        <li class="col-md-4">
            <i class="fa fa-facebook" aria-hidden="true"></i>
            <i class="fa fa-twitter" aria-hidden="true"></i>
            <i class="fa fa-instagram" aria-hidden="true"></i>

        </li>
    </ul>
</nav>
<section class="text-center">
    <div id="msg"></div>
    <form method="POST" action="index/register/adduser">
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" name="email" id="Email1" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name="pass" id="Password1" placeholder="Password" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input type="password" class="form-control" name="pass_confirm" id="Password_confirm" placeholder="Confirm Password" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Username</label>
            <input type="text" class="form-control" name="username" id="Username" placeholder="Username" required>
        </div>
        <button type="submit" id="" class="btn btn-success">Sign UP</button>
    </form>

</section>
</body>