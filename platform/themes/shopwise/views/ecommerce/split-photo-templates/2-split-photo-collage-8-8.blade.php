<style>

    .btn-edit-modal-Image {

        display: none;

    }



    .main_frame {

        display: grid;

        grid-template-columns: repeat(2, 1fr);

        background-color: #fff;

        padding: 10px;

        align-content: center;

        column-gap: 15px;

    }



    .img_box {

        aspect-ratio: 1/1;

        display: grid;

        align-content: center;

        background-color: #33333340;

        /* margin: 3px; */

        font-size: 30px;

        text-align: center;

        box-shadow: 2px 2px 2px 0px #00000050;

    }



    .frame_download_icon {

        position: absolute;

        top: 50%;

        left: 50%;

        transform: translate(-50%, -50%);

    }



    .download_icon {

        font-size: 42px;

        color: #ff324d;

    }



    #mosaic_wrapper {

        width: 430px;

    }



    #mosaic_wrapper .panel {

        float: left;

        width: 205px;

        height: 205px;

        margin: 3px;

        /*background: url('/images/orders/main_images/main_163332523344048.jpg') no-repeat 300px 200px fixed;*/

        box-shadow: 2px 2px 2px 0px #00000050;

        background-color: #33333340;

    }



    /*#mosaic_wrapper .panel2{

        height: 122px !important;

    }*/

</style>



<div class="main_frame" id="main_frame">

    <div id="mosaic_wrapper">

        <div>

            <div class="panel firstdiv"></div>

            <div class="panel panel2"></div>

            <!-- <div class="panel panel2 panel3"></div> -->

        </div>

    </div>



    <div class="frame_download_icon" id="frame_download_icon">

        <a href="javascript:void(0)" title="Upload Image" class="uploadImage"><span class="download_icon"><i class="ion-android-upload"></i></span></a>

    </div>

</div>
<script>
let crop_width = 480;
let crop_height = 250;
let left_position = 3;
let leftDivPosition = ' -3px 0';
var firstDivWidth = $('#mosaic_wrapper .panel:first-child').width() + left_position;
let secondDivPosition = ' -'+firstDivWidth+ "px 0";
</script>