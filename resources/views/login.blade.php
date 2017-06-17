@extends('base')
@section('content')

<div style="text-align: center"><h2>Login here</h2></div>
<div class="row">
    <form class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="password" type="password" class="validate">
          <label for="password">Password</label>
        </div>
      </div>
      <button onclick="auth()" class="btn waves-effect waves-light">Submit
    	<i class="material-icons right">send</i>
  	  </button>
    </form>
 </div>

@endsection
	
@section('scripts')

<script>
	function auth(){
	email = $('#email').val();
	password = $('#password').val();
	console.log(email);
	var route = "/auth";
	var method = "POST";

	var request = $.ajax({
		url : API_BASE_URL+route,
		method : method,
		data : {
			"user_email" : email,
			"user_pass" : password,
		},
		xhrFields : {
			withCredentials : true
		}
	});
	request.done(function(data){
		if(data.status_code == 200)	{
			window.location = API_BASE_URL+"/data";
		}
		else	{
			alert('Please check your email or password');
		}
	});
}


</script>

@endsection