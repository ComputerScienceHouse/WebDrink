<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>CSH WebDrink</title>
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
        <link href="<?=site_url('css/bootstrap/bootstrap/css/bootstrap-responsive.css')?>" rel="stylesheet">

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="images/favicon.ico">
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/ext-core/3.1.0/ext-core-debug.js" type="text/javascript"></script>
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
            var page_data = <?=$page_data?>;
            var pending_drop = null;
        </script>
        <script type="text/javascript" src="<?=site_url('js/templates.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/handlebars.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/socket.io-client.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/websocket.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/app.js')?>"></script>
        <?php
            if($_SESSION['drink_loggedIn']['drink_admin'] == true)
            {
        ?>
        <script type="text/javascript" src="<?=site_url('js/admin.js')?>"></script>
        <?php
            }
        ?>
    </head>
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="#">CSH Drink</a>
                    <div class="nav-collapse">
                        <ul class="nav" id="navbar_items">
                            <li class="active"><a href="#machines" content_id="machines">Machines</a></li>
                            <li><a href="#drops" content_id="drops">Your Drops</a></li>
                            <?php
                                if($_SESSION['drink_loggedIn']['drink_admin'] == true)
                                {
                            ?>
                            <li><a href="#admin" content_id="admin">User Admin</a></li>
                            <li><a href="#manage" content_id="manage">Manage Items</a></li>
                            <li><a href="#logs" content_id="logs">Logs</a></li>
                            <li><a href="#temps" content_id="temps">Temps</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                        <ul class="nav pull-right">
                            <li><a href="#"><?=$cn?> (<span id="credits"></span> credits)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="modal fade" id="edit_modal">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">×</a>
                    <h3>Editing Slot <span id="edit_slot_num"></span> on <span id="edit_machine_name"></span></h3>
                </div>
                <div class="modal-body">
                    <form class="well form-horizontal" id="edit_slot_form" slot_num="" machine_id="">
                        <div class="control-group">
                            <label class="control-label" for="slot_item">Item</label>
                            <div class="controls">
                                <select name="slot_item" id="slot_item">
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="available">Available</label>
                            <div class="controls">
                                <input type="number" name="available" id="available" value="0" min="0">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="state">State</label>
                            <div class="controls">
                                <select name="state" id="state">
                                    <option value="enabled">Enabled</option>
                                    <option value="disabled">Disabled</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="edit_footer" slot_num="" machine_alias="">
                    <input type="button" class="btn" value="Close" id="close_edit">
                    <input type="button" class="btn btn-success" id="save_edit_slot" value="Save">
                </div>
            </div>
            <div class="modal fade" id="drop_modal">
                <div class="modal-header">
                    <h3>Drop Delay</h3>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label for="drop_delay">Drop Delay</label>
                            <div class="controls">
                                <input type="number" class="input-large" id="drop_delay" value="0" min="0">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-success" btn-action="submit_drop_delay" value="Drop">
                    <input type="button" class="btn btn-danger" btn-action="cancel_drop" value="Cancel">
                </div>
            </div>
            <div class="modal fade" id="dropping_modal">
                <div class="modal-header">
                    <h3>Dropping Drink</h3>
                </div>
                <div class="modal-body" id="dropping_modal_body">
                    Dropping in <span id="drop_countdown"></span>s...
                </div>
            </div>
            <div class="alert alert-info">
                <strong>Welcome to WebDrink!</strong> For any bugs with the web interface, submit them
                <a href="https://github.com/ComputerScienceHouse/WebDrink/issues">here</a>. For any issues with the
                server, submit them <a href="https://github.com/ComputerScienceHouse/Drink-JS/issues">here</a>.
            </div>
            <div class="alert hide" id="websocket_status_alert">
                <strong>Warning!</strong> Web socket not connected!
            </div>
            <div class="alert alert-error hide" id="invalid_ibutton">
                <strong>Error!</strong> Invalid iButton number!
            </div>
            <!--
                Main page content
            -->
            <div class="hide page_content" id="machines">

            </div>
            <div class="hide page_content" id="drops">
                <div class="row">
                    <div class="span12">
                        <h2>Your Drops</h2>
                        <div id="user_drops"></div>
                    </div>
                </div>
            </div>
            <?php
                if($_SESSION['drink_loggedIn']['drink_admin'] == true)
                {
            ?>
            <div class="hide page_content" id="admin">
                <div class="row">
                    <div class="span12">
                        <h2>Manage Users</h2>
                        <hr>
                        <form class="form-search well" id="search_user">
                            <input type="text" class="input-medium search-query" placeholder="CSH username" id="username" name="username">
                            <button type="submit" class="btn">Search</button>
                        </form>
                        <div class="well hide" id="search_user_results">
                            <form class="form-inline" id="manage_user_form">
                                <h3 id="username_header"></h3>
                                <label class="form-inline"><span id="curr_credits"></span></label>
                                <input type="number" name="credits" id="credit_input" value="0" username="">
                                <select name="edit_type" id="edit_type">
                                    <option value="add">Add Credits</option>
                                    <option value="fixed">Fix Amount</option>
                                </select>
                                <input type="submit" value="Submit" class="btn btn-success">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hide page_content" id="manage">
                <div class="row">
                    <div class="span12">
                        <h2>Manage Items</h2>
                    </div>
                </div>
            </div>
            <div class="hide page_content" id="logs">
                <div class="row">
                    <div class="span12">
                        <h2>Drink Logs</h2>
                    </div>
                </div>
            </div>
            <div class="hide page_content" id="temps">
                <div class="row">
                    <div class="span12">
                        <h2>Drink Temps</h2>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
            <footer>
                <div class="row">
                    <div class="span4">
                        <a href="https://github.com/ComputerScienceHouse/Drink-JS">ComputerScienceHouse/Drink-JS</a>
                        <a href="https://github.com/ComputerScienceHouse/WebDrink">ComputerScienceHouse/WebDrink</a>
                    </div>
                    <div class="span4">
                        Made by <a href="https://github.com/seanmcgary">Sean McGary</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
