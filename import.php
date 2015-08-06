<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>TeamBrewer</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen" type="text/css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" rel="stylesheet">
<script src="js/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link href="css/sb-admin.css" rel="stylesheet">
<link href="css/header.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.2/angular.min.js"></script>
<script src="js/angular-cookies.js"></script>
<script src="js/angular-route.js"></script>
<body ng-app="myApp" ng-controller="userCtrl">
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
                                <input type="file" name="file" /><br/>
                                <button ng-click="submit" class="btn btn-primary btn-md" name="submit">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <script src="https://raw.githubusercontent.com/moment/moment/develop/moment.js"></script>
<script src="https://raw.githubusercontent.com/Eonasdan/bootstrap-datetimepicker/master/build/js/bootstrap-datetimepicker.min.js"></script>

    <script src = "project.js"></script>
</body>
</html>