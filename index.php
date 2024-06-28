<!DOCTYPE html>
<?php include_once "includes/functions.php"; ?>
<html>
    <head>
        <meta charset="utf-8" />
        <meta id="viewport" name="viewport" content="width=device-width, initial-scale=1"/>           
        <title>Api Futbol - CD: <?= $cd; ?> - DEV: <?= $dev; ?> - V: <?= $v; ?></title>
        <link href="<?= $protocol; ?>://latam.taptapnetworks.com/rm_lib/rm_libs/css/reset.min.css" rel="stylesheet">  
        <link href="<?= $path; ?>css/style.css" rel="stylesheet"> 
        <script>
            var path = '<?= $path ?>';
            var pathGA = '<?= $pathGA ?>';
            var cd = '<?= $cd ?>';
            var dev = '<?= $dev ?>';
            var v = '<?= $v ?>';
            var test = '<?= $test ?>';
            var timestamp = '<?= $timestamp ?>';
            var ccSonata = '<?= $ccSonata ?>';
            var trackEventsSonata = '<?= $trackEventsSonata ?>';
        </script>         
    </head>
    <body>
        <?= $pixelImg; ?>            
        <div id="container"> 
            <section id="homepage" data-role="page" class="selected">
                <div class="content">
                    <div id="resultados_copa" class=""></div>
                </div>          
            </section>      

        </div>
        <script type="text/javascript" src="<?= $protocol; ?>://latam.taptapnetworks.com/rm_lib/rm_libs/js/jquery-3.1.1.min.js"></script>
        <script type="text/javascript" src="<?= $path; ?>js/script.js"></script>
        <script type="text/javascript" src="<?= $protocol; ?>://latam.taptapnetworks.com/rm_lib/rm_libs/js/script_lib_v3.min.js"></script>
        <script>
            if (test === 'false') {
                (function (i, s, o, g, r, a, m) {
                    i['GoogleAnalyticsObject'] = r;
                    i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
                    a = s.createElement(o),
                            m = s.getElementsByTagName(o)[0];
                    a.async = 1;
                    a.src = g;
                    m.parentNode.insertBefore(a, m)
                })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                ga('create', 'UA-43392489-1', 'auto'); //CAMBIAR EL ID
                ga('send', 'pageview', pathGA + cd + '/' + dev + '/' + v);
                trackingPage('homepage');
            }

        </script>          
    </body>
</html>

