<style>
    .btn-edit-modal-Image {
        display: none;
    }

    .main_frame {
        width: 4.0in;
        height: 4.0in;
        background-color: #fff;
        padding: 10px;
        align-content: center;
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
        /* display: grid; */
        width: 1.5in;
        /* display: inline-block; */
        float: left;
    }

    .right_frame {
        width: 1.5in;
        /* display: inline-block; */
        float: left;
        margin-left: 10px;
    }

    .img_box_01 {
        aspect-ratio: 1 / 1;
        width: 1.5in;
        height: 1.5in;
        margin-bottom: 10px;
    }

    /* .img_box_01 img {
        height: 100%;
    } */

    .img_box_02 {
        aspect-ratio: 1 / 1;
        width: 1.5in;
        height: 1.5in;
    }

    .img_box_03 {
        aspect-ratio: 1 / 1;
        width: 1.5in;
        height: 1.5in;
        margin-bottom: 10px;
    }

    .img_box_04 {
        aspect-ratio: 1 / 1;
        width: 1.5in;
        height: 1.5in;
    }
</style>

<div class="main_frame" id="main_frame">
    <div class="left_frame">
        <div class="img_box img_box_01 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="01"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_01" class="img-fluid"></a>
        </div>
        <div class="img_box img_box_02 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="02"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_02" class="img-fluid"></a>
        </div>
    </div>

    <div class="right_frame">
        <div class="img_box img_box_03 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="03"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_03" class="img-fluid"></a>
        </div>
        <div class="img_box img_box_04 border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="04"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_04" class="img-fluid"></a>
        </div>
    </div>


    <input type="hidden" name="canvasSize" id="canvasSize" value="0">
    <input type="hidden" name="cropID" id="cropID" value="">
    <input type="file" name="image" class="image" id="upload_image" style="display:none" accept="image/jpeg, image/png" />
</div>