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
	$("#followingBallsG").show();
	$("#basresults ul").html('');
	var basdata = {"token":$("#basterm").data("token")};
	api = $.post("search/" + $("#basterm").val(),basdata,function(data){
		if (data.error === false){
			$.each(data.result,function(key,row){
				$("#basresults ul")
					.hide()
					.append('<li data-id="'+row.id+'" class="basword clear"><div class="basbox baseng"><a href="#">'+row.eng+'</a></div><div class="basbox basdv"><a href="#" class="dv">'+row.dhi+' <span class="bascontext">&#151; '+row.latin+'</span></a></div></li>')
					.fadeIn("slow",function(){});
			});
		} else {
			$("#basresults ul")
				.hide()
				.html('<li class="basword clear"><div class="basbox baseng"><a href="#">Not found</a></div><div class="basbox basdv"><a href="#" class="dv">ނުފެނުނު</a></div></li>')
				.fadeIn("slow",function(){});
		}
	}).error(function(){
		if ($("#basterm").val() !== '') {
			$("#basresults .baserror").fadeIn();
		}
	});
	$("#followingBallsG").hide();
}

// delay actions
var delay = (function(){
	var timer = 0;
	return function(callback, ms){
		clearTimeout (timer);
		timer = setTimeout(callback, ms);
	};
})();
