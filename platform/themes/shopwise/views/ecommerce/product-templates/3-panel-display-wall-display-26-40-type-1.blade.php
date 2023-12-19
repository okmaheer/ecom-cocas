<style>
    .btn-edit-modal-Image {
        display: none;
    }

    .main_frame {
        height: 2.6in;
        width: 4.0in;
        display: flex;
    }

    .main_frame_left {
        height: 2.6in;
        width: 2.6in;
        margin-right: 0.1in;
    }

    .main_frame_right {
        height: 2.6in;
        width: 1.2in;
        margin-left: 0.1in;
    }

    .img_box_01 {
        height: 2.6in;
        width: 2.6in;
    }

    .img_box_02 {
        height: 1.2in;
        width: 1.2in;
        margin-bottom: 0.2in;
    }

    .img_box_03 {
        height: 1.2in;
        width: 1.2in;
        /* margin-top: 0.1in */
    }
</style>
<div class="main_frame" id="main_frame">
    <div class="main_frame_left">
        <div class="img_box_01 shadow-sm border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="01"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_01"></a>
        </div>
    </div>
    <div class="main_frame_right">
        <div class="img_box_02 shadow-sm border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="02"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_02"></a>
        </div>
        <div class="img_box_03 shadow-sm border">
            <a href="javascript:void(0);" class="uploadImage" title="Upload frame image" data-id="03"><img src="https://cocanva.in/shopeComm/vendor/core/core/base/images/placeholder.png" id="uploaded_image_03"></a>
        </div>
    </div>
    <input type="hidden" name="canvasSize" id="canvasSize" value="0">
    <input type="hidden" name="cropID" id="cropID" value="">
    <input type="file" name="image" class="image" id="upload_image" style="display:none" accept="image/jpeg, image/png" />
</div>
