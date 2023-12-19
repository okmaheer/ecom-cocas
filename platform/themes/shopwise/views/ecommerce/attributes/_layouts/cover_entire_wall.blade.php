@php
$materials = get_material_list();
@endphp
@if (!empty($materials))
<style>
    .custom-button {
        display: inline-block;
        position: relative;
        margin: 10px;
    }

    .custom-button input[type="checkbox"] {
        position: absolute;
        left: -9999px;
    }

    .custom-button label {
        display: inline-block;
        padding: 10px 20px;
        background-color: #ccc;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        text-transform: uppercase;
        transition: background-color 0.3s ease;
    }

    .custom-button label:hover {
        background-color: #555;
    }

    .custom-button input[type="checkbox"]:checked + label {
        background-color: #333;
    }
</style>
<div class="productDirection dropdown-swatches-wrapper attribute-swatches-wrapper" data-type="dropdown">
    <div class="attribute-name">WILL YOUR MURAL COVER THE ENTIRE WALL(if yes than Mural Wall will be extended
        {{setting('cover_entire_wall')}}" extra)</div>
    <div class="attribute-values productMaterials">
        <div class="dropdown-swatch">
            <label>
                <label> <select type="text" class="form-control attr_select" id="image_cover_entire_wall"
                        data-id="image_cover_entire_wall">
                        <option value="Yes">Yes</option>
                        <option value="No" selected>No</option>
                    </select> </label>
            </label>
        </div>
    </div>
    <div class="attribute-values pictureMode">
        <div class="attribute-name">Color Effect</div>

        <div class="dropdown-swatch">
            <label>
                <label>
                    <select name="color" id="coloreffect" onchange="colorEffect()" class="form-control attr_select">
                        <option selected="" data-color-type="color" value="color" label="Full colour">
                            Full colour
                        </option>
                        <option data-color-type="color" value="blackwhite" label="Black &amp; White">
                            Black &amp; White
                        </option>
                        <option data-color-type="color" value="grayscale" label="Grayscale">
                            Grayscale
                        </option>
                        <option data-color-type="filter" value="invert" label="Invert">
                            Invert
                        </option>
                        <option data-color-type="filter" value="pixelate" label="Piexelate">
                            Pixelate
                        </option>
                        <option data-color-type="color" value="sepia" label="Sepia">
                            Sepia
                        </option>
                    </select>
                </label>
            </label>
        </div>
    </div>
    <div class="custom-button">
        <input type="checkbox" id="wallpaper-landscape" class="checkbox product-custom-option custom-checkbox" onchange="imageLandscape()">
        <label for="wallpaper-landscape" class="custom-label">
            Landscape
        </label>
    </div>
    <div class="custom-button">
        <input type="checkbox" id="wallpaper-selector-preview-crop" class="checkbox product-custom-option custom-checkbox"
            onchange="previewCrop()">
        <label for="wallpaper-selector-preview-crop">
            Preview Crop
        </label>
    </div>
</div>
<script>
    $(document).ready(function(){

	$('#image_cover_entire_wall').change(function(){
		var coverEntireWall = $(this).find('option:selected').val();
		$('#cover_entire_wall').val(coverEntireWall);
		updateWallMuralPrice();
	});


});

function imageLandscape(){
    let width = $('#width_wall_mural_inpt').val();
    let height = $('#height_wall_mural_inpt').val();
    if(width > 99 && height > 99){
        let sub = width;
        $('#width_wall_mural_inpt').val(height);
        $('#height_wall_mural_inpt').val(sub);
        updateCropper();
    }
}
function colorEffect(){
    let color = $('#coloreffect').val();
    console.log(color)
    $('.product-image').css('filter','none');
    if(color == "grayscale"){
    $('.product-image').css('filter','grayscale(100%)');
    }
    else if(color == "invert"){
    $('.product-image').css('filter','invert(100%)');
    }
    else if(color == "sepia"){
    $('.product-image').css('filter','sepia(100%)');
    }
    else if(color == "blackwhite"){
    $('.product-image').css('filter','grayscale(100%)');
    }
    else if(color == "pixelate"){
    $('.product-image').css('image-rendering','pixelated');
    }

    $('#color_effect').val(color);
    updateCropper();
}
</script>
@endif
