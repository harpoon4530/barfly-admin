@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Promotion') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ action('PromotionController@store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bar_id" class="col-md-4 col-form-label text-md-right">{{ __('Bar') }}</label>

                            <div class="col-md-6">
                                <select id="bar_id" class="form-control" name="bar_id" required>
                                    <option></option>
                                </select>

                                @error('bar_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="@error('image') is-invalid @enderror" name="image" accept="image/*" required>

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        let bars = {!! json_encode($bars->toArray()) !!};

        $("#bar_id").select2({
            placeholder: "Select a Bar"
        });

        for( var i=0; i<bars.length; i++ ) {
            var optionText = bars[i].name;
            var optionValue = bars[i].id;
            $('#bar_id').append(new Option(optionText, optionValue));
        }
    });
</script>
@endsection