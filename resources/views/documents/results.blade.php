@extends('layouts.app')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<style>
.scroller {
  height:250px;
  overflow-y: scroll;
}
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Identified HPO annotations</div>

                <div class="card-body">
                    <div class="col-md-12 scroller">
                        {!! $new_doc_final !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endsection


<script>



function tooltip_it(elt, hpo){
    var text ="This is my new text element";
    console.log("active");
    $( "#"+elt+"" ).attr( "data-toggle", "popover" );
    $( "#"+elt+"" ).attr( "data-trigger", "hover" );
    $( "#"+elt+"" ).attr( "title", "Header" );
    $( "#"+elt+"" ).attr( "data-content", "Content" );
    $.ajax({
        method: "GET",
        url: "{{ url("/hpo") }}/"+hpo,
         
        })
          .done(function( msg ) {
            console.log(msg);
           // var resultats = JSON.parse(msg);
            identifier = msg[0].identifier;
            term = msg[0].term_name;
            description = msg[0].description;
            console.log("IDENT = "+identifier);
            $( "#"+elt+"" ).attr( "title", ""+identifier+" || "+term+"");
            $( "#"+elt+"" ).attr( "data-content", ""+description+"");
          });

}
</script>
