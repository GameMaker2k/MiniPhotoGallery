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

    $FileInfo: index.php - Last Update: 1/2/2015 Ver 2 - Author: cooldude2k $
*/
require_once("settings.php");
if(strtolower($Settings['photo_style'])!="new" && 
   strtolower($Settings['photo_style'])!="old") { $Settings['photo_style'] = "new"; }
if(strtolower($Settings['photo_style'])=="new") { require_once("index_new.php"); }
if(strtolower($Settings['photo_style'])=="old") { require_once("index_old.php"); }
