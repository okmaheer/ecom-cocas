<style>
    .btn-edit-modal-Image {
        display: none;
    }

    .main_frame {
        width: 7.2in;
        height: 4.6in;
        display: grid;
        grid-template-columns: 7.2in;
        grid-template-rows: 2.4in 2.0in;
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

    .upper_frame {
        display: grid;
        grid-template-columns: 1.2in 1.2in 1.6in 1.2in 1.2in;
        aspect-ratio: 72 / 24;
        width: 7.2in;
        height: 2.4in;
        column-gap: 0.2in;
        align-items: end;
    }

    .lower_frame {
        display: grid;
        grid-template-columns: 1.6in 1.2in 1.6in 2.0in;
        aspect-ratio: 72 / 20;
        width: 7.2in;
        height: 2.0in;
        column-gap: 0.2in;
        align-items: start;
        justify-content: end;
    }

    .middle_group {
        display: grid;
        grid-template-columns: 1fr;
        aspect-ratio: 12 / 22;
        width: 1.2in;
        height: 2.2in;
        row-gap: 0.2in;
    }

    .img_box_01 {
        aspect-ratio: 12 / 16;
        width: 1.2in;
        height: 1.6in;
    }

    .img_box_02 {
        aspect-ratio: 12 / 10;
        width: 1.2in;
        height: 1.0in;
    }

    .img_box_03 {
        aspect-ratio: 12 / 10;
        width: 1.2in;
        height: 1.0in;
    }

    .img_box_04 {
        aspect-ratio: 16 / 24;
        width: 1.6in;
        height: 2.4in;
    }

    .img_box_05 {
        aspect-ratio: 12 / 18;
        width: 1.2in;
        height: 1.8in;
    }

    .img_box_06 {
        aspect-ratio: 12 / 12;
        width: 1.2in;
        height: 1.2in;
    }

    .img_box_07 {
        aspect-ratio: 16 / 11;
        width: 1.6in;
        height: 1.1in;
    }

    .img_box_08 {
        aspect-ratio: 12 / 12;
        width: 1.2in;
        height: 1.2in;
    }

    .img_box_09 {
        aspect-ratio: 16 / 20;
        width: 1.6in;
        height: 2.0in;
    }

    .img_box_010 {
        aspect-ratio: 20 / 16;
        width: 2.0in;
        height: 1.6in;
    }



    .img_box img {
        width: 100%;
        height: 100%;
    }
</style>

<div class="main_frame" id="main_frame">

    <div class="upper_frame">
        <div class="img_box img_box_01 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="01"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_01" class="img-fluid"></a>
        </div>

        <div class="middle_group">
            <div class="img_box img_box_02 border">
                <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="02"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_02" class="img-fluid"></a>
            </div>
            <div class="img_box img_box_03 border">
                <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="03"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_03" class="img-fluid"></a>
            </div>
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
    </div>


    <div class="lower_frame">
        <div class="img_box img_box_07 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="07"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_07" class="img-fluid"></a>
        </div>
        <div class="img_box img_box_08 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="08"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_08" class="img-fluid"></a>
        </div>
        <div class="img_box img_box_09 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="09"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_09" class="img-fluid"></a>
        </div>
        <div class="img_box img_box_010 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="010"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_010" class="img-fluid"></a>
        </div>
    </div>








    <input type="hidden" name="canvasSize" id="canvasSize" value="0">
    <input type="hidden" name="cropID" id="cropID" value="">
    <input type="file" name="image" class="image" id="upload_image" style="display:none" accept="image/jpeg, image/png" />
</div>