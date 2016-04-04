<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title Page</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- jQuery -->
        <script src="//code.jquery.com/jquery.js"></script>        

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <script>
        jQuery(function ($) {
            $('#thumbsup').keypress(function (e) {
                if (e.which == 13) {
                    var count = $('#thumbsup').val();
                    var like = count + '%';
                    if (count>=0 && count<=99) {
                        if (count>=0 && count<=20) {
                            $('.progress-bar').width(like).text(like)
                            .addClass('progress-bar-danger')
                            .removeClass('progress-bar-warning progress-bar-primary progress-bar-info progress-bar-success');
                        }else if (count>=21 && count <=40) {
                            $('.progress-bar').width(like).text(like)
                            .addClass('progress-bar-warning')
                            .removeClass('progress-bar-danger progress-bar-primary progress-bar-info progress-bar-success');
                        }else if (count>=41 && count <=60) {
                            $('.progress-bar').width(like).text(like)
                            .addClass('progress-bar-primary')
                            .removeClass('progress-bar-danger progress-bar-warning progress-bar-info progress-bar-success');
                        }else if (count>=61 && count<=80) {
                            $('.progress-bar').width(like).text(like)
                            .addClass('progress-bar-info')
                            .removeClass('progress-bar-danger progress-bar-warning progress-bar-primary progress-bar-success');
                        }else{
                            $('.progress-bar').width(like).text(like)
                            .addClass('progress-bar-success')
                            .removeClass('progress-bar-danger progress-bar-warning progress-bar-primary progress-bar-info');
                            $('#thumb').animate({fontSize: '48.5px'}, 800).animate({fontSize: '38.5px'}, 800)
                            .animate({fontSize: '48.5px'}, 800).animate({fontSize: '38.5px'}, 800);
                        }

                    }else if (count == 100) {
                        $('.progress-bar').width('100%').text(':D')
                        .addClass('progress-bar-success')
                        .removeClass('progress-bar-danger progress-bar-warning progress-bar-primary progress-bar-info');
                        $('#thumb').animate({fontSize: '600.5px'}, 2000).animate({fontSize: '38.5px'}, 5000)
                        $('#thumb').animate({color: "yellow"}, 5000);
                    }else{
                        var problem = "Houston, we have a problem!"
                        $('.progress-bar').width('100%').text(problem).animate({fontSize: '62px'}, 5000).animate({fontSize: '12px'}, 2000);
                        $('#bar').animate({height: '2000px'}, 5000).animate({height: '20px'}, 500);
                    }

                };
            })
        });
        </script>

        <div id="heart-div" style="height:50px;margin:10px;">
            <h1 id="thumb" class="text-center">
                <span class="glyphicon glyphicon-thumbs-up" style="color:blue" aria-hidden="true"></span>
            </h1>
        </div>

            <script type="text/javascript">
                var itsclicked = false;
            </script>

        <?= $this->Html->progress(50, [
            'type'=>'primary',
            'id'=>'bar',
            'striped'=>'true',
            'active'=>'false',
            'display'=>'true',
            'min'=>'0',
            'max'=>'100'
        ]); ?>

            <?= $this->Form->create(false, [
                'type'=>'get',
                'onsubmit'=>'return itsclicked',
                'horizontal'=>'true',
                'cols'=>[
                    'input'=>2]
                ]); ?>

            <?= $this->Form->input('', [
            'type' => 'number',
            'id'=>'thumbsup',
            'prepend' => 'i:hand-right',
            'min' => '1',
            'max'=>'100',
            'step' => '1'
            ]); ?>





        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
         <script src="Hello World"></script>
    </body>
</html>