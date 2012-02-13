<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="<?=site_url('css/bootstrap/bootstrap/css/bootstrap.css')?>" rel="stylesheet">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
    </style>
    <!--<link href="<?=site_url('css/bootstrap/bootstrap/bootstrap-responsive.css')?>" rel="stylesheet">--?

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
</head>

<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">CSH Drink</a>

            <div class="nav-collapse">
                <ul class="nav">
                    <li class="active"><a href="#">Machines</a></li>
                    <li><a href="#about">Your Drops</a></li>
                    <li><a href="#contact">User Admin</a></li>
                    <li><a href="#contact">Manage Items</a></li>
                    <li><a href="#contact">Logs</a></li>
                    <li><a href="#contact">Temps</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<div class="container">
    <div class="modal fade" id="edit_modal">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>

            <h3>Modal header</h3>
        </div>
        <div class="modal-body">
            <p>One fine body…</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-primary">Save changes</a>
            <a href="#" class="btn">Close</a>
        </div>
    </div>
    <div class="modal fade" id="drop_modal">
        <div class="modal-header">
            <h3>Dropping Your Drink</h3>
        </div>
        <div class="modal-body">
            <p>Dropping in 10s...</p>
        </div>
    </div>
    <div class="alert">
        <a class="close">×</a>
        <strong>Warning!</strong> Web socket not connected!
    </div>
    <!-- Example row of columns -->
    <div class="row">
        <div class="span12">
            <h2>Big Drink</h2>

            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th>Slot</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Coke</td>
                        <td>40</td>
                        <td>10</td>
                        <td>
                            <input type="button" class="btn btn-primary" btn-action="drop" value="Drop">
                            <input type="button" class="btn btn-info" value="Edit">
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Coke</td>
                        <td>40</td>
                        <td>10</td>
                        <td>
                            <input type="button" class="btn btn-primary" btn-action="drop" value="Drop">
                            <input type="button" class="btn btn-info" value="Edit">
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Coke</td>
                        <td>40</td>
                        <td>10</td>
                        <td>
                            <input type="button" class="btn btn-primary" btn-action="drop" value="Drop">
                            <input type="button" class="btn btn-info" value="Edit">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="span12">
            <h2>Little Drink</h2>

            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th>Slot</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Coke</td>
                        <td>40</td>
                        <td>10</td>
                        <td>
                            <input type="button" class="btn btn-primary" value="Drop">
                            <input type="button" class="btn btn-info" value="Edit">
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Coke</td>
                        <td>40</td>
                        <td>10</td>
                        <td>
                            <input type="button" class="btn btn-primary" value="Drop">
                            <input type="button" class="btn btn-info" value="Edit">
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Coke</td>
                        <td>40</td>
                        <td>10</td>
                        <td>
                            <input type="button" class="btn btn-primary" value="Drop">
                            <input type="button" class="btn btn-info" value="Edit">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <footer>
        <a href="https://github.com/ComputerScienceHouse/Drink-JS">Github Page</a>
    </footer>

</div>
<!-- /container -->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-transition.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-alert.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-modal.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-dropdown.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-scrollspy.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-tab.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-tooltip.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-popover.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-button.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-collapse.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-carousel.js')?>" type="text/javascript"></script>
<script src="<?=site_url('css/bootstrap/js/bootstrap-typeahead.js')?>" type="text/javascript"></script>

<!-- webdrink shitz -->
<script type="text/javascript">
    var ibutton = '<?=$ibutton?>';
</script>
<!--<script type="text/javascript" src="<?=site_url('js/logger.js')?>"></script>
<script type="text/javascript" src="<?=site_url('js/chosen/chosen/chosen.jquery.min.js')?>"></script>
<script type="text/javascript" src="<?=site_url('js/mustache/mustache.js')?>"></script>
<script type="text/javascript" src="<?=site_url('js/tabs.js')?>"></script>
<script type="text/javascript" src="<?=site_url('js/main.js')?>"></script>
<script type="text/javascript" src="<?=site_url('js/machine_items.js')?>"></script>-->
<!--<script src="https://drink.csh.rit.edu:8080/socket.io/socket.io.js"></script>-->
<script type="text/javascript" src="<?=site_url('js/socket.io-client.js')?>"></script>
<script type="text/javascript" src="<?=site_url('js/websocket.js')?>"></script>
<script type="text/javascript" src="<?=site_url('js/app.js')?>"></script>


</body>
</html>
