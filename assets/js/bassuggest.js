/**
 *
 * @author Ibrahim Naeem <mbting.9m@gmail.com>
 *
**/

var api = null;

var maxpages = 0;

$(document).ready(function(){
	words();
	thaanaKeyboard.defaultKeyboard='phonetic';
	thaanaKeyboard.setHandlerByClass("basedit","enable");
	// todo
	// History.Adapter.bind(window,'statechange',function(){ 
	// 	var State = History.getState(); 
	// });
});

// $('#wordsearchterm').keyup(function(){
// 	if ($(this).val().length > 2) {
// 		delay(function(){search();}, 500 );
// 	} else {
// 		words($('#pageno').text());
// 		$("#followingBallsG").hide();
// 	}
// });

$('#wordstable nav a').click(function(){ return false; });

$('.tablenav').click(function(){
	if ($(this).data('page') <= maxpages) {
		words($(this).data('page'));
	}
});

$('#wordstable').on('click','.basinput',function(){
	var wordvalue;
	if ($(this).find('span').length) {
		wordvalue = $(this).find('span').text();
		$(this).html('<input class="basedit" type="text" value="'+wordvalue+'">');

		$(this).find('input').focus();
	}
});

$('#wordstable').on('blur','.basinput input',function(){
	var wordvalue = $(this).val();
	$(this).parent().html('<span>'+ wordvalue +'</span>');
});

function words(page)
{
	$("#followingBallsG").show();
	page = typeof page !== 'undefined' ? page : 1;
	api = $.get('/crowd/suggest/'+page,function(data){
		// console.log(data);
		if (data.error === false) {
			$('.wordrow').remove();
			$.each(data.result,function(key,row){
				$("#wordstable table")
					// .append('<tr class="row wordrow"><td class="column third">'+row.eng+'</td><td class="dv column third">'+row.dhi+'</td><td class="column third">'+row.latin+'</td></tr>');
					.append('<tr class="row wordrow">'
						+ '<td class="basinput column fifth"><span>'+row.eng+'</span></td>'
						+ '<td class="basinput dv column third"><span>'+row.dhi+'</span></td>'
						+ '<td class="basinput column third"><span>'+row.latin+'</span></td>'
						+ '<td class="column tenth bascrowdaction">'
							+ '<a href="#" class="wordacc" data-id="'+row.id+'"><i class="fa fa-check"></i></a>'
							+ '<a href="#" class="wordrej" data-id="'+row.id+'"><i class="fa fa-times"></i></a>'
						+ '</td>'
					+ '</tr>');
			});
			$("#followingBallsG").hide();
			// todo: History.pushState({state:1}, "BasCrowd - page " + page, "/page/" + page);
			page = parseInt(page);
			$('#pageno').html(page);
			$('#nextpage').data('page',page+1);
			$('#previouspage').data('page',(page-1) < 1 ? 1 : page-1);
			maxpages = data.lastpage;
		}
	}).error(function(){
		console.log('error');
		$("#followingBallsG").show();
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
