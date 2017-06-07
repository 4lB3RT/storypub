<?php 
	include 'head_common.php';
	?>
<?php
$user = $this->dataTable["user"];
$user = $user[0];
?>
<body>
    <section>
        <div class="row">
            <div class="col-md-3">
                <?= $user["email"]; ?>
            </div>
            <div class="col-md-9">

            </div>
        </div>
    </section>
</body>
	
<?php 
	include 'footer_common.php';
?>