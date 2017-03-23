<?php include 'head_common.php'; ?>
<body>
<section class="text-center">
    <div id="msg"></div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <h2>SIGN UP!</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <form>
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
                <button type="button" id="sign_up" class="btn">Sign UP</button>
            </form>
        </div>
    </div>


</section>
</body>