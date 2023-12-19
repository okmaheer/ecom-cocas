<style>
    .btn-edit-modal-Image {
        display: none;
    }

    .main_frame {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        background-color: #fff;
        padding: 10px;
        align-content: center;
    }

    .img_box {
        aspect-ratio: 2/3;
        display: grid;
        align-content: center;
        background-color: rgba(255, 255, 255, 1.0);
        margin: 3px;
        font-size: 30px;
        text-align: center;
        box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
    }
</style>

<div class="main_frame"  id="main_frame">
    <div class="img_box img_box_01 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="01"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_01"></a>
    </div>
    <div class="img_box img_box_02 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="02"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_02"></a>
    </div>
    <div class="img_box img_box_03 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="03"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_03"></a>
    </div>
    <input type="hidden" name="canvasSize" id="canvasSize" value="0">
    <input type="hidden" name="cropID" id="cropID" value="">
    <input type="file" name="image" class="image" id="upload_image" style="display:none" accept="image/jpeg, image/png" />
</div>