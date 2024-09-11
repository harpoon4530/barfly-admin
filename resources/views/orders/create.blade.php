@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create an Order') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ action('OrderController@store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="bar_id" class="col-md-4 col-form-label text-md-right">{{ __('Bar') }}</label>

                            <div class="col-md-6">
                                <select id="bar_id" class="form-control" name="bar_id" required>
                                </select>

                                @error('bar_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div id="main_container"></div>

                        <input id="dynamic_count" type="number" class="form-control" name="dynamic_count" hidden>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                                <button id="btn_add_more" type="button" class="btn btn-success">
                                    {{ __('Add More') }}
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
    var bars = {!! json_encode($bars->toArray()) !!};
    var selectedBarIndex = 0;
    var menuModifiers = null;
    var dynamicNumber = 0;

    $(document).ready(function() {

        $('#bar_id').select2({
            placeholder: "Select a Bar"
        });

        $('#bar_id').append(new Option());

        for( var i=0; i<bars.length; i++ ) {
            var optionText = bars[i].name;
            var optionValue = bars[i].id;
            $('#bar_id').append(new Option(optionText, optionValue));
        }

        document.getElementById('btn_add_more').addEventListener('click', addMore);

        function addMore() {
            dynamicNumber++;

            $('#dynamic_count').val(dynamicNumber);

            var sectionHTML = `<div class="form-group row">
                                        <h5 class="col-md-4 text-md-right">{{ __('Select drink ${dynamicNumber}:') }}</h5>
                                    </div>
                            <div class="form-group row">
                                <label for="cat_${dynamicNumber}" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                                <div class="col-md-6">
                                    <select id="cat_${dynamicNumber}" class="form-control" name="cat_${dynamicNumber}" required>
                                    </select>

                                    @error('cat_${dynamicNumber}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="item_${dynamicNumber}" class="col-md-4 col-form-label text-md-right">{{ __('Item') }}</label>

                                <div class="col-md-6">
                                    <select id="item_${dynamicNumber}" class="form-control" name="item_${dynamicNumber}" required>
                                    </select>

                                    @error('item_${dynamicNumber}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="type_${dynamicNumber}" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>

                                <div class="col-md-6">
                                    <select id="type_${dynamicNumber}" class="form-control" name="type_${dynamicNumber}" required>
                                    </select>

                                    @error('type_${dynamicNumber}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity_${dynamicNumber}" class="col-md-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

                                <div class="col-md-6">
                                    <input type="number" id="quantity_${dynamicNumber}" name="quantity_${dynamicNumber}" min="1" max="10" value="1">

                                    @error('quantity_${dynamicNumber}')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div id="modifiers_container_${dynamicNumber}"></div>`;

            document.getElementById('main_container').insertAdjacentHTML('beforeend', sectionHTML);

            addListeners(dynamicNumber);
        }

        function addListeners(dynNum) {
            $('#cat_'+dynNum).select2({
                placeholder: "Select Categories"
            });
            $('#item_'+dynNum).select2({
                placeholder: "Select Items"
            });
            $('#type_'+dynNum).select2({
                placeholder: "Select an Item Type"
            });

            $('#bar_id').change(function() {
                
                selectedBarIndex = $(this)[0].selectedIndex-1;

                var selected_categories = bars[selectedBarIndex].menu_categories;

                for ( var j=0; j<dynamicNumber; j++ ) {
                    document.getElementById('modifiers_container_'+(j+1)).innerHTML = '';

                    $('#cat_'+(j+1)).empty();
                    $('#item_'+(j+1)).empty();
                    $('#type_'+(j+1)).empty();
                    $('#cat_'+(j+1)).append(new Option());
                    $('#item_'+(j+1)).append(new Option());
                    $('#type_'+(j+1)).append(new Option());

                    for( var i=0; i<selected_categories.length; i++ ) {
                        var optionText = selected_categories[i].name;
                        var optionValue = selected_categories[i].id;
                        $('#cat_'+(j+1)).append(new Option(optionText, optionValue));
                    }
                }

                $.get( '{{ env('BASE_URL') }}' + 'bar/'+$(this).children("option:selected").val()+'/menu/get_modifiers', function(data, status) {
                    menuModifiers = data;
                });
            });

            $('#cat_'+dynNum).change(function() {
                document.getElementById('modifiers_container_'+dynNum).innerHTML = '';

                $('#item_'+dynNum).empty();
                $('#type_'+dynNum).empty();
                $('#item_'+dynNum).append(new Option());
                $('#type_'+dynNum).append(new Option());

                var selectedCategories = $(this).val();
                var categories = bars[selectedBarIndex].menu_categories;
                var selected_items = new Array();

                for( var j=0; j<categories.length; j++ ) {
                    for( var i=0; i<selectedCategories.length; i++ ) {
                        if ( categories[j].id == selectedCategories[i] ) {
                            for( var k=0; k<categories[j].items.length; k++ ) {
                                selected_items.push( categories[j].items[k] );
                            }
                        }
                    }
                }

                for( var i=0; i<selected_items.length; i++ ) {
                    var optionText = selected_items[i].name;
                    var optionValue = selected_items[i].id;
                    $('#item_'+dynNum).append(new Option(optionText, optionValue));
                }
            });

            $('#item_'+dynNum).change(function() {
                document.getElementById('modifiers_container_'+dynNum).innerHTML = '';

                $('#type_'+dynNum).empty();
                $('#type_'+dynNum).append(new Option());

                var selectedItem = $(this).val();
                var categories = bars[selectedBarIndex].menu_categories;
                var selected_types = new Array();

                for( var j=0; j<categories.length; j++ ) {
                    var items = categories[j].items;
                    for( var s=0; s<items.length; s++ ) {
                        if ( items[s].id == selectedItem ) {
                            var itemTypes = JSON.parse(items[s].types);
                            for( var k=0; k<itemTypes.length; k++ ) {
                                selected_types.push( itemTypes[k] );
                            }
                        }
                    }
                }

                for( var i=0; i<selected_types.length; i++ ) {
                    var optionText = selected_types[i].type;
                    var optionValue = selected_types[i].id;
                    $('#type_'+dynNum).append(new Option(optionText, optionValue));
                }
            });

            $('#type_'+dynNum).change(function() {
                document.getElementById('modifiers_container_'+dynNum).innerHTML = '';

                var selectedItemTypeIndex = $(this).val();
                var categories = bars[selectedBarIndex].menu_categories;
                var selectedItem = categories[$('#cat_'+dynNum)[0].selectedIndex-1].items[$('#item_'+dynNum)[0].selectedIndex-1];
                var selectedItemType = JSON.parse(selectedItem.types)[selectedItemTypeIndex-1];
                var menuModifiersSelected = [];

                var modifiersHTML = `<div class="form-group row">
                                        <h5 class="col-md-4 text-md-right">{{ __('Modifiers:') }}</h5>
                                    </div>`;

                if ( selectedItemType.modifiers == 'Yes' ) {
                    modifiersHTML += `<div class="form-group row">`;

                    menuModifiers.forEach(modifier => {

                        JSON.parse(selectedItem.modifiers).forEach((element, index) => {

                            if ( element == modifier.id ) {
                                
                                modifiersHTML += `<label for="modifiers_${dynNum}_${index+1}" class="col-md-4 col-form-label text-md-right">{{ __('${modifier.name}') }}</label>
                                    <div class="col-md-6">
                                        <select id="modifiers_${dynNum}_${index+1}" class="form-control" name="modifiers_${dynNum}_${index+1}" required>
                                            <option></option>
                                        </select>

                                        @error('modifiers_${dynNum}_${index+1}')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>`;

                                modifier['selectbox_id'] = `modifiers_${dynNum}_${index+1}`;

                                menuModifiersSelected.push(modifier);
                            }
                        });
                    });

                    modifiersHTML += `</div>
                        <input id="dynamic_modifier_${dynNum}" type="number" class="form-control" name="dynamic_modifier_${dynNum}" value="${JSON.parse(selectedItem.modifiers).length}" hidden>`;

                    document.getElementById('modifiers_container_'+dynNum).insertAdjacentHTML('beforeend', modifiersHTML);

                    for( var i=0; i<menuModifiersSelected.length; i++ ) {

                        $('#'+menuModifiersSelected[i].selectbox_id).select2({
                            placeholder: "Select Items"
                        });

                        for( var j=0; j<menuModifiersSelected[i].items.length; j++ ) {
                            var optionText = menuModifiersSelected[i].items[j].name;
                            var optionValue = menuModifiersSelected[i].items[j].id;
                            $('#'+menuModifiersSelected[i].selectbox_id).append(new Option(optionText, optionValue));
                        }
                    }
                }

            });
        }
      
    });
</script>
@endsection