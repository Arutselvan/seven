@extends('base')
@section('content')

<div style="text-align: center"><h2>Register here</h2></div>
<div class="row">
    <form class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <input id="name" type="text" class="validate">
          <label for="name">Name</label>
        </div>
      </div>
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
      <button onclick="register()" class="btn waves-effect waves-light">Submit
    	<i class="material-icons right">send</i>
  	  </button>
    </form>
 </div>

@endsection

@section('scripts')

<script>
	function register(){
	name = $('#name').val();
	email = $('#email').val();
	password = $('#password').val();
	var route = "/register";
	var method = "POST";

	var request = $.ajax({
		url : API_BASE_URL+route,
		method : method,
		data : {
			"user_name": name,
			"user_email" : email,
			"user_pass" : password,
		},
		xhrFields : {
			withCredentials : true
		}
	});
	request.done(function(data){
		if(data.status_code == 200)	{
			window.location = API_BASE_URL+"/login";
		}
		else	{
			console.log(data.message);
		}
	});
}


</script>

@endsection