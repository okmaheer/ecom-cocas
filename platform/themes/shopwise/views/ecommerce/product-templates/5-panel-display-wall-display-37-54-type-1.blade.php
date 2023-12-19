<style>
    .btn-edit-modal-Image {
        display: none;
    }

    .main_frame {
        display: grid;
        grid-template-columns: 1.3in 1.1in 1.1in 1.3in;
        column-gap: 0.2in;
        row-gap: 0.2in;
    }

    .img_box {
        /* display: grid; */
        align-content: center;
        background-color: rgba(255, 255, 255, 1.0);
        /* margin: 10px; */
        font-size: 30px;
        text-align: center;
        box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
    }

    .img_box_01 {
        aspect-ratio: 54 / 15;
        width: 5.4in;
        height: 1.5in;
        grid-column: auto / span 4;
    }

    .img_box_02,
    .img_box_05 {
        aspect-ratio: 13 / 20;
        width: 1.3in;
        height: 2.0in;
    }

    .img_box_03,
    .img_box_04 {
        aspect-ratio: 11 / 16;
        width: 1.1in;
        height: 1.6in;
    }

    .img_box_01 img {
        width: 100%;
        height: 100%;
    }

    /* .img_box_01 img,
    .img_box_02 img,
    .img_box_04 img,
    .img_box_05 img {
        width: 100%;
        height: 100%;
    } */
</style>

<div class="main_frame" id="main_frame">

    <div class="img_box img_box_01 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="01"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_01" class="img-fluid"></a>
    </div>
    <div class="img_box img_box_02 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="02"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_02" class="img-fluid"></a>
    </div>

    <div class="img_box img_box_03 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="03"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_03" class="img-fluid"></a>
    </div>

    <div class="img_box img_box_04 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="04"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_04" class="img-fluid"></a>
    </div>
    <div class="img_box img_box_05 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="05"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_05" class="img-fluid"></a>
    </div>



    <input type="hidden" name="canvasSize" id="canvasSize" value="0">
    <input type="hidden" name="cropID" id="cropID" value="">
    <input type="file" name="image" class="image" id="upload_image" style="display:none" accept="image/jpeg, image/png" />
</div>