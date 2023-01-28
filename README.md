PHP Wallpaper Gallery
=====================

> A super simple PHP-based wallpaper gallery meant to be run on an internal local/home network.


### Licensing

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

### About

First of all, this software is 100% free and open-source.  Contributions from the open-source community and users of my software are absolutely welcome.  If you have any modifications or improvements you'd like to contribute, feel free to send me a pull request.

I designed this software because I work a lot with virtual machines and laptops and I'm frequently tinkering with and performing fresh installs of linux on different systems.  After setting up an FTP server for my favorite config files, I decided having an easy place to get my favorite desktop wallpapers was just as important.  You may want to do the same, or you might simply want a simple gallery for your favorite images.  Just keep in mind, non-wallpaper images are untested, and if they are drastically different than the standard 1920x1080 or its portrait orientation variant (with some wiggle room allowed), some images ***may*** appear sqished or distorted, although you might be able to fix things in the code by choosing different resize ratio percentages, as long as your image sizes are generally uniform.

### Requirements

In order to use this software, you only need to have a functioning web server with PHP capabilities enabled.  This software was designed to be used on an internal home network and installed on a small personal server such as a Raspberry PI, and currently does ***not*** optimize thumbnail images. It is not suitable therefore, to serve images over the internet, as all images displayed are full size and this would drastically slow down the loading of the webpage, especially on slow connections and with large collections.

The page so far works on most modern browsers and even displays without any issue on my iPhone.  And yes, this software does serve a small collection of portrait orientation wallpapers for my mobile devices mixed in with my collection of landscape orientation wallpapers.

### Some warnings

This software is optimized for images that are in the general vicinity of 1920x1080 and would fit most computer and mobile phone screens.  Image sizes outside of this range are untested and therefore considered not supported.  Large collections are currently not supported as I have not yet implemented any kind of pages you can scroll through.  Your ***entire*** collection of ***full-size*** images will be displayed on a single page.  

To give you an idea of what is acceptable, I currently serve 40 high-res desktop wallpaper images from my Raspberry PI running Apache Webserver and its working fine and it appears there is still room to grow.  That being said, I don't yet know the limitations of this software, and honestly this is entirely dependent upon your hardware and browser.  I can't tell you the size or file count of what I think is a "large collection", and my collection might be too much for your setup.

1080x1920 images (in portrait orientation, such as for an iPhone) ***are*** supported.  However, if you plan on serving images who's dimensions are drastically different than the standard 1920x1080, the images will still display, but some might appear squished or distorted, and some modifications in the source code may be required.

Furthermore, only images in the root of the target folder, and one level of subfolders is supported.  Images in any subfolders deeper in the file structure are not supported, and may cause irratic behavior.  Also, having non-image files (such as text files) inside your wallpaper folder may also cause irratic behavior.  This has not been tested.

Additionally, if you choose to use this software, you do so at your own risk.  By using this software, you agree I will not be held liable for anything that happens to you, your data, or your system as a result of using this code.  All code should be treated as untested and never used in a production environment of any kind.  I have taken all reasonable precautions before releasing this software to the public, but that does not mean bugs don't exist or that the code is 100% trustworthy.  As of right now, its a single page of code.  If you have any questions or concerns, do your due dilligence and look over the code thoroughly before running it!

### File Structure, File Location Recommendations, and General Usage

You can host this PHP file wherever you like on your server, but the below variables (in the next section) ***must*** be set to a folder (served by your webserver) where you keep your wallpapers or images.  From there, each folder's name will be displayed as an H2 header, followed by its contents.

Whatever images are in the ***root*** of this folder will be listed as Uncategorized.  This category will not be shown if there are no images there.  Only image files in the root folder or in a next-level subfolder will be handled.

### Configuration

***$target_dir_local*** and ***$target_dir_ext*** (which both point to the exact same folder, except through different URLs) are the only variables that need to be configured upon installation.  They both point to the target directory, except one is a local URL, and the other is external.

Here is an example of a working configuration for reference:

    $target_dir_local = "/var/www/html/res/Wallpaper_Gallery";
    $target_dir_ext = "http://192.168.0.148/res/Wallpaper_Gallery";

***$target_dir_local*** must point to ***your*** Wallpaper Gallery folder, and must be a valid ***filesystem*** url on your server, I.E. it must ***not*** begin with http://, but with whatever the internal filesystem (operating system) path on your server to this folder is (/var/www/html/ is the default for most Apache servers)

***$target_dir_ext*** is the one that can begin with http:// and you would simply use the URL your server is serving that folder with.

Later on in the PHP code, PHP will use its server-side permissions to scan the wallpaper folder (through the OS, which utilizes internal filesystem URLs), and an str_replace function will be called in a foreach loop replacing the local URL of each image with the external one, so that a proper IMG tag can be echoed to the generated webpage.

### Additional Modifications

The Wallpaper Gallery is otherwise ready to run as soon as the above 2 variables are set, and you merely need to visit your link to it in your browser, however, if you don't plan on calling the images Wallpaper images, need to set different proportions for your images, or if you wish to customize the padding of images, the webpage background color, the header sizes, etc, you may need to make additional modifications.  These are all easily viewable and modifiable in the well commented source code.

### Privacy

Being that this is a single page of HTML, PHP, and Javascript, and that the software is 100% free and open-source and that the source code is therefore easily viewable by thousands, this is pretty obvious.  However just for the record, this software does not collect any personal data at all, and does not send anything anywhere.  Yes, it ***does*** scan your filesystem for images, using PHP glob for example, depending on where you set the target directories, but this information is ***only*** used to generate the webpage for your viewing, and none of your images or personal data are ever sent anywhere.  This is all just standard PHP practice.  If you have concerns about data privacy, this is one of those projects thats easy enough where you can simply use this code for reference/learning and simply write your own by hand.
