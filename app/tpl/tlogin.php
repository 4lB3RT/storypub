<?php include 'head_common.php'; ?>
<body>
<section class="text-center">
    <div id="msg"></div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h2>LOGIN!</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form id="form-login" name="login-form" method="POST" action="login/login">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" name="email" id="Email1" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="pass" id="Password1" placeholder="Password" required>
                </div>
                    <button type="button" id="login" class="btn">LOGIN</button>
            </form>
        </div>
    </div>


</section>
</body>