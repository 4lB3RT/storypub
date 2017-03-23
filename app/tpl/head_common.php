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
</head>
<body>
<header>
    <div class="row text-center">
        <div class="col-md-4 col-md-offset-4">
            <h1>HistoryPub</h1>
        </div>
        <div class="col-md-4">
            <ul>
                <li>
                    <i class="fa fa-facebook" aria-hidden="true"></i>
                    <i class="fa fa-twitter" aria-hidden="true"></i>
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </li>
            </ul>
        </div>
    </div>



</header>
</body>