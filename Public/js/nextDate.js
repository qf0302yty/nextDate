
$('#nextButton').click(function(){
	
	var yy = $("#year").val();
	var mm = $("#month").val();
	var dd = $("#day").val();
	
	if (isRight(yy, mm, dd)) {
 		//判断是不是封皮
		var cover = $('.cal-cover');
		if(cover.length>0){
			$.ajax({
			 	url: add,
			 	type: 'POST',
			 	dataType: "json",
			 	data: {year:yy, month:mm, day:dd},
			 	error: function(XMLHttpRequest, textStatus, errorThrown) {
			 		alert(textStatus);
			      	alert(XMLHttpRequest.status);
			 	},
			 	success: function(data, status) {
			 		$('.cal-contain:last').find("#nextYear").html(data[0]);
			 		$('.cal-contain:last').find("#nextMonth").html(data[1]+"月");
			 		$('.cal-contain:last').find("#nextWeek").html("星期"+data[3]);
			 		$('.cal-contain:last').find("h1").html(data[2]);
			 		$('.cal-contain:last').find("#lunar").html(data[4]);
			 		//动画效果
					cover.addClass('animated hinge');
					// setTimeout(function(){
					//        cover.remove();
					//    }, 2000);
					//动画结束回调：删除该页
					cover.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
					 	cover.remove();
					});
			 	}
			 });
			
	
			
		}
 	}
});

$("input").keyup(function() {
	var cover = $(".cal-cover");
	//无封面
	if(cover.length == 0){
		var calendarCover = $('.cal-cover-hidden');
		var calendarPage = $('.cal-contain');

		var clone = calendarCover.clone(true);
		clone = clone.removeClass().addClass('cal-cover');
		clone = clone.removeAttr('hidden');
		
		$('.calendar').append(calendarPage.clone(true));
		calendarPage.css('z-index',100);
		$('.calendar').append(clone);

		//动画效果
		calendarPage.addClass('animated flipInX');
		//动画结束回调：删除原有页面
		calendarPage.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		// calendarPage.remove();
		});

	}
});

function isRight (year, month, day) {
	if(year == null || month == null || day == null){
		alert("请输入完整的年月日信息");
		return false;
	}else if(isNaN(year) || year<1901 || year>2049 || (year==2049 && month==12 && day==31)){
		alert("本系统仅支持1901年01月01日—2049年12月30日的查询");
		return false;
	}else if(isNaN(month) || month < 1 || month > 12){
		alert("请输入正确的月份信息（1—12）");
		return false;
	}else{
		if(isLeap(year)){
			var num = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30 ,31, 30, 31);
			if(day>0 && day<=num[month-1]){
    			return true;
    		}
		}else{
			var num = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30 ,31, 30, 31);
			if(day>0 && day<=num[month-1]){
    			return true;
    		}
		}
		alert("请输入当月正确的日期信息（1—"+num[month-1]+"）")
		return false;
	}
}

function isLeap (year){
	if(year%400 == 0) {
    	return true;
    }else if(year%4 == 0 && year%100 != 0) {
    	return true;
    }else {
    	return false;
    }
}