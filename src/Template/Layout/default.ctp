<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= $this->fetch('title') ?></title>


    <!-- Bootstrap and Font Awesome -->
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/1.5.54/css/materialdesignicons.min.css">
  

    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('bootstrap') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://localhost:8080/">Cake</a>
            <ul class="nav navbar-nav">
                <li>
                    <a href="/codes">Codes</a>
                </li>
                <li>
                    <a href="/posts">Posts</a>
                </li>
                <li>
                    <a href="/projects">Project</a>
                </li>
            </ul>
        </div>
    </nav>
    <section class="container clearfix">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </section>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <?= $this->fetch('script') ?>
</body>
</html>
