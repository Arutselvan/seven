@extends('base')
@section('content')


<div id="restcards"></div>


<div id="loader" class="preloader-wrapper big active center align">
    <div class="spinner-layer spinner-blue-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
</div>


<div id="details">
<h1 id="name"></h1>
<div class="col s12 m7">
    <h2 id="name" class="header"></h2>
    <div class="card horizontal">
      <div class="card-stacked">
        <div class="card-action">
          <h5><b>Address</b></h5>
          <div id="map"></div>
        </div>
        <div class="card-content">
          <p id="address"></p>
        </div>
      </div>
    </div>
  </div>

<div class="row">
        <div  class="col s12 l4">
          <div class="card">
            <div id="kow" class="card-content">
              <h3 id="dist"></h3>
              <img style="height: 150px;margin:auto;" src="{{asset('images/car.svg')}}">
            </div>
            <div class="card-action">
              <h5>Distance</h5>
            </div>
          </div>
        </div>
        <div  class="col s12 l4">
          <div class="card">
            <div id="kow" class="card-content">
              <h3 id="dur"></h3>
              <img style="height: 150px;margin:auto;" src="{{asset('images/clock.svg')}}">
            </div>
            <div class="card-action">
              <h5>Travel Duration</h5>
            </div>
          </div>
        </div>
        <div  class="col s12 l4">
          <div class="card">
            <div id="kow" class="card-content">
              <h5 id="cuisines"></h5>
              <img style="height: 150px;margin:auto;" src="{{asset('images/dish.svg')}}">
            </div>
            <div class="card-action">
              <h5>Cuisines</h5>
            </div>
          </div>
        </div>
</div>

<div class="row">
        <div class="col s12 l4">
          <div class="card">
            <div id="kow" class="card-content">
              <div id="keywords"></div>
            </div>
            <div class="card-action">
              <h5>Top 10 Significant words</h5>
            </div>
          </div>
        </div>
        <div class="col s12 l4">
          <div class="card">
            <div id="kow" class="card-content">
                <h3 id="ss"></h3>
                <img style="height: 150px;margin:auto;" src="{{asset('images/pressure.svg')}}">
            </div>
            <div class="card-action">
              <h5>Sentiment Score</h5>
            </div>
          </div>
        </div>
        <div class="col s12 l4">
          <div class="card">
            <div id="kow" class="card-content">
              <div class="row">
                <div class="col s4"><img style="height:30px;" src="{{asset('images/happy.svg')}}"></div>
                <div class="col s4"><h6>Joy</h6></div>
                <div id="joy" class="col s4"></div>
              </div>
              <div class="row">
                <div class="col s4"><img style="height:30px;" src="{{asset('images/vain.svg')}}"></div>
                <div class="col s4"><h6>Sadness</h6></div>
                <div id="sadness" class="col s4"></div>
              </div>
              <div class="row">
                <div class="col s4"><img style="height:30px;" src="{{asset('images/emoticons.svg')}}"></div>
                <div class="col s4"><h6>Disgust</h6></div>
                <div id="disgust" class="col s4"></div>
              </div>
              <div class="row">
                <div class="col s4"><img style="height:30px;" src="{{asset('images/angry.svg')}}"></div>
                <div class="col s4"><h6>Anger</h6></div>
                <div id="anger" class="col s4"></div>
              </div>
              <div class="row">
                <div class="col s4"><img style="height:30px;" src="{{asset('images/scare.svg')}}"></div>
                <div class="col s4"><h6>Fear</h6></div>
                <div id="fear" class="col s4"></div>
              </div>
            </div>
            <div class="card-action">
              <h5>Emotions</h5>
            </div>
          </div>
        </div>
</div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        console.log("lol");
    </script>
    <script type="text/javascript" src="{{asset('js/restdetails.js')}}"></script>
@endsection