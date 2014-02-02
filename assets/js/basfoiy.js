/**
 *
 * @author Ibrahim Naeem <mbting.9m@gmail.com>
 *
**/

var api = null;

$(document).ready(function(){
    thaanaKeyboard.defaultKeyboard='phonetic';
    $("#followingBallsG").hide();
    $("#basterm").focus();
	//scroll to searchbox 
	$('html, body').animate({ scrollTop: $('#basterm').offset().top }, 'slow');

});

$("#baslang").click(
	function() {
		var lang = $(this).text();
		switch(lang) {
			case "EN" :
				$(this).addClass("dv").text("ހށ");
				$("#basterm").addClass("dv").attr("placeholder","ބަހެއް ޖައްސަވާ").val('').focus();
				thaanaKeyboard.setHandlerById("basterm","enable");
				break;
			case "ހށ" :
				$(this).removeClass("dv").text("EN");
				$("#basterm").removeClass("dv").attr("placeholder","Enter a word").val('').focus();
				thaanaKeyboard.setHandlerById("basterm","disable");
				break;
		}
		return false;
	}
);

$("input").keyup(function(){
	if ($(this).val() === '') {
		$("#baslogo").removeClass("baslogosmall");
		$("#bascontent").removeClass("bascontentsmall");
		$("#basresults ul").fadeOut("slow",function(){
			$(this).html("");
		});
		$("#basresults .baserror").hide();
		if(api !== null) {
			api.abort();
		}
	} else {
		$("#baslogo").addClass("baslogosmall");
		$("#bascontent").addClass("bascontentsmall");
		if ($("#basterm").val() !== '') {
			delay(function(){callWords();}, 500 );
		} 	
	}
});

$("#basform").submit(function(){
	return false;
});

// ajax call
function callWords() {
	console.log("calling words");
	$("#followingBallsG").show();
	$("#basresults ul").html('');
	var basdata = {"token":$("#basterm").data("token")};
	api = $.post("search/" + $("#basterm").val(),basdata,function(data){
		$.each(data,function(key,row){
			console.log(row);
		});
		$("#followingBallsG").hide();
	}).error(function(){
		console.log("Error");
		if ($("#basterm").val() !== '') {
			$("#basresults .baserror").fadeIn();
		}
		$("#followingBallsG").hide();
	});
}

// delay actions
var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();
