/**
 *
 * @author Ibrahim Naeem <mbting.9m@gmail.com>
 *
**/

var api = null;

var maxpages = 0;

$(document).ready(function(){
	words();
	// todo
	// History.Adapter.bind(window,'statechange',function(){ 
	// 	var State = History.getState(); 
	// });
});

$('#wordsearchterm').keyup(function(){
	if ($(this).val().length > 2) {
		delay(function(){search();}, 500 );
	} else {
		words($('#pageno').text());
		$("#followingBallsG").hide();
	}
});

$('#wordstable nav a').click(function(){ return false; });

$('.tablenav').click(function(){
	if ($(this).data('page') <= maxpages) {
		words($(this).data('page'));
	}
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
						+ '<td class="column fifth">'+row.eng+'</td>'
						+ '<td class="dv column third">'+row.dhi+'</td>'
						+ '<td class="column third">'+row.latin+'</td>'
						+ '<td class="column tenth">'
							+ '<a href="#" data-id="'+row.id+'">Approve</a>'
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
			console.log(maxpages);
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
