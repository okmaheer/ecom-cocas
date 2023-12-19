@php
$materials = get_material_list();
@endphp
@if (!empty($materials))
<div class="productDirection dropdown-swatches-wrapper attribute-swatches-wrapper" data-type="dropdown">
    <div class="attribute-name">Material</div>
    <div class="attribute-values productMaterials">
        <div class="dropdown-swatch">
            <label> 
            <select type="text" class="form-control attr_select" id="product_image_material">
            	<option value="">Select Material</option>
            	@foreach($materials as $material)
                	<option value="{{ $material->name }}" data-price="{{ $material->price }}">{{ $material->name }}</option>              
                @endforeach
            </select> 
            <div class="error_div" id="product_image_materialErrorMsg"></div>
            </label>
        </div>
    </div> 
</div>

<script>
$(document).ready(function(){
	$('#product_image_material').change(function(){
		var materialData = $(this).find('option:selected').val();
		
		$('#product_image_materialErrorMsg').html('').slideUp();
		$('#product_image_material').removeClass('errorBox');
		
		@if( in_array('Wall Mural',$categoryArray))
			$('#material_wall_mural').val(materialData);
			updateWallMuralPrice();
		@else
			$('#material').val(materialData);
			updatePrice();
		@endif
		
    });
});
</script>
@endif