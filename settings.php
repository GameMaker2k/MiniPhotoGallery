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

    $FileInfo: settings.php - Last Update: 1/2/2015 Ver 2.5 - Author: cooldude2k $
*/
$File3Name = basename($_SERVER['SCRIPT_NAME']);
if ($File3Name=="settings.php"||$File3Name=="/settings.php"||
    $File3Name=="settingsbak.php"||$File3Name=="/settingsbak.php") {
    @header('Location: index.php');
    exit(); }
$Settings['photo_url'] = "./";
$Settings['photo_dir'] = "./Photos/";
$Settings['photo_style'] = "new";
$Settings['url_style'] = 1;
$Settings['image'] = "image.php";
$Settings['index'] = "index.php";
$Settings['thumbnail'] = "thumbnail.php";
$Settings['date_format'] = "m/d/Y";
$Settings['time_format'] = "H:i:s";
$Settings['site_title'] = "Image Viewer 2k";
?>
