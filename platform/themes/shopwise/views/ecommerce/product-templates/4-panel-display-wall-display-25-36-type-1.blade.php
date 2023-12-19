<style>
    .btn-edit-modal-Image {
        display: none;
    }

    .main_frame {
        display: grid;
        grid-template-columns: 153.6px 172.8px;
        column-gap: 0.2in;
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

    .left_frame {
        aspect-ratio: 16 / 25;
        width: 1.6in;
        height: 2.5in;
    }

    .right_frame {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        width: 1.8in;
        height: 2.5in;
        row-gap: 0.2in;
    }

    .right_bottom {
        display: grid;
        grid-template-columns: repeat(2, 0.8in);
        column-gap: 0.2in;
    }

    .img_box_01 {
        aspect-ratio: 16 / 25;
        width: 1.6in;
        height: 2.5in;
    }

    /* .img_box_01 img {
        height: 100%;
    } */

    .img_box_02 {
        aspect-ratio: 18 / 11;
        width: 1.8in;
        height: 1.1in;
    }

    .img_box_02 img {
        width: 100%;
        height: 100%;
    }

    .img_box_03,
    .img_box_04 {
        aspect-ratio: 8 / 12;
        width: 0.8in;
        height: 1.2in;
    }
</style>

<div class="main_frame" id="main_frame">
    <div class="left_frame">
        <div class="img_box img_box_01 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="01"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_01" class="img-fluid"></a>
        </div>
    </div>

    <div class="right_frame">
        <div class="img_box img_box_02 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="02"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_02" class="img-fluid"></a>
        </div>
        <div class="right_bottom">
            <div class="img_box img_box_03 border">
                <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="03"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_03" class="img-fluid"></a>
            </div>
            <div class="img_box img_box_04 border">
                <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="04"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_04" class="img-fluid"></a>
            </div>
        </div>
    </div>


    <input type="hidden" name="canvasSize" id="canvasSize" value="0">
    <input type="hidden" name="cropID" id="cropID" value="">
    <input type="file" name="image" class="image" id="upload_image" style="display:none" accept="image/jpeg, image/png" />
</div>