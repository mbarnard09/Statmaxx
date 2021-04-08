window.onload = function() {
    
	chart(window.query);
}
var doit;
function resizedw(){
        document.getElementById("chart").innerHTML = "<div class='lds-ellipsis' id='loader'><div></div><div></div><div></div><div></div></div></div>";
    chart(window.query)}
window.onresize = function() {
        document.getElementById("chart").innerHTML = "<div class='lds-ellipsis' id='loader'><div></div><div></div><div></div><div></div></div></div>";
    clearTimeout(doit);
    doit = setTimeout(function() {
        resizedw();
    }, 1000);
};


function chart(s) {

    var xmlhttp = new XMLHttpRequest;
	document.getElementById("chart").innerHTML = "<div class='lds-ellipsis' id='loader'><div></div><div></div><div></div><div></div></div></div>";
    document.getElementById("loader").style.display = "inline-block";
    var x = document.getElementById("selectTime").selectedIndex;
    var str = document.getElementsByTagName("option")[x].value;
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
	document.getElementById("chart").innerHTML = "";	
	var data = JSON.parse(this.responseText);
          var width = document.getElementById("chart").offsetWidth;
        var height = document.getElementsByTagName("figure")[0].offsetHeight;
        console.log("h:" + height);
        var parseTime = d3.timeParse("%Y-%m-%d %H:%M:%S");

        var x = d3.scaleTime().range([0, width*0.9]);
        var y = d3.scaleLinear().range([height*0.78, 0]);

        var bisect = d3.bisector(function(d) { return d["d"]; }).left;


        var valueline = d3.line()
        .curve(d3.curveMonotoneX)
        .x(function(d) { return x(d["d"]); })
        .y(function(d) { return y(d["m"]); });

        var positiveLine = d3.line()
        .curve(d3.curveMonotoneX)
        .x(function(d) { return x(d["d"]); })
        .y(function(d) { return y(d["p"]); });

        var negativeLine = d3.line()
        .curve(d3.curveMonotoneX)
        .x(function(d) { return x(d["d"]); })
        .y(function(d) { return y(d["n"]); });

        var neutralLine = d3.line()
        .curve(d3.curveMonotoneX)
        .x(function(d) { return x(d["d"]); })
        .y(function(d) { return y(d["nu"]); });

        var svg = d3.select("#chart").append("svg")
        .attr("width", width)
        .attr("height", height*0.91)
        .append("g")
        .attr("transform", "translate(" + 38 + "," + 20 + ")");        

        var focus = svg
        .append('g')
        .append('circle')
        .style("fill", "black")
        .attr("stroke", "black")
        .attr('r', 2.5)
        .style("opacity", 0);

        var focusPos = svg
        .append("g")
        .append("circle")
        .style("fill", "black")
        .attr("stroke", "black")
        .attr("r", 2.5)
        .style("opacity", 0);

        var focusNeg = svg
        .append("g")
        .append("circle")
        .style("fill", "black")
        .attr("stroke", "black")
        .attr("r", 2.5)
        .style("opacity", 0);

        var focusNu = svg
        .append("g")
        .append("circle")
        .style("fill", "black")
        .attr("stroke", "black")
        .attr("r", 2.5)
        .style("opacity", 0);

        var focusLine = svg
        .append("g")
        .append("line")
        .attr("x1",0)
        .attr("y1",0)
        .attr("x2",0)
        .attr("y2",height*0.8)
        .style("opacity",0)
        .style("stroke","black");
    
 
        data.forEach(function(d) {
            d["d"] = parseTime(d["d"]);
            d["m"] = parseInt(d["m"]);
        
        });

        x.domain(d3.extent(data, function(d) { return d["d"]; }));
        y.domain([0, d3.max(data, function(d) { return d["m"]; })]);
        console.log(d3.max(data, function(d) { return d["m"]}));
        console.log(data)
                                
        svg.append("path")
        .data([data])
        .attr("class", "line")
        .attr("d", valueline);

        svg.append("path")
        .data([data])
        .attr("class", "linePos")
        .attr("d", positiveLine);

        svg.append("path")
        .data([data])
        .attr("class", "lineNeg")
        .attr("d", negativeLine);

        svg.append("path")
        .data([data])
        .attr("class", "lineNu")
        .attr("d", neutralLine);
                 
        svg.append("g")
        .attr("transform", "translate(0," + height*0.78 + ")")
        .call(d3.axisBottom(x));
                                
        svg.append("g")
        .call(d3.axisLeft(y).tickFormat(d3.format("~s")));


        svg
        .append('rect')
        .style("fill", "none")
        .style("pointer-events", "all")
        .attr('width', width)
        .attr('height', height)
        .on('mouseover', mouseover)
        .on('mousemove', mousemove)
        .on('mouseout', mouseout);


        function mouseover() {
                focus
                .style("opacity", 1);

                focusLine
                .style("opacity",1);

                focusPos
                .style("opacity", 1);

                focusNeg
                .style("opacity", 1);

                focusNu
                .style("opacity", 1);
    
          }

        function mousemove() {
                var x0 = x.invert(d3.mouse(this)[0]);
                var i = bisect(data, x0, 1);
         
                selectedData = data[i]

                focus
                .attr("cx", x(selectedData["d"]))
                .attr("cy", y(selectedData["m"]));

                focusPos
                .attr("cx", x(selectedData["d"]))
                .attr("cy", y(selectedData["p"]));

                focusNeg
                .attr("cx", x(selectedData["d"]))
                .attr("cy", y(selectedData["n"]));

                focusNu
                .attr("cx", x(selectedData["d"]))
                .attr("cy", y(selectedData["nu"]));

                focusLine
                .attr("x1",x(selectedData["d"]))
                .attr("x2", x(selectedData["d"]));

                document.getElementById("mentions").innerHTML = "Mentions: " + selectedData["m"];

                document.getElementById("positive").innerHTML = "Positive: " + selectedData["p"] + " (" + (Math.floor((selectedData["p"]/selectedData["m"])*100)) +"%)";

                document.getElementById("negative").innerHTML = "Negative: " + selectedData["n"]+ " (" + (Math.floor((selectedData["n"]/selectedData["m"])*100)) +"%)";

                document.getElementById("neutral").innerHTML = "Neutral: " +selectedData["nu"]+ " (" + (Math.floor((selectedData["nu"]/selectedData["m"])*100)) +"%)";

           }


        function mouseout() {
                focus
                .style("opacity", 0);

                focusLine
                .style("opacity", 0);

                focusPos
                .style("opacity", 0);

                focusNeg
                .style("opacity", 0);

                focusNu
                .style("opacity", 0);
          
                document.getElementById("mentions").innerHTML = "Mentions: 0";
                document.getElementById("positive").innerHTML = "Positive: 0";
                document.getElementById("negative").innerHTML = "Negative: 0";
                document.getElementById("neutral").innerHTML = "Neutral: 0";
        }            
                               

            
        }
    }; 
    xmlhttp.open("GET","getstockchart.php?q="+str+"&s="+s, true);
    xmlhttp.send();
}
function getinfo(str) {
	
	
	
  	var xmlhttp = new XMLHttpRequest;
    
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            
            var data = JSON.parse(this.responseText);
		console.log(data);
	    document.getElementById("dayMarket").innerHTML = "% of Market Share: " + Math.ceil((data["day"]["total"]/data["totalsDay"])*100) + "%";

           document.getElementById("weekMarket").innerHTML = "% of Market Share: " + Math.ceil((data["week"]["total"]/data["totalsWeek"])*100) + "%";

			document.getElementById("monthMarket").innerHTML = "% of Market Share: " + Math.ceil((data["month"]["total"]/data["totalsMonth"])*100) + "%"
		
		
		;
            document.getElementById("dayTotal").innerHTML = "Total: " + data["day"]["total"];
            document.getElementById("dayPos").innerHTML = "Positive: " + Math.floor(data["day"]["positive"]/data["day"]["total"] *100) + "% (" + data["day"]["positive"] + ")";
            document.getElementById("dayNeg").innerHTML = "Negative: " + Math.floor(data["day"]["negative"]/data["day"]["total"] *100) + "% (" + data["day"]["negative"] + ")";
            document.getElementById("dayNu").innerHTML = "Neutral: " + Math.floor(data["day"]["neutral"]/data["day"]["total"] *100) + "% (" + data["day"]["neutral"] + ")";

            document.getElementById("weekTotal").innerHTML = "Total: " + data["week"]["total"];
            document.getElementById("weekPos").innerHTML = "Positive: " + Math.floor(data["week"]["positive"]/data["week"]["total"] *100) + "% (" + data["week"]["positive"] + ")";
            document.getElementById("weekNeg").innerHTML = "Negative: " + Math.floor(data["week"]["negative"]/data["week"]["total"] *100) + "% (" + data["week"]["negative"] + ")";
            document.getElementById("weekNu").innerHTML = "Neutral: " + Math.floor(data["week"]["neutral"]/data["week"]["total"] *100) + "% (" + data["week"]["neutral"] + ")";

            document.getElementById("monthTotal").innerHTML = "Total: " + data["month"]["total"];
            document.getElementById("monthPos").innerHTML = "Positive: " + Math.floor(data["month"]["positive"]/data["month"]["total"] *100) + "% (" + data["month"]["positive"] + ")";
            document.getElementById("monthNeg").innerHTML = "Negative: " + Math.floor(data["month"]["negative"]/data["month"]["total"] *100) + "% (" + data["month"]["negative"] + ")";
            document.getElementById("monthNu").innerHTML = "Neutral: " + Math.floor(data["month"]["neutral"]/data["month"]["total"] *100) + "% (" + data["month"]["neutral"] + ")";
        }
    };
    xmlhttp.open("GET","getinfo.php?q="+str, true);
	xmlhttp.setRequestHeader("Cache-Control", "no-store");
    xmlhttp.send();
}


