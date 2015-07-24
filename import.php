<html>
<head>
	<style type="text/css">
	body
	{
		margin: 0;
		padding: 0;
		background-color:#fff;
		text-align:center;
	}
	p
	{
		font-size: 15px;
		font-family: sans-serif;
	}
	a
	{
		color: #999;
		font-size: 30px;
		font-family: sans-serif;
		text-decoration: none;
	}
	a:hover
	{
		color: #fff;
	}
	.top-bar
		{
			width: 100%;
			height: auto;
			text-align: center;
			background-color:#222;
			border-bottom: 1px solid #000;
			padding-top: 30px;
			margin-bottom: 20px;
		}
	.bodybar
		{
			padding-top: 100px;
			border:1px dashed #333333;
			width:300px;
			margin:0 auto; 
			padding:10px;
		}
	.inside-top-bar
		{
			margin-bottom: 5px;
		}
	.link
		{
			font-size: 18px;
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
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-60962033-1', 'auto');
	  ga('send', 'pageview');

	</script>
</head>

<body>
	<div class="top-bar">
		<div class="inside-top-bar">
			<a class="navbar-brand" href="charts.html">teambrewer</a>
			<br><br>
		</div>

	</div>

	<hr class="separator"/>
    <div class="bodybar">
    	<p>Choose file:</p>
		<form name="import" method="post" enctype="multipart/form-data" action="API/import.php">
	    	<input type="file" name="file" /><br/>
	        <input type="submit" name="submit" value="Submit"  />
	    </form>

    </div>

    <hr style="margin-top:200px;" />

</body>
</html>