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

    $FileInfo: index_new.php - Last Update: 1/2/2015 Ver 2.5 - Author: cooldude2k $
*/
require_once("settings.php"); 
$_GET['num'] = 2;
/*
if(!isset($_GET['num'])) { $_GET['num'] = 2; }
if(!is_numeric($_GET['num'])) { $_GET['num'] = 2; }
if($_GET['num']<5 && $_GET['num']>25) { $_GET['num'] = 2; }
*/
if(!isset($Settings['url_style'])) { $Settings['url_style'] = 1; }
if($Settings['url_style']!=1 && $Settings['url_style']!=2) { 
	$Settings['url_style'] = 1; }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title> Image Viewer 2k </title>
  <base href="<?php echo $Settings['photo_url']; ?>" />
<style type="text/css">
body {
background-color: black; 
color: yellow;
}
a {
	font-size: 15px;
	color: #FFFF00;
	background-color: transparent; 
}
a:link {
	background-color: transparent;
	color: #FFFF00;
}
a:visited {
	text-decoration: none;
	background-color: transparent;
	color: #00FF00;
}
a:hover {
	text-decoration: none;
	background-color: transparent;
	color: #00FFFF;
}
a:active {
	text-decoration: none;
	background-color: transparent;
	color: #FF9999;
}
</style>
 </head>

 <body>
<?php
function file_list_dir($dirname,$lsfile=true,$lsdir=true) {
   if(!isset($dirnum)) { $dirnum = null; }
   if($lsfile!==true && $lsfile!==false) { $lsfile = true; }
   if($lsdir!==true && $lsdir!==false) { $lsdir = true; }
   if($dirname=="." || $dirname=="..") { $dirname = $dirname."/"; }
   $srcfile = array();
   $srcdir = array();
   if ($handle = opendir($dirname)) {
   while (false !== ($file = readdir($handle))) {
      if ($dirnum==null) { $dirnum = 0; }
	  if ($file != "." && $file != ".." && $file != ".htaccess" && $file != null) {
      if(filetype($dirname.$file)=="file" && $lsfile===true && is_readable($dirname.$file)===true) {
      if($lsdir===false && $lsfile===true) {
	  ++$dirnum; }
	  $srcfile[$dirnum] = $file; }
      if(filetype($dirname.$file)=="dir" && $lsdir===true && is_readable($dirname.$file)===true) {
      if($lsdir===true && $lsfile===false && is_readable($dirname.$file)===true) {
	  ++$dirnum; }
	  $srcdir[$dirnum] = $file; }
      if($lsdir===true && $lsfile===true && is_readable($dirname.$file)===true) {
	  ++$dirnum; }
      } }
      if($srcdir!=null && $lsdir===true) { asort($srcdir); }
      if($srcfile!=null && $lsfile===true) { asort($srcfile); }
      if($srcdir!=null && $srcfile!=null && $lsfile===true && $lsdir===true) {
      $fulllist = array_merge($srcdir, $srcfile); }
      if($srcdir!=null && $srcfile==null) { $fulllist = $srcdir; }
      if($srcdir==null && $srcfile!=null) { $fulllist = $srcfile; }
      if($lsdir===true && $lsfile===false) { $fulllist = $srcdir; }
      if($lsfile===true && $lsdir===false) { $fulllist = $srcfile; }
      closedir($handle); }
   return $fulllist; }
$ListDir = file_list_dir($Settings['photo_dir'],false,true);
if(isset($_GET['dir']) && !in_array($_GET['dir'],$ListDir)) {
	$_GET['dir'] = null; }
if(isset($_GET['dir']) && in_array($_GET['dir'],$ListDir)) {
$ListFile = file_list_dir($Settings['photo_dir'].$_GET['dir']."/",true,false);
$x=1; $y=count($ListFile); $z = 0;
while ($x <= $y) {
if(isset($ListFile[$x])===true && $ListFile[$x]!=null) {
$exif_data = exif_read_data($Settings['photo_dir'].$_GET['dir']."/".$ListFile[$x]);
$emake = trim(preg_replace('/\s\s+/', ' ', $exif_data['Make']));
$emodel = trim(preg_replace('/\s\s+/', ' ', $exif_data['Model']));
$eexposuretime = $exif_data['ExposureTime'];
$efnumber = $exif_data['FNumber'];
$eiso = $exif_data['ISOSpeedRatings'];
$eshutter = $exif_data['ShutterSpeedValue'];
$eaperture = $exif_data['ApertureValue'];
$emaxaperture = $exif_data['MaxApertureValue'];
if(isset($exif_data['DateTime'])) {
$edate = $exif_data['DateTime']; }
if(!isset($exif_data['DateTime']) && 
	isset($exif_data['DateTimeOriginal'])) {
$edate = $exif_data['DateTimeOriginal']; }
if(!isset($exif_data['DateTime']) && 
	!isset($exif_data['DateTimeOriginal']) && 
	isset($exif_data['DateTimeDigitized'])) {
$edate = $exif_data['DateTimeDigitized']; }
$edatets = strtotime($edate);
if($z==0) { echo "  <table border=\"1\" style=\"border-color: skyblue;\">\n   <tr style=\"border-color: transparent;\">\n"; }
echo "    <td style=\"border-color: seagreen;\">\n";
if($Settings['url_style']==1) { 
echo "     <a href=\"".$Settings['image']."?dir=".$_GET['dir']."&amp;file=".$ListFile[$x]."\"><img style=\"width: 160px; height: 120px;\" src=\"".$Settings['thumbnail']."?dir=".$_GET['dir']."&amp;file=".$ListFile[$x]."\" alt=\"".$ListFile[$x]."\" title=\"".$emodel."\" /></a> <textarea readonly=\"readonly\" style=\"color: skyblue; background-color: transparent; border-color: transparent; width: 300px; height: 150px;\" id=\"".base64_encode($ListFile[$x])."\" name=\"".base64_encode($ListFile[$x])."\" rows=\"7\" cols=\"29\">Make: ".$emake."\nModel: ".$emodel."\nExposure: ".$eexposuretime."\nF Number: ".$efnumber."\nISO Speed: ".$eiso."\nShutter Speed: ".$eshutter."\nAperture Value: ".$eaperture."\nMax Aperture Value: ".$emaxaperture."\nDate: ".date($Settings['date_format'], $edatets)."\nTime: ".date($Settings['time_format'], $edatets)."</textarea>\n"; }
if($Settings['url_style']==2) { 
echo "     <a href=\"".$Settings['image']."/".$_GET['dir']."/".$ListFile[$x]."\"><img style=\"width: 160px; height: 120px;\" src=\"".$Settings['thumbnail']."/".$_GET['dir']."/thumbnail/".$ListFile[$x]."\" alt=\"".$ListFile[$x]."\" title=\"".$emodel."\" /></a> <textarea readonly=\"readonly\" style=\"color: skyblue; background-color: transparent; border-color: transparent; width: 300px; height: 125px;\" id=\"".base64_encode($ListFile[$x])."\" name=\"".base64_encode($ListFile[$x])."\" rows=\"7\" cols=\"29\">Make: ".$emake."\nModel: ".$emodel."\nExposure: ".$eexposuretime."\nF Number: ".$efnumber."\nISO Speed: ".$eiso."\nShutter Speed: ".$eshutter."\nAperture Value: ".$eaperture."\nMax Aperture Value: ".$emaxaperture."\nDate: ".date($Settings['date_format'], $edatets)."\nTime: ".date($Settings['time_format'], $edatets)."</textarea>\n"; }
echo "    </td>\n"; }
++$z;
if(($z==$_GET['num']) || ($z<$_GET['num'] && $x==$y)) { echo "   </tr>\n  </table>\n"; $z = 0; }
++$x; } }
if(!isset($_GET['dir'])) {
$x=0; $y=count($ListDir);
while ($x <= $y) {
if(isset($ListDir[$x])===true && $ListDir[$x]!=null) {
if($Settings['url_style']==1) { 
echo "<a href=\"".$Settings['index']."?dir=".$ListDir[$x]."\">".$ListDir[$x]."</a><br />\n"; }
if($Settings['url_style']==2) { 
echo "<a href=\"".$Settings['index']."/".$ListDir[$x]."/\">".$ListDir[$x]."</a><br />\n"; } }
++$x; } }
?>
 </body>
</html>
