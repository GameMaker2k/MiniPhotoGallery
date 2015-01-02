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

    $FileInfo: thumbnail.php - Last Update: 1/2/2015 Ver 2 - Author: cooldude2k $
*/
require_once("settings.php");
header("Content-type: image/jpeg");
if(!isset($Settings['url_style'])) { $Settings['url_style'] = 1; }
if($Settings['url_style']!=1&&$Settings['url_style']!=2) { 
	$Settings['url_style'] = 1; }
function file_list_dir($dirname,$lsfile=true,$lsdir=true) {
if(!isset($dirnum)) { $dirnum = null; }
if($lsfile!==true&&$lsfile!==false) { $lsfile = true; }
if($lsdir!==true&&$lsdir!==false) { $lsdir = true; }
if($dirname=="."||$dirname=="..") { $dirname = $dirname."/"; }
$srcfile = array();
$srcdir = array();
if ($handle = opendir($dirname)) {
while (false !== ($file = readdir($handle))) {
      if ($dirnum==null) { $dirnum = 0; }
	  if ($file != "." && $file != ".." && $file != ".htaccess" && $file != null) {
      if(filetype($dirname.$file)=="file"&&$lsfile==true) {
	  $srcfile[$dirnum] = $file; }
      if(filetype($dirname.$file)=="dir"&&$lsdir==true) {
	  $srcdir[$dirnum] = $file; }
	  ++$dirnum;
	  } }
if($srcdir!=null&&$lsdir==true) { asort($srcdir); }
if($srcfile!=null&&$lsfile==true) { asort($srcfile); }
if($srcdir!=null&&$srcfile!=null&&$lsfile==true&&$lsdir==true) {
$fulllist = array_merge($srcdir, $srcfile); }
if($srcdir!=null&&$srcfile==null) { $fulllist = $srcdir; }
if($srcdir==null&&$srcfile!=null) { $fulllist = $srcfile; }
if($lsdir==true&&$lsfile==false) { $fulllist = $srcdir; }
if($lsfile==true&&$lsdir==false) { $fulllist = $srcfile; }
closedir($handle); }
 return $fulllist; }
$ListDir = file_list_dir($Settings['photo_dir'],false,true);
if(isset($_GET['dir'])&&in_array($_GET['dir'],$ListDir)) {
if(isset($_GET['file'])&&file_exists($Settings['photo_dir'].$_GET['dir']."/".$_GET['file'])) {
echo exif_thumbnail($Settings['photo_dir'].$_GET['dir']."/".$_GET['file']); } }
?>
