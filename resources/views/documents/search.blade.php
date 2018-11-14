@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Annotate a fulltext document</div>

                <div class="card-body">
                    <form method="POST" action="{{ url('documents') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="document_identifier" class="col-md-2 col-form-label text-md-right">PMC identifier</label>

                            <div class="col-md-10">
                                <input id="document_identifier" type="text" class="form-control{{ $errors->has('document_identifier') ? ' is-invalid' : '' }}" name="document_identifier" value="{{ old('document_identifier') }}" required autofocus>

                                @if ($errors->has('document_identifier'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('document_identifier') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Annotate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
