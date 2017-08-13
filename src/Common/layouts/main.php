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
        <? include 'inc/content.php'; ?>
    </div>
</div>

<? include 'inc/footer.php'; ?>
<!--@todo add correct bootstrap link-->
<script src="/bower_components/jquery/dist/jquery.slim.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="/js/utils.js"></script>
</body>
</html>
