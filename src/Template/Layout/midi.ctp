<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.materialdesignicons.com/1.5.54/css/materialdesignicons.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- SoundCloud API -->
<link rel="stylesheet" href="https://w.soundcloud.com/player/api.js">
<script src="https://connect.soundcloud.com/sdk/sdk-3.0.0.js"></script>
<!-- jPlayer Skin -->
<link type="text/css" href="/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" />


<?= $this->Html->meta('icon') ?>
<?= $this->Html->css('bootstrap') ?>

<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>


</head>

<style>
	#custom-navbar.navbar-default .navbar-brand {
    color: rgba(255, 255, 255, 1);
}
#custom-navbar.navbar-default {
    font-size: 17px;
    background-color: rgba(0, 157, 209, 1);
    border-width: 0px;
    border-radius: 0px;
    box-shadow: 0px 0px 35px rgba(0, 0, 0, .8);
}
#custom-navbar.navbar-default .navbar-nav>li>a {
    color: rgba(255, 255, 255, 1);
    background-color: rgba(0, 157, 209, 1);
    -webkit-transition: 500ms ease all;
    -o-transition: 500ms ease all;
    transition: 500ms ease all;
}
#custom-navbar.navbar-default .navbar-nav>li>a:hover,
#custom-navbar.navbar-default .navbar-nav>li>a:focus {
    color: rgba(4, 192, 255, 1);
    background-color: rgba(0, 113, 151, 1);
    border-radius: 3px;
}
#custom-navbar.navbar-default .navbar-nav>.active>a,
#custom-navbar.navbar-default .navbar-nav>.active>a:hover,
#custom-navbar.navbar-default .navbar-nav>.active>a:focus {
    color: rgba(4, 192, 255, 1);
    background-color: rgba(0, 113, 151, 1);
    border-radius: 3px;
}
#custom-navbar.navbar-default .navbar-nav>ul{
  padding-top: 15px;
}
#custom-navbar.navbar-default .navbar-toggle {
    border-color: #04c0ff;
}
#custom-navbar.navbar-default .navbar-toggle:hover,
#custom-navbar.navbar-default .navbar-toggle:focus {
    background-color: #04c0ff;
}
#custom-navbar.navbar-default .navbar-toggle .icon-bar {
    background-color: #04c0ff;
}
#custom-navbar.navbar-default .navbar-toggle:hover .icon-bar,
#custom-navbar.navbar-default .navbar-toggle:focus .icon-bar {
    background-color: #009dd1;
}
</style>
<body>
<?= $this->element('nav-bar'); ?>
<?= $this->fetch('nav-bar-blue') ?>
<?= $this->fetch('content') ?>	
</body>