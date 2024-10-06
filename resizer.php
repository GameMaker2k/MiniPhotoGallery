<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the Revised BSD License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    Revised BSD License for more details.

    Copyright 2004-2015 iDB Support - http://idb.berlios.de/
    Copyright 2004-2015 Game Maker 2k - http://gamemaker2k.org/

    $FileInfo: resizer.php - Last Update: 1/2/2015 Ver 2.5 - Author: cooldude2k $
*/
require_once("settings.php");
if ($_GET['url'] == "referer") {
    header("Location: ".$Settings['photo_url']."resizer.php?url=".urlencode($_SERVER["HTTP_REFERER"])."");
}
if ($_GET['url'] == null) {
    ?>
<title> Pic Resizer 2k </title>
<form method="get" action="<?php echo $Settings['photo_url']; ?>resizer.php?act=Create">
<label for="type">Insert the IMG Type:<br />
&nbsp;</label><select size="1" name="type" id="type">
<option value="gif">GIF</option>
<option value="png">PNG</option>
<option value="jpeg">JPEG</option>
</select><br />
<label for="newtype">Insert the New IMG Type:<br />
&nbsp;</label><select size="1" name="newtype" id="newtype">
<option value="gif">GIF</option>
<option value="png">PNG</option>
<option value="jpeg">JPEG</option>
</select><br />
True Color:
<label for="on1">on</label>
<input type="radio" name="TrueColor" value="on" checked="checked" id="on1">
<label for="off1">off</label>
<input type="radio" name="TrueColor" value="off" id="off1">
<br />
Interlace:
<label for="on2">on</label>
<input type="radio" name="Interlace" value="on" checked="checked" id="on2">
<label for="off2">off</label>
<input type="radio" name="Interlace" value="off" id="off2">
<br /><label for="size">Insert IMG Size by percent:<br />
&nbsp;</label><input type="text" name="size" value="" id="size"><br />
<br /><label for="quality">Insert Jpeg quality:<br />
&nbsp;</label><input type="text" name="quality" value="75" id="quality"><br />
<label for="url">Insert URL to IMG:<br />
&nbsp;</label><input type="text" name="url" value="" id="url"><br />
<input type="submit" value="Submit" />
<input type="reset" value="Reset" />
</form>
<?php }
if ($_GET['url'] != null) {
    $urltype = parse_url($_GET['url']);
    if ($urltype["scheme"] == "data") {
        $partpic = explode(";", $urltype["path"]);
        $testpic = explode(",", $partpic[1]);
        $picdata = $testpic[1];
        $partype = explode("/", $partpic[0]);
        $_GET['type'] = $partype[1];
        file_put_contents("tmpic.".$partype[1], base64_decode($picdata));
        $_GET['url'] = "tmpic.".$partype[1];
    }
    // File and new size
    $filename = $_GET['url'];
    if ($_GET['size'] == null) {
        $_GET['size'] = "0.5";
    }
    if ($_GET['type'] == "jpg") {
        $_GET['type'] = "jpeg";
    }
    if ($_GET['newtype'] == "jpg") {
        $_GET['newtype'] = "jpeg";
    }
    if ($_GET['newtype'] == null) {
        $_GET['newtype'] = $_GET['type'];
    }
    //if ($_GET['newtype']=="gif") { $_GET['newtype']="png"; }
    $percent = $_GET['size'];
    if ($_GET['quality'] == null) {
        $_GET['quality'] = 75;
    }
    $_GET['quality'] = (int) $_GET['quality'];
    // Normal IMG Types
    if ($_GET['newtype'] == "png") {
        header('Content-type: image/png');
    }
    if ($_GET['newtype'] == "gif") {
        header('Content-type: image/gif');
    }
    if ($_GET['newtype'] == "jpeg") {
        header('Content-type: image/jpeg');
    }
    // Other IMG Types
    //if ($_GET['newtype']=="gd") { header('Content-type: image/gd'); }
    //if ($_GET['newtype']=="gd2") { header('Content-type: image/gd2'); }
    if ($_GET['newtype'] == "wbmp") {
        header('Content-type: image/vnd.wap.wbmp');
    }
    if ($_GET['newtype'] == "xbm") {
        header('Content-type: image/x-xbitmap');
    }
    if ($_GET['newtype'] == "xpm") {
        header('Content-type: image/x-xpixmap');
    }
    // Get new sizes
    list($width, $height) = getimagesize($filename);
    $newwidth = $width * $percent;
    $newheight = $height * $percent;
    // Load
    if ($_GET['TrueColor'] == "on") {
        $thumb = imagecreatetruecolor($newwidth, $newheight);
    }
    if ($_GET['TrueColor'] == "off") {
        $thumb = imagecreate($newwidth, $newheight);
    }
    if ($_GET['TrueColor'] == null) {
        $thumb = imagecreatetruecolor($newwidth, $newheight);
    }
    //$_GET['newtype']=$_GET['type'];
    // Normal IMG Types
    if ($_GET['type'] == "png") {
        $source = imagecreatefrompng($filename);
    }
    if ($_GET['type'] == "gif") {
        $source = imagecreatefromgif($filename);
    }
    if ($_GET['type'] == "jpeg") {
        $source = imagecreatefromjpeg($filename);
    }
    // Other IMG Types
    if ($_GET['type'] == "gd") {
        $source = imagecreatefromgd($filename);
    }
    if ($_GET['type'] == "gd2") {
        $source = imagecreatefromgd($filename);
    }
    if ($_GET['type'] == "wbmp") {
        $source = imagecreatefromwbmp($filename);
    }
    if ($_GET['type'] == "xbm") {
        $source = imagecreatefromxbm($filename);
    }
    if ($_GET['type'] == "xpm") {
        $source = imagecreatefromxpm($filename);
    }
    // Resize
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    imagepalettecopy($thumb, $source);
    if ($_GET['TrueColor'] == "on") {
        imageinterlace($thumb, 1);
    }
    if ($_GET['TrueColor'] == "off") {
        imageinterlace($thumb, 0);
    }
    if ($_GET['TrueColor'] == null) {
        imageinterlace($thumb, 1);
    }
    imagecolortransparent($thumb);
    // Output
    // Normal IMG Types
    if ($_GET['newtype'] == "png") {
        imagepng($thumb);
    }
    if ($_GET['newtype'] == "gif") {
        imagegif($thumb);
    }
    if ($_GET['newtype'] == "jpeg") {
        imagejpeg($thumb, null, $_GET['quality']);
    }
    // Other IMG Types
    if ($_GET['newtype'] == "gd") {
        imagegd($thumb);
    }
    if ($_GET['newtype'] == "gd2") {
        imagegd2($thumb);
    }
    if ($_GET['newtype'] == "wbmp") {
        imagewbmp($thumb);
    }
    if ($_GET['newtype'] == "xbm") {
        imagexbm($thumb);
    }
    if ($_GET['newtype'] == "xbp") {
        imagexbp($thumb);
    }
    imagedestroy($source);
    imagedestroy($thumb);
    if ($urltype["scheme"] == "data") {
        unlink($_GET['url']);
    }
}
?>
