<? include 'inc/header.php'; ?>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">miniMVC Logo</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="#">About</a></li>
<!--                <li><a href="#">Projects</a></li>-->
<!--                <li><a href="#">Contact</a></li>-->
            </ul>
<!--            <ul class="nav navbar-nav navbar-right">-->
<!--                <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>-->
<!--            </ul>-->
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">
<div class ="messages">
    <div class="container">
        <div class="row">
<!--            @todo error messages block position-->
        <?php foreach($flashes as $flash):?>
        <div class="alert alert-<?= $flash->class?> alert-dismissable  fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?= $flash->message?>
    </div>
          <?php endforeach;?>
        </div>
    </div>
</div>
        <? include 'inc/content.php'; ?>
    </div>
</div>

<? include 'inc/footer.php'; ?>
<? include 'inc/bottom_scripts.php'; ?>
</body>
</html>
