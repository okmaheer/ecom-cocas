<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.css" />
<div class="wallMural dropdown-swatches-wrapper attribute-swatches-wrapper" data-type="dropdown" style="display:none;">
  <div class="attribute-name">Image Position {{$category_name}}</div>
  <div class="attribute-values">
    <div class="dropdown-swatch">
      <label>
        <input type="text" class="form-control attr_select" id="image_position_inpt" data-id="image_position" style="height:auto; width: 300px;" />
      </label>
    </div>
  </div>
</div>
<div class="wallMural dropdown-swatches-wrapper attribute-swatches-wrapper" data-type="dropdown">
  <div class="attribute-name">Width For Wall Mural</div>
  <div class="attribute-values">
    <div class="dropdown-swatch">
      <label>
      <input type="number" class="form-control attr_select" id="width_wall_mural_inpt" data-id="width_wall_mural"  style="height:auto; width: 300px;"/>
      <div class="error_div" id="width_wall_mural_inptErrorMsg"></div>
      </label>
    </div>
  </div>
</div>
<div class="wallMural dropdown-swatches-wrapper attribute-swatches-wrapper" data-type="dropdown">
  <div class="attribute-name">Height For Wall Mural</div>
  <div class="attribute-values">
    <div class="dropdown-swatch">
      <label>
      <input type="number" class="form-control attr_select" id="height_wall_mural_inpt"data-id="height_wall_mural"  style="height:auto; width: 300px;"/>
      <div class="error_div" id="height_wall_mural_inptErrorMsg"></div>
      </label>
    </div>
  </div>
</div>
<br/>
<div class="wallMural dropdown-swatches-wrapper attribute-swatches-wrapper" data-type="dropdown">
  <div class="attribute-values">
    <div class="dropdown-swatch">
      <label><input type="checkbox" id="show-tiles" class="checkbox product-custom-option"> Show how the tiles will be supplied</label>
    </div>
  </div>
</div>
<br/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.js"></script>
<link media="all" type="text/css" rel="stylesheet" href="{{url('/themes/shopwise/css/tiles.css')}}">
<script>
 var cropper;
function updateCropper(){

	if (cropper) {
		cropper.destroy();
	}
    var image = document.querySelector('#product_img')
  var mWidth = $( "#width_wall_mural_inpt" ).val();
  var mHeight = $( "#height_wall_mural_inpt" ).val();
  var initialAspectRatio = mWidth / mHeight;
// cropperjs image greyscale

  cropper = new Cropper(image, {
	viewMode: 3,
	aspectRatio: initialAspectRatio,
	dragMode: 'move',
	autoCropArea: 1,
	restore: false,
	modal: true,
	guides: false,
	highlight: true,
	cropBoxMovable: true,
	cropBoxResizable: false,
	toggleDragModeOnDblclick: false,
	autoCrop: true,

  });
	  if(mWidth > 99 && mHeight > 99){

	  setTimeout(function(){
		  var totalWidth = $('.cropper-crop-box').width();
		  var parts = parseInt(mWidth)/50;

		  var tileHTML = '<div class="Tiles" style="display:none"><ul>';
		  	var leftWidth = 0;
			var count = 1;
			var contentClass = 'Tiles__content';
			var Tiles__measurement = 'Tiles__measurement';
			if(parts > 10){
				contentClass = 'Tiles__vertical-content';
				Tiles__measurement = '';
			}
			for(i = 1; i<= parts; i++){
				var divWidth = parseInt(totalWidth)/parts;
				tileHTML = tileHTML+'<li style="left: '+leftWidth+'px;width: '+divWidth+'px;"><div class="'+contentClass+'"><div style="margin: 20px 5px;color: #FFF;">'+i+'</div><div class="'+Tiles__measurement+'"><span><small>50&nbsp;cm</small></span></div></div></li>';
				leftWidth = parseInt(leftWidth)+parseInt(divWidth);
				count++;
			}

			var reminingPart = parseInt(parts)*50;
			if(mWidth > reminingPart){
				var lastBox = parseInt(mWidth)-parseInt(reminingPart);
				var divWidth = parseInt(totalWidth)-parseInt(leftWidth);
				tileHTML = tileHTML+'<li style="left: '+leftWidth+'px;width: '+divWidth+'px;"><div class="'+contentClass+'"><div style="margin: 20px 5px;color: #FFF;">'+count+'</div><div class="'+Tiles__measurement+'"><span><small>'+lastBox+'&nbsp;cm</small></span></div></div></li>';
			}

		tileHTML = tileHTML+'</ul></div>';

	  	$(tileHTML).insertAfter('.cropper-view-box');

		if($('#show-tiles').prop('checked') == true){
			$('.Tiles').show();
		}

	  },300);
	  }
}

function getCropImage(){
	if (cropper) {
		canvas = cropper.getCroppedCanvas({
			// width: 800,
			// height: 800
			minWidth: 256,
			minHeight: 256,
			maxWidth: 4096,
			maxHeight: 4096,
		});
		canvas.toBlob(function(blob) {
			url = URL.createObjectURL(blob);
			var reader = new FileReader();
			reader.readAsDataURL(blob);

			reader.onloadend = function() {
				var base64data = reader.result;
				// $("#customCropImage").val(btoa(getCropImage));
                $("#customCropImage").val(base64data);

				// return base64data;
			}
		});

	}
	return true;

}
function getPreviewImage(){

    if (cropper) {
        if($('#wallpaper-selector-preview-crop').prop('checked') == true){
            let src = cropper.getCroppedCanvas().toDataURL("image/png");
            cropper.destroy();
            return src;
        }else{
            let src = $('.slick-track:last-child .slick-slide:last-child a').attr('data-image');
            cropper.destroy();
            return src;
        }
        }




	return true;

}

</script>
