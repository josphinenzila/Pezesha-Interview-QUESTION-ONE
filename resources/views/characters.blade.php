@extends('layouts.header')

@section('content')
<div id="content">
  <div class="container">
        <div class="pt-5 pb-3">
            <h3>Marvel Characters</h3>
        </div>
        <div class="row">
          @foreach($paginated_results as $char)
            <div class="col-md-3 pb-5">
                <div class="card" style="width: 15rem;">
                  <img src="{{ $char['thumbnail']['path'] }}/portrait_incredible.jpg" alt="{{ $char['name'] }} thumbnail">
                  <div class="card-body">
                    <h5 class="card-title">{{ $char['name'] }}</h5>
                  </div>
                </div>
            </div>
            @endforeach
        </div>
    <div class="pagination"> 
      {{ $paginated_results->appends(Request::all())->links() }}
    </div>
  </div>
</div>
@endsection