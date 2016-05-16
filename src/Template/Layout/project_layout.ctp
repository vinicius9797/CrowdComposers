<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="183171778108-n4oe51m5ipe3s9jpho6t1m3rikilr229.apps.googleusercontent.com">
    
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $this->fetch('title') ?></title>

    <!-- Bootstrap and Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/1.5.54/css/materialdesignicons.min.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
     <script src="https://use.fontawesome.com/b2114de3d3.js"></script>
   <!-- SoundCloud API -->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <!-- jPlayer Skin -->
    <!-- <link type="text/css" href="/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" /> -->

    
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('bootstrap') ?>
    <?= $this->Html->script('ajaxSearch.js'); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->element('nav-bar'); ?>
    <?= $this->fetch('nav-bar-blue') ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".alert").fadeTo(4000, 500).slideUp(1000, function () {
                 $(".alert").remove();
            });
        });
    </script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>    
    <div class="content">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>

    <?php
        $default_footer = ROOT.DS.'src'.DS.'Template'.DS.'Element'.DS.'footer.ctp';
        if (file_exists($default_footer)) {
            ob_start();
            include $default_footer;
            echo ob_get_clean();
        }
        else {
            echo $this->element('footer');
        }
    ?>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- jPlayer -->
    <script type="text/javascript" src="/js/jquery.jplayer.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <?= $this->fetch('script') ?>
</body>
</html>
