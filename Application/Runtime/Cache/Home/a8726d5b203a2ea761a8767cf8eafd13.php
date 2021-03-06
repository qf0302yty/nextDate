<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="charset" content="utf-8">
	<title>nextDate</title>
	
	<link rel="stylesheet" href="/NextDate/Public/css/bootstrap.min.css">
	<link href="/NextDate/Public/css/nextDate.css" type="text/css" rel="stylesheet"  >
	<link href="/NextDate/Public/css/animate.css" rel="stylesheet">
</head>
<body>
	<div class="header">
		<div class="title"><h1>Next <span class="glyphicon glyphicon-time"></span> Date</h1></div>
	</div>
	<div class="main">
		<div class="left container">
			<div class="jumbotron">
				<p>请输入年月日：</p>
				<form class="form-horizontal" role="form">
				<hr >
					<div class="form-group">
						<label for="year" class="control-label col-sm-2">年:</label>
						<div class="col-sm-10">
							<input type="text" name="year" id="year"  class="form-control"/>
						</div>
					</div>
					<div class="form-group" >
						<label for="month" class="control-label col-sm-2">月:</label>
						<div class="col-sm-10">
							<input type="text" name="month" id="month"  class="form-control"/>
						</div>
					</div>
					<div class="form-group" >
						<label for="day" class="control-label col-sm-2">日:</label>
						<div class="col-sm-10">
							<input type="text" name="day" id="day"  class="form-control"/>
						</div>
					</div>
					 <div class="form-group button-c-parent">
					    <div class="col-sm-offset-2 col-sm-10 button-container">
					      <button type="button" class="btn btn-primary" id="nextButton">NextDate</button>
					    </div>
					  </div>
				</form>
			</div>
		</div>
		<div class="right">
			<div class="calendar">
				<div class="cal-top"></div>
				<div class="cal-cover">
					<div class="cal-cover-title">
						<span>你怎么过一日</span>
						<span>就怎么过一生</span>
					</div>
				</div>
				<div class="cal-cover-hidden" hidden="true">
					<div class="cal-cover-title">
						<span>你怎么过一日</span>
						<span>就怎么过一生</span>
					</div>
				</div>
				<div class="cal-contain">
					<hr>
					<p><span id="nextYear" class="nextTop">2017</span>年<span id="nextMonth" class="nextTop">三月</span><span id="nextWeek" class="nextTop">星期三</span></p>
					<hr>
					<h1>29</h1>
					<p id="lunar">丁酉年 三月初二</p>
					<hr>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<h1>Powered by Yohann Lee and Lynn Young</h1>
		<!-- <hr> -->
		<h2>Harbin Institute of Technology &copy; 2017</h2>
	</div>
	<script src="/NextDate/Public/js/jquery-1.11.1.min.js"></script>
	<script src="/NextDate/Public/js/jquery.lettering.js"></script>
	<script src="/NextDate/Public/js/bootstrap.min.js"></script>
	<script src="/NextDate/Public/js/jquery.textillate.js"></script>
	<script src="/NextDate/Public/js/jquery.backstretch.min.js"></script>
	
	<script type="text/javascript">
		var add = "<?php echo U('showDate');?>";
		$(document).ready(function() {
			$(".main").backstretch([
                    "/NextDate/Public/img/1.jpg"
	             	], { fade: 1200});

			$('.title').addClass('animated fadeInDown');
			
		});
	</script>

	<script src="/NextDate/Public/js/nextDate.js"></script>
</body>
</html>