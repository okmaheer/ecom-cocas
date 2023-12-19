<style>
    .btn-edit-modal-Image {
        display: none;
    }

    .main_frame {
        display: grid;
        grid-template-columns: 0.6in 0.6in 0.6in 0.6in 0.6in 0.6in;
        grid-template-rows: 1.0in 2.0in 1.0in;
        column-gap: 0.2in;
        row-gap: 0.2in;
    }

    /* 0.6 +0.2+ 1.4 +0.2+ 1.4 +0.2+ 0.6 */
    .img_box {
        /* display: grid; */
        align-content: center;
        background-color: rgba(255, 255, 255, 1.0);
        /* margin: 10px; */
        font-size: 30px;
        text-align: center;
        box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
    }

    .img_box_01,
    .img_box_06 {
        aspect-ratio: 14 / 10;
        width: 1.4in;
        height: 1.0in;
        grid-column: 2 / span 2;
    }

    .img_box_02,
    .img_box_07 {
        aspect-ratio: 14 / 10;
        width: 1.4in;
        height: 1.0in;
        grid-column: 4 / span 2;
    }

    .img_box_03 {
        aspect-ratio: 14 / 20;
        width: 1.4in;
        height: 2.0in;
        grid-column: 1 / span 2;
    }

    .img_box_04 {
        aspect-ratio: 14 / 20;
        width: 1.4in;
        height: 2.0in;
        grid-column: 3 / span 2;
    }

    .img_box_05 {
        aspect-ratio: 14 / 20;
        width: 1.4in;
        height: 2.0in;
        grid-column: 5 / span 2;
    }


    .img_box img {
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
    <div class="img_box img_box_06 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="06"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_06" class="img-fluid"></a>
    </div>
    <div class="img_box img_box_07 border">
        <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="07"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_07" class="img-fluid"></a>
    </div>



    <input type="hidden" name="canvasSize" id="canvasSize" value="0">
    <input type="hidden" name="cropID" id="cropID" value="">
    <input type="file" name="image" class="image" id="upload_image" style="display:none" accept="image/jpeg, image/png" />
</div>