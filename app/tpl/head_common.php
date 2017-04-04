<?php
if(!isset($_SESSION))
{
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?= $this->page;?></title>
	<link rel="stylesheet" href="<?= APP_W.'pub/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?= APP_W.'pub/css/hover.css'; ?>">
    <link rel="stylesheet" href="<?= APP_W.'pub/css/site.css'; ?>">
    <link rel="stylesheet" href="<?= APP_W.'pub/css/'.$this->page; ?>.css">
    <link rel="stylesheet" href=" https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="<?= APP_W.'pub/js/md5.min.js'?>"></script>
    <script type="text/javascript" src="<?= APP_W.'pub/js/'.$this->page; ?>.js" ></script>
    <script type="text/javascript" src="<?= APP_W.'bower_components/bootstrap/dist/js/bootstrap.min.js'?>"></script>
</head>
<body>
<header>
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-md-4 col-md-offset-4 text-center">
                <a href="home"><h1>HistoryPub</h1></a>
            </div>
            <div class="col-md-4 ul-rss">
                <ul>
                    <li>
                        <a href="https://www.facebook.com"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="https://www.twitter.com"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="https://www.instagram.com"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                        <?php
                        if(\X\Sys\Session::exist('user')){
                            echo'<a href="login/disconnect" id="disconnect" class="btn btn-danger">Disconnect</a>';
                        }
                        ?>

                    </li>
                </ul>
            </div>
        </div>
    </div>



</header>
</body>