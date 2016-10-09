<?php
ob_start();
require_once('includes/config.php');
require_once('classes/home.class.php');
require_once('includes/design.class.php');
$home = new home($pdo);
$design = new design();

if (isset($_GET['log'])) {
    $home->logout();
}
if ($_SESSION["loggedin"] != "yes") {
    header("Location:login.php");
    exit();
}
?>
        <!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <?php $design->meta(); ?>
    <link rel="shortcut icon" href="images/icon.png">

    <title>Chef-IT Tools</title>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css"/>
    <link rel="stylesheet" href="fonts/font-awesome-4/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css"/>
    <link rel="stylesheet" type="text/css" href="js/jquery.codemirror/lib/codemirror.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.codemirror/theme/ambiance.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.vectormaps/jquery-jvectormap-1.2.2.css" media="screen"/>
    <link href="css/style.css" rel="stylesheet"/>

</head>
<body class="animated">

<div id="cl-wrapper">

    <?php $design->sidebar() ?>
    <div class="container-fluid" id="pcont">
        <!-- TOP NAVBAR -->
        <?php $design->userOptions(); ?>
        <div class="cl-mcont" id="contentBox">
            <?php
            if(isset($_POST['updatePrefs'])){
                $home->updatePrefs();
            } elseif (isset($_POST['feedback'])){
                $home->saveFeedback();
            }
            ?>
            <div class="row">
                <div id="average" class="col-md-4 col-sm-6">
                    <div class="fd-tile detail clean tile-red">
                        <div class="content"><h1 class="text-left"><?php print $home->averagePercent(); ?>%</h1><p>Average Recipe Cost</p></div>
                        <div class="icon"><i class="fa fa-bolt"></i></div>
                        <a class="details" href="recipelist.php">Details <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
                    </div>
                </div>
                <div id="totalRecipes" class="col-md-4 col-sm-6">
                    <div class="fd-tile detail clean tile-green">
                        <div class="content"><h1 class="text-left"><?php print $home->totalRecipes(); ?></h1><p>Total Recipes</p></div>
                        <div class="icon"><i class="fa fa-cutlery"></i></div>
                        <a class="details" href="recipelist.php">Details <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
                    </div>
                </div>
                <div id="totalProducts" class="col-md-4 col-sm-6">
                    <div class="fd-tile detail clean tile-prusia">
                        <div class="content"><h1 class="text-left"><?php print $home->totalProducts(); ?></h1><p>Total Products</p></div>
                        <div class="icon"><i class="fa fa-fire"></i></div>
                        <a class="details" href="masterlist.php">Details <span><i class="fa fa-arrow-circle-right pull-right"></i></span></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="welcome" class="col-md-7">
                    <div class="block-flat fd-tile detail clean tile-orange">
                        <div class="header">
                            <h3><strong>Welcome to Chef-IT Tools Beta</strong></h3>
                        </div>
                        <div class="content">
                            Giving you the tools so you can just go chef it.<br>
                            Let me know about any weirdness or issues you come across by messaging me on reddit. <a href="https://www.reddit.com/message/compose/?to=xxdalexx">/u/xxdalexx</a><br>
                            <a href="http://imgur.com/a/4Rwdy">Documentation</a>
                        </div>
                        <a class="details"></a>
                    </div>
                </div>
                <div id="prefs" class="col-md-5">
                    <div class="block-flat">
                        <div class="header">
                            <h3>Your Settings</h3>
                        </div>
                        <div class="content">
                            <form action="" id="myform" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
                                <input type="hidden" name="updatePrefs" />
                                <div class="form-group">
                                    <label for="currency" class="col-md-5 control-label">Currency Symbol</label>
                                    <div class="col-md-7">
                                        <select name="currency" class="form-control select2">
                                            <?php
                                            $currency = $home->getCurrency();
                                            $home->currencyOptions($currency);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="costPercent" class="col-md-5 control-label">Cost % Goal</label>
                                    <div class="col-md-7">
                                        <div class="input-group" style="margin-bottom: 0px;">
                                            <input type="text" id="goal" name="goal" value="<?php print $home->getGoal(); ?>" class="form-control" required="">
                                            <span class="input-group-addon">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="system" class="col-md-5 control-label">Preferred Measurements</label>
                                    <div class="col-md-7">
                                        <select name="system" class="form-control select2">
                                            <?php $home->measurementSystemOptions(); ?>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-primary pull-right" type="submit">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="new" class="col-md-6">
                    <div class="block-flat">
                        <div class="header">
                            <h3>New Changes</h3>
                        </div>
                        <div class="content">
                            <h2>Chef-IT Tools is finally back.</h2>
                            <p>The biggest unfortunate issue is that the entire database was lost, and I had to rebuild it from scratch. For that, I am sorry.</p>
                            <p>On the plus side, I am now running it on a server that I completely control instead of a shared hosting. Because of this, here
                                are some issues that I can foresee happening at the beginning.
                            <ul>
                                <li>The old hosting was running outdated software, and I have the most up to date versions that ubuntu supports running now.
                                    This means the main programming language (PHP) and database software may have depreciated some of the techniques I have used.
                                    I believe everything has been updated to meet the new standards, but it is entirely possible there is still something I haven't found yet.</li>
                                <li>We're running on a linux server instead of a Windows one now. Shouldn't mean much for you as a user, but if you come across
                                    any errors that stop the page from loading (like an UNDEFINED something or else error) let me know right away.</li>
                                <li>I have full control of the security certificates now, and you will notice that the URL now starts with HTTPS instead of HTTP now.
                                    So if your neighbors are snooping on your WIFI, everything is encrypted now.</li>
                                <li>Most of all, I now have control over backups, and nothing will get lost again.</li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </div>
                <div id="known" class="col-md-6">
                    <div class="block-flat">
                        <div class="header">
                            <h3>Feedback</h3>
                        </div>
                        <div class="content">
                            <form action="" method="post" id="myform" enctype="multipart/form-data">
                                <textarea name="feedback" style="width: 100%; height: 10em;"></textarea>
                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                            </form>
                        </div>
                    </div>
                    <div class="block-flat">
                        <div class="header">
                            <h3>Known Issues</h3>
                        </div>
                        <div class="content">

                        </div>
                    </div>
                    <div class="block-flat">
                        <div class="header">
                            <h3>Next Steps</h3>
                        </div>
                        <div class="content">
                            <ul>
                                <li>Weight<->Volume Database</li>
                                <li>Inventory</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.js"></script>
<script src="js/jquery.cookie/jquery.cookie.js"></script>
<script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
<script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
<script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="js/behaviour/core.js"></script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="js/jquery.codemirror/lib/codemirror.js"></script>
<script src="js/jquery.codemirror/mode/xml/xml.js"></script>
<script src="js/jquery.codemirror/mode/css/css.js"></script>
<script src="js/jquery.codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="js/jquery.codemirror/addon/edit/matchbrackets.js"></script>
<script src="js/jquery.vectormaps/jquery-jvectormap-1.2.2.min.js"></script>
<script src="js/jquery.vectormaps/maps/jquery-jvectormap-world-mill-en.js"></script>
<script src="js/behaviour/dashboard.js"></script>


<script type="text/javascript" src="js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="js/jquery.flot/jquery.flot.labels.js"></script>
</body>
</html>
