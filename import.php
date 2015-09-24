<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>TeamBrewer</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/sb-admin.css" rel="stylesheet">
<link href="css/header.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="js/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.2/angular.min.js"></script>
<script src="js/angular-cookies.js"></script>
<script src="js/angular-route.js"></script>
    <style type="text/css">
    html, body {
        width: 100%;
        height: 100%;
    }
   
    </style>
<body ng-app="myApp" ng-controller="importCtrl">
</head>
<div id="wrapper">
    <style type="text/css">
        .top-bar
            {
                width: 100%;
                height: auto;
                text-align: center;
                background-color:#222;
                border-bottom: 1px solid #000;
                padding-top: 30px;
                margin-bottom: 20px;text-align:center;
            }
        .bodybar
            {
                padding-top: 100px;
                border:1px dashed #333333;
                width:300px;
                margin:0 auto; 
                padding:10px;text-align:center;
            }
        .inside-top-bar
            {
                margin-bottom: 5px;
                text-align:center;
            }
        .link
            {
                text-decoration: none;
                background-color: #222;
                color: #FFF;
                padding: 5px;
            }
        .link:hover
            {
                background-color: #9688B2;
            }

        .import
        {
            float:center;

        }
        .separator
        {
            margin-bottom:100px;
            color: transparent;
        }
    </style>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="charts.html">teambrewer</a>
        </div>

        <div ng-include="'logout.html'"></div>

        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <div ng-include="'navbar.html'"></div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Import Data</h1>
                    <div class="table-responsive">
                        <div class="bodybar">
                            <p>Choose file:</p>
                            <form name="import" method="post" enctype="multipart/form-data" action="API/import.php" target="_blank">
                                <input type="text" style="display:none" ng-model="access_token" name="access_token"/>
                                <input type="file" name="file" /><br/>
                                <button ng-click="submit" class="btn btn-primary btn-md" name="submit">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="js/moment.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src = "import.js"></script>

    <script src="js/factories/auth.js"></script>    
</body>
</html>