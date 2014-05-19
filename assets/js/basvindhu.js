$.get('stats/?json',function(d)
{
	var data = $.parseJSON(d);

	var time, words

	// var margin = {top: 20, right: 20, bottom: 30, left: 50},
	var margin = {top: 0, right: 0, bottom: 0, left: 0},
		width = 620 - margin.left - margin.right,
		height = 20 - margin.top - margin.bottom;

	var parseTime = d3.time.format("%H:%M").parse;

	var x = d3.time.scale().range([0, width]);
	var y = d3.scale.linear().range([height, 0]);
	var xAxis = d3.svg.axis().scale(x).orient("bottom").tickSize(0,0).tickPadding(10).tickFormat(function(d) { return d.getHours() + ":" + ("0" + d.getMinutes()).substr(-2) });
	var yAxis = d3.svg.axis().scale(y).orient("left").tickSize(0,0).tickPadding(10);
	var line = d3.svg.line().x(time).y(words).interpolate("linear");

	var svg = d3.select(".basvindhu").append("svg")
										.attr("width", width + margin.left + margin.right)
										.attr("height", height + margin.top + margin.bottom)
										.append("g")
										.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	// Find range of data for domain
	var min_time = Infinity, max_time = -Infinity;
	var min_words = Infinity, max_words = -Infinity;
	var x;
	$.each(data, function(key, value) {
		temp = parseTime(value.time);
		if( temp < min_time) min_time = temp;
		if( temp > max_time) max_time = temp;
		if( +value.words < min_words) min_words = +value.words;
		if( +value.words > max_words) max_words = +value.words;
	});
	x.domain([min_time, max_time]);
	y.domain([0, max_words]);

	var line = d3.svg.line()
					.x(function(d) { return x(parseTime(d.value.time)); })
					.y(function(d) { return y(d.value.words); });


	svg.selectAll("path").data([d3.entries(data)]).enter().append("path").attr("d", line);

	// svg.append("g")
	// 		.attr("class", "x axis")
	// 		.attr("transform", "translate(0," + height + ")")
	// 		.call(xAxis);

	// svg.append("g")
	// 		.attr("class", "y axis")
	// 		.call(yAxis)
	// 		.append("text")
	// 		.attr("transform", "rotate(-90)")
	// 		.attr("y", 6)
	// 		.attr("dy", ".71em")
	// 		.style("text-anchor", "end");


});