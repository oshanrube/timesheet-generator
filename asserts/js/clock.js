var today = new Date();
var expire = new Date();
expire.setTime(today.getTime() + 3600000*24*31);
document.cookie = "time_zone_offset"+"="+escape(today.getTimezoneOffset())
                 + ";expires="+expire.toGMTString();
$(document).ready(function() {
// Create two variable with the names of the months and days in an array
var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]; 
var dayNames= ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]

// Create a newDate() object
var newDate = new Date();
// Extract the current date from Date object
newDate.setDate(newDate.getDate());
// Output the day, date, month and year    
$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

setInterval( function() {
	// Create a newDate() object and extract the seconds of the current time on the visitor's
	var seconds = new Date().getSeconds();
	// Add a leading zero to seconds value
	$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
	if(seconds % 10 == 0){
		//ping the server
		var date = new Date();
		var ts = Math.round(date.getTime() / 1000);
		var jqxhr = $.ajax({
			url: "server.php?action=clock&time="+ts,
			cache: false
			})
    	.done(function() { $("#status").html("Server Live"); })
    	.fail(function() { $("#status").html("Server Offline");});
	}
},1000);
	
setInterval( function() {
	// Create a newDate() object and extract the minutes of the current time on the visitor's
	var minutes = new Date().getMinutes();
	// Add a leading zero to the minutes value
	$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
    },1000);
	
setInterval( function() {
	// Create a newDate() object and extract the hours of the current time on the visitor's
	var hours = new Date().getHours();
	// Add a leading zero to the hours value
	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1000);
	
	$("#toggle_datetime").click(function(response){
		if($(this).text() == 'Start'){
			$.ajax({url: "server.php?action=startTask"+getFormData(),cache: false})
			.done(function() { 
				//update the text
				$(this).text('Stop');
				//update the start time
				$("#from").val(response.response);
			});
		} else {
			$(this).text('Start');
		}
	});	
});