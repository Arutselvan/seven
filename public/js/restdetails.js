$('#details').hide();

$('#viewbutton').hide();
function restaurant(id,dist,dur){
	console.log(id);
	$('#restcards').hide();
	$('#loader').show();
	var route = "/senti";
	var method = "POST";
	console.log("lol");

	var request = $.ajax({
		url : API_BASE_URL+route,
		method : method,
		data : {
			"res_id" : id,
			"dist": dist,
			"dur" : dur,
		},
		xhrFields : {
			withCredentials : true
		}
	});

	request.done(function(data){
		if(data.status_code == 200)	{
			$('#name').html(data.message.name);
			$('#address').html(data.message.address);
			string = '<iframe src="https://google.com/maps/embed/v1/place?q='+escape(data.message.address)+'&zoom=17&key=AIzaSyDdI0zok8HSFqCX2iUFK8F6BPa2pNrLTSA"></iframe>';
			$('#map').html(string);
			$('#dur').html(data.message.duration+" mins");
			$('#dist').html(data.message.distance+" Km");
			$('#cuisines').html(data.message.cuisines);
			$('#keywords').html(makeUL(data.message.keywords));
			$('#ss').html(data.message.score);
			$('#joy').html(data.message.emotion.joy);
			$('#sadness').html(data.message.emotion.sadness);
			$('#fear').html(data.message.emotion.fear);
			$('#anger').html(data.message.emotion.anger);
			$('#disgust').html(data.message.emotion.disgust);
			$('#viewbutton').show();
			$('#loader').hide();
			$('#details').show();	
		}
		else	{
			console.log(data.message);
		}
	});
}

var lat;
var lon;

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        alert("Geolocation is not supported by this browser.");
    }
}


function showPosition(position) {
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    cards(lat,lon);
}

function cards(lat,lon){
	$('#details').hide();
	$('#loader').show();
	getLocation();
	var route = "/geo";
	var method = "POST";
	getLocation();
	var request = $.ajax({
		url : API_BASE_URL+route,
		method : method,
		data : {
			"lat": lat,
			"lon" : lon,
		},
		xhrFields : {
			withCredentials : true
		}
	});

	request.done(function(data){
		if(data.status_code == 200)	{
			$('#loader').hide();
			$('#restcards').html(makeCards(data.message));
			$('#viewbutton').hide();
			$('#restcards').show();	
		}
		else	{
			console.log(data.message);
		}
	});
}
//console.log(lat);


$(document).ready(function(){
	getLocation();
	//restaurant();
});

function makeUL(array){
    var a = '<ul>',
        b = '</ul>',
        m = '';

    // Right now, this loop only works with one
    // explicitly specified array (options[0] aka 'set0')
    for (i = 0; i < array.length; i += 1){
        m = m+'<li>' + array[i] + '</li>';
    }

    return (a+m+b)
}

function makeCards(array){
	//console.log(array);
	var a = '<div>';
	var b = '</div>';
	l='';
	for (i = 0; i < array.length; i += 1){
		id = array[i].id;
		dist = array[i].travel.dist.slice(0, -3);
		dur = array[i].travel.duration.slice(0, -5);
		fun = "onclick=restaurant("+id+","+dist+","+dur+")";
		//console.log(fun);
		l =l+'<div class="col s12 m6"><div  '+fun+'  class="card"><div class="card-content"><span class="card-title">'+array[i].name+'</span><p>'+array[i].location.address+'</p></div><div class="card-action"><h5>Distance: '+array[i].travel.dist+'</h5><h5>Duration: '+array[i].travel.duration+'</h5></div></div></div>';
	}
	console.log(l);
	return l;
}

