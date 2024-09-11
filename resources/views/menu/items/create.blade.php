@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Item in '. $menu_category->name) }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('menu.category.item.store', [$bar_id, $cat_id]) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="currency" class="col-md-4 col-form-label text-md-right">{{ __('Currency') }}</label>

                            <div class="col-md-6">
                                <input id="currency" type="text" class="form-control @error('currency') is-invalid @enderror" name="currency" value="{{ old('currency') ?? '$' }}" required autocomplete="currency">

                                @error('currency')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" maxlength="80" value="{{ old('description') }}" autocomplete="description">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="modifiers_container" class="form-group row">
                            <label for="mod_cat_ids" class="col-md-4 col-form-label text-md-right">{{ __('Modifier Categories') }}</label>

                            <div class="col-md-6">
                                <select id="mod_cat_ids" class="form-control" name="mod_cat_ids[]"></select>
                            </div>
                        </div>

                        <div id="types_container"></div>

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
                                <button id="btn_add_type" type="button" class="btn btn-success">
                                    {{ __('Add Type') }}
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
    let menu_item_types = {!! json_encode($menu_item_types->toArray()) !!};
    let menu_modifier_categories = {!! json_encode($menu_modifier_categories->toArray()) !!};
    let dynamic_id = 0;

    $(document).ready(function() {

        document.getElementById('btn_add_type').addEventListener('click', addType);

        function addType() {
            dynamic_id++;

            if ( dynamic_id == menu_item_types.length ) {
                document.getElementById('btn_add_type').style.display = 'none';
            }

            let typeHTML = `<div class="form-group row">
                    <label for="price_${dynamic_id}" class="col-md-4 col-form-label text-md-right">{{ __('Price') }}</label>

                    <div class="col-md-3">
                        <input id="price_${dynamic_id}" type="text" class="form-control @error('price_${dynamic_id}') is-invalid @enderror" name="price_${dynamic_id}" value="{{ '34.76' }}" required>

                        @error('price_${dynamic_id}')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <select id="item_type_${dynamic_id}" type="text" class="form-control" name="item_type_${dynamic_id}" required>`;
                            menu_item_types.forEach(type => {
                                typeHTML += `<option value="${type.name}">${type.name}</option>`;
                            });
                        typeHTML += `</select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Modifiers') }}</label>

                    <div class="col-md-6">
                        <input type="radio" id="yes_${dynamic_id}" name="modifiers_${dynamic_id}" value="Yes">
                        <label for="yes_${dynamic_id}">Yes</label>

                        <input class="ml-2" type="radio" id="no_${dynamic_id}" name="modifiers_${dynamic_id}" value="No" checked>
                        <label for="no_${dynamic_id}">No</label>
                    </div>
                </div>`;

            document.getElementById('types_container').insertAdjacentHTML('beforeend', typeHTML);
        }
        
        $("#mod_cat_ids").select2({
            placeholder: "Select a Category",
            multiple: true
        });

        for( var i=0; i<menu_modifier_categories.length; i++ ) {
            var optionText = menu_modifier_categories[i].name;
            var optionValue = menu_modifier_categories[i].id;
            $('#mod_cat_ids').append(new Option(optionText, optionValue));
        }

    });
</script>
@endsection
