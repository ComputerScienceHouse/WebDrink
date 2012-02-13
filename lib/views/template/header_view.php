<!DOCTYPE html>
<html>
    <head>
        <title>CSH Web Drink</title>
        <link href="<?=site_url('css/stylesheets/screen.css')?>" rel="stylesheet" type="text/css">
        <link href="<?=site_url('js/chosen/chosen/chosen.css')?>" rel="stylesheet" type="text/css">
        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/ext-core/3.1.0/ext-core-debug.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
        <script type="text/javascript" src="<?=site_url('js/logger.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/chosen/chosen/chosen.jquery.min.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/mustache/mustache.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/tabs.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/main.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/machine_items.js')?>"></script>
        <!--<script src="https://drink.csh.rit.edu:8080/socket.io/socket.io.js"></script>-->
        <script type="text/javascript" src="<?=site_url('js/socket.io-client.js')?>"></script>
        <script type="text/javascript" src="<?=site_url('js/websocket.js')?>"></script>
    </head>
    <body>
        <div class="header">
            <div class="logo">
                CSH Drink
            </div>
            <div class="right">
                Hello, <?=$_SESSION['loggedIn']['cn']?> (<?=$_SESSION['loggedIn']['drink_credits']?> credits)
            </div>
        </div>
        <div class="navigation">
            <ul id="tabs" class="nav-tabs">
                <a href="#" class="tab-link" tab_id="machines"><li>Machines</li></a>
                <a href="#" class="tab-link" tab_id="user_drops"><li>Your Drops</li></a>
            <?php
                if((bool)$_SESSION['loggedIn']['drink_admin'] == true)
                {
            ?>
                <a href="#" class="tab-link" tab_id="admin"><li>User Admin</li></a>
                <a href="#" class="tab-link" tab_id="manage_items"><li>Manage Items</li></a>
                <a href="#" class="tab-link" tab_id="logs"><li>Logs</li></a>
                <a href="#" class="tab-link" tab_id="temps"><li>Temps</li></a>
            <?php
                }
            ?>
            </ul>
        </div>
        <div class="container">