<style>
    .upg-desp {
        color: #999;
        font-size: 1.2em;
    }

    .upg-profile-name {
        color: #999;
    }

    .avatar {
        border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
    }
</style>
<div class="page type-page">
    <div class="pure-g">
        <div class="pure-u-1" style="text-align:center"> <?php echo upg_position1(); ?></div>
        <div class="pure-u-1 pure-u-md-1-1" style="text-align:center;">
            <div class="upg_image-frame">

                <img src="<?php echo $image; ?>" class="pure-img">


            </div>
            <?php echo upg_show_icon_grid(); ?>
        </div>



        <div class="pure-u-1">
            <div class="margin-box">


                <div class="upg-desp"> <?php echo $text; ?> </div>

            </div>
        </div>

        <div class=" pure-u-1-2 pure-u-md-1-3">
            <?php
            echo upg_author($author, false) . "<br>";

            ?>

        </div>

        <div class=" pure-u-1-2 pure-u-md-1-3">
            &nbsp;
        </div>


        <div class="pure-u-1 pure-u-md-1-3" style="text-align:right">

            <a class="button-success pure-button" href="<?php echo $image_full; ?>" download="<?php echo get_the_title(); ?>">
                <i class="fa fa-download fa-lg "></i> Download original size</a><br>&nbsp;
        </div>

        <div class="pure-u-1">
            <div style="font-size:12px">Camera information are automatically extracted from image file.<br>No information will be available if it is graphically edited.</div>
            <?php
            //echo $image_server_path."---";

            $exif = @exif_read_data($image_server_path, 0, true);
            if (isset($exif['IFD0']['Make'])) {

                //echo "<hr>";
                //var_dump($exif);
                /*
echo "File Name: ".$exif['FILE']['FileName']."<br>";
echo "File Size: ".$exif['FILE']['FileSize']."<br>";
echo "File Date Time: ".date ("F d Y H:i:s.",$exif['FILE']['FileDateTime']);
echo "File Mime Type: ".$exif['FILE']['MimeType']."<br>";
echo "Device Make: ".$exif['IFD0']['Make']."<br>";
echo "Device Model: ".$exif['IFD0']['Model']."<br>";
echo "Image Width: ".$exif['COMPUTED']['Width']."<br>";
echo "Image Height: ".$exif['COMPUTED']['Height']."<br>";
echo "Image Resolution: ".$exif['IFD0']['XResolution']."<br>";
echo "Image Orientation: ".$exif['IFD0']['Orientation']."<br>";
echo "Software Used: ".$exif['IFD0']['Software']."<br>";
echo "Date Edited: ".$exif['IFD0']['DateTime']."<br>";
*/
                ?>
                <table class="pure-table">
                    <thead>
                        <tr>
                            <th colspan="2">Camera Information</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr class="pure-table-odd">
                            <td>Make</td>
                            <td><?php if (isset($exif['IFD0']['Make'])) echo $exif['IFD0']['Make']; ?></td>
                        </tr>
                        <tr>
                            <td>Model</td>
                            <td><?php if (isset($exif['IFD0']['Model'])) echo $exif['IFD0']['Model']; ?></td>
                        </tr>
                        <tr class="pure-table-odd">
                            <td>Exposure</td>
                            <td><?php if (isset($exif['EXIF']['ExposureTime'])) echo $exif['EXIF']['ExposureTime']; ?></td>
                        </tr>
                        <tr>
                            <td>Aperture</td>
                            <td><?php if (isset($exif['COMPUTED']['ApertureFNumber'])) echo $exif['COMPUTED']['ApertureFNumber']; ?></td>
                        </tr>
                        <tr class="pure-table-odd">
                            <td>FNumber</td>
                            <td><?php if (isset($exif['EXIF']['FNumber'])) echo $exif['EXIF']['FNumber']; ?></td>
                        </tr>
                        <tr>
                            <td>ISO Speed</td>
                            <td><?php if (isset($exif['EXIF']['ISOSpeedRatings'])) echo $exif['EXIF']['ISOSpeedRatings']; ?></td>
                        </tr>
                        <tr class="pure-table-odd">
                            <td>Software Used</td>
                            <td><?php if (isset($exif['IFD0']['Software'])) echo $exif['IFD0']['Software']; ?></td>
                        </tr>
                        <tr>
                            <td>Original Date</td>
                            <td><?php if (isset($exif['EXIF']['DateTimeOriginal'])) echo $exif['EXIF']['DateTimeOriginal']; ?></td>
                        </tr>

                    </tbody>
                </table>
            <?php
            }
            ?>

        </div>

        <div class="pure-u-1"> <?php upg_list_tags($post); ?> <br> <?php echo upg_position2(); ?></div>

    </div>
</div>