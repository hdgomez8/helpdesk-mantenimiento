<!DOCTYPE html>
<html>

<head lang="es">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>HelpDesk - Clinica Mar Caribe</title>

    <link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
    <link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
    <link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
    <link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
    <link href="public/img/favicon.ico" rel="icon">

    <link rel="stylesheet" href="public/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="public/css/lib/font-awesome/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/main.css">

    <style>
        .page-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .page-center-in {
            text-align: center;
        }

        .container-fluid {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .button-link {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background-color:#a3d9db;
            color: black;
            text-decoration: none;
            border-radius: 15px;
            border: none;
            cursor: pointer;
            margin: 30px;
        }

        .button-link img {
            width: 200px;
            height: 200px;
            margin-bottom: 10px;
        }

        .button-link:hover {
            opacity: 0.8;
        }
    </style>

</head>

<body>
    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                <h1>Solicitudes Clínica Marcaribe</h1>

                <a href="http://192.168.1.194:8080/helpdesk/indexLoginMant.php" class="button-link">
                    <img src="./public/img/Mantenimiento.png" width="200" height="200" alt="logo-Mantenimiento" />
                    <span>MANTENIMIENTO</span>
                </a>
                <a href="pagina.html" class="button-link">
                    <img src="./public/img/Ti.png" width="200" height="200" alt="logo-TI" />
                    <span>DEPARTAMENTO DE TI</span>
                </a>
            </div>
        </div>
    </div>

    <script src="public/js/lib/jquery/jquery.min.js"></script>
    <script src="public/js/lib/tether/tether.min.js"></script>
    <script src="public/js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="public/js/plugins.js"></script>
    <script type="text/javascript" src="public/js/lib/match-height/jquery.matchHeight.min.js"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function() {
                setTimeout(function() {
                    $('.page-center').matchHeight({
                        remove: true
                    });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                }, 100);
            });
        });
    </script>
    <script src="public/js/app.js"></script>

    <script type="text/javascript" src="datos.js"></script>

</body>

</html>