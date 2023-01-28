
<!--
    PHP Wallpaper Gallery
    Copyright (C) 2023 github.com/metalxxhead

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
-->

<html>
<head>
<title>Wallpaper Gallery</title>


<!-- These style/script tags are optional settings that apply to all wallpapers -->

<!-- Set spacing between images displayed here or modify to your liking -->
<!-- using custom commands such as padding-top: 5px or padding: 25px 50px 75px 100px; -->
<!-- Visit https://www.w3schools.com/css/css_padding.asp for help -->


<style>
    img {
        padding: 10px;
    }
</style>

<!-- This javascript runs AFTER the page has fully loaded.  Resizes all images to thumbs -->
<!-- Since this script is meant to be used on a local network, thumbs are not optimized -->

<script>
    function reduceImageSize() {
        //get all elements on the page that use IMG tags
        var images = document.getElementsByTagName("img");
        //and for each one:
        for (var i = 0; i < images.length; i++) {
            //set the width and height to X% of full size
            images[i].style.width = "21%";
            images[i].style.height = "25%";
        }
    }

    //tell the browser to run the above reduceImageSize() function on page loaded event
    window.addEventListener("load", reduceImageSize);
</script>

<!-- The style/script tags above just keep things pretty.  They "could" be entirely -->
<!-- removed, but then all the images would be gigantic and there would be no padding -->
<!-- unless that's what you want.  Remember these settings apply to ALL wallpapers -->

</head>

<!-- End page header.  Body begins below -->

<body bgcolor="black">
<!-- I like black.  If you don't want a black background, change it here -->

<!-- The rest of this page is handled in PHP -->

<?php

//THE TWO VARIABLES BELOW MUST BE MODIFIED TO FIT YOUR SERVER!
//They MUST both point to the exact same folder, the only difference is:
//The first one is the internal filesystem URL and the second one is external.

$target_dir_local = "/var/www/html/res/Wallpaper_Gallery";
$target_dir_ext = "http://192.168.0.148/res/Wallpaper_Gallery";

//To clarify, the scanning of filesystem is handled by PHP through your server's OS
//but the HTML IMG tags the PHP script generates require external URLS
//and so an str_replace function will be called on each internal URL
//to replace the internal URL with an external one as the IMG tags are generated


//First, lets start by handling any images that are in the root of the Wallpaper folder:
$root_images = glob($target_dir_local . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

//Only display this category AND it's header IF at least 1 image exists
//otherwise don't show anything at all
if(count($root_images) > 0)
{
    //Display these images under the header "Uncategorized Wallpaper"
    echo "<br><br><br><h2>Uncategorized Wallpaper</h2><br><br><br>";

    //For each wallpaper image in the root of the folder (that is not inside a subfolder)
    foreach ($root_images as $file) {
        //replace the internal (server-side URL) with the external one
        $file_path = str_replace($target_dir_local, $target_dir_ext, $file);

        //create an HTML IMG tag encapsulated within a link tag
        //so that the wallpaper image is displayed AND it is clickable and takes you to
        //the original file
        echo '<a href="' . $file_path . '"><img src="' . $file_path . '" style="width: 100%; height: auto; object-fit: contain;"></a>';
        //the type of IMG tag generated above should allow for both landscape and
        //portrait mode style wallpapers
    }
    //The foreach (wallpaper in root folder) ends HERE
}
//The IF (there is at least one wallpaper) ends HERE

//At this point, all wallpaper images in the root of the folder have been handled.
//Now we need to handle wallpaper images that have been categorized into subfolders.

//make $dirs an array of all full directory paths inside of the Wallpaper folder
$dirs = glob($target_dir_local . '/*' , GLOB_ONLYDIR);

//for each directory in the Wallpaper folder, assign this directory to the variable $folder_path and:
foreach ($dirs as $folder_path)
{
    //break the folder path URL up by /'s so we can get each folder in the path
    //but we only really need the last folder which is the wallpaper subfolder
    $folder_name = explode('/', $folder_path);

    //create an H2 HTML header out of the folder path using only the words after the last index of /
    echo "<br><br><br><h2>" . end($folder_name) . "</h2><br><br><br>";

    //now that we have pretty-printed the folder's name, get each wallpaper inside it
    $di = new RecursiveDirectoryIterator($folder_path);

    //for each wallpaper in this subfolder
    foreach (new RecursiveIteratorIterator($di) as $filename => $file)
    {
        //replace the local part of the path with the externally accessible version of it
        $file_path = str_replace($target_dir_local, $target_dir_ext, $filename);

        //split the file path string this time (not folder path as above) on all /'s
        $segments = explode('/', $file_path);

        //excluding all references to the self and it's parent folders
        if (end($segments) != '.' && end($segments) != '..')
        {
            //create an HTML IMG tag encapsulated within a link tag
            //so that the wallpaper image is displayed AND it is clickable and takes you to
            //the original file
            $imageSize = getimagesize($file_path);
            $imgWidth = $imageSize[0];
            $imgHeight = $imageSize[1];
			echo '<a href="' . $file_path . '"><img src="' . $file_path . '" style="width: 100%; height: auto; object-fit: contain;"></a>';
            //the type of IMG tag generated above should allow for both landscape and
            //portrait mode style wallpapers

        }
        //The IF statement excluding self and parent folders ends HERE

    }
    //The foreach (wallpaper in the subfolder) ends HERE

}
//The foreach (directory containing wallpapers) ends HERE

?>
<!-- PHP Script ends HERE -->

</body>

<!-- End page body & close HTML -->
</html>
