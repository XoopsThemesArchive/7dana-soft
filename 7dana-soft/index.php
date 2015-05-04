<?php
/*
fb2index.php - derrived from the Nanoweb HTTP Servers' filebrowser2
¯¯¯¯¯¯¯¯¯¯¯¯
This script provides a fancy web server directory listing, many things
(including file types and icons) can be easily configured on top of this
script.
Distributed under the terms and conditions of the GNU General Public
License version 2 (or at your option any later) from the Free Software
Foundation. For more information see http://www.gnu.org/copyleft/gpl.html
*/
#-- configuration -----------------------------------------------------------
define("EXCLUDE_DOTFILES", 1);
define("MIX_DIRS_AND_FILES", 0);
define("SORT_DIRECTORIES", 0);
define("SORT_FILES", 1);
define("SORT_NOCASE", 1);
define("SHORT_DIRNAME", 1);
define("LIST_COLS", 5);
define("PREVIEW", 0 &&function_exists("imagepng"));
define("PREVIEW_MAXWIDTH", 100);
#<off># dl("gd.so");
#-- icons
$icons_base = "http://xoops.codigolivre.org.br/imagens/gnome-icons";
# $icons_base = "/icons";
$icons = array(
"blockdev" => "$icons_base/gnome-fs-blockdev.png",
"bookmark-missing" => "$icons_base/gnome-fs-bookmark-missing.png",
"bookmark" => "$icons_base/gnome-fs-bookmark.png",
"chardev" => "$icons_base/gnome-fs-chardev.png",
"desktop" => "$icons_base/gnome-fs-desktop.png",
"directory-accept" => "$icons_base/gnome-fs-directory-accept.png",
"directory" => "$icons_base/gnome-fs-directory.png",
"executable" => "$icons_base/gnome-fs-executable.png",
"fifo" => "$icons_base/gnome-fs-fifo.png",
"ftp" => "$icons_base/gnome-fs-ftp.png",
"home" => "$icons_base/gnome-fs-home.png",
"loading-icon" => "$icons_base/gnome-fs-loading-icon.png",
"network" => "$icons_base/gnome-fs-network.png",
"nfs" => "$icons_base/gnome-fs-nfs.png",
"regular" => "$icons_base/gnome-fs-regular.png",
"server" => "$icons_base/gnome-fs-server.png",
"share" => "$icons_base/gnome-fs-share.png",
"smb" => "$icons_base/gnome-fs-smb.png",
"socket" => "$icons_base/gnome-fs-socket.png",
"ssh" => "$icons_base/gnome-fs-ssh.png",
"trash-empty" => "$icons_base/gnome-fs-trash-empty.png",
"trash-full" => "$icons_base/gnome-fs-trash-full.png",
"web" => "$icons_base/gnome-fs-web.png",
"application/msword" => "$icons_base/gnome-mime-application-msword.png",
"application/pdf" => "$icons_base/gnome-mime-application-pdf.png",
"application/pgp-encrypted" => "$icons_base/gnome-mime-application-pgp-encrypted.png",
"application/pgp-keys" => "$icons_base/gnome-mime-application-pgp-keys.png",
"application/pgp" => "$icons_base/gnome-mime-application-pgp.png",
"application/postscript" => "$icons_base/gnome-mime-application-postscript.png",
"application/qif" => "$icons_base/gnome-mime-application-qif.png",
"application/rtf" => "$icons_base/gnome-mime-application-rtf.png",
"application/vnd.lotus-1-2-3" => "$icons_base/gnome-mime-application-vnd.lotus-1-2-3.png",
"application/vnd.ms-excel" => "$icons_base/gnome-mime-application-vnd.ms-excel.png",
"application/vnd.ms-powerpoint" => "$icons_base/gnome-mime-application-vnd.ms-powerpoint.png",
"application/vnd.rn-realmedia" => "$icons_base/gnome-mime-application-vnd.rn-realmedia.png",
"application/vnd.stardivision.calc" => "$icons_base/gnome-mime-application-vnd.stardivision.calc.png",
"application/vnd.stardivision.impress" => "$icons_base/gnome-mime-application-vnd.stardivision.impress.png",
"application/vnd.stardivision.writer" => "$icons_base/gnome-mime-application-vnd.stardivision.writer.png",
"application/vnd.sun.xml.calc" => "$icons_base/gnome-mime-application-vnd.sun.xml.calc.png",
"application/vnd.sun.xml.impress" => "$icons_base/gnome-mime-application-vnd.sun.xml.impress.png",
"application/vnd.sun.xml.writer" => "$icons_base/gnome-mime-application-vnd.sun.xml.writer.png",
"application/x-abiword" => "$icons_base/gnome-mime-application-x-abiword.png",
"application/x-applix-spreadsheet" => "$icons_base/gnome-mime-application-x-applix-spreadsheet.png",
"application/x-applix-word" => "$icons_base/gnome-mime-application-x-applix-word.png",
"application/x-arj" => "$icons_base/gnome-mime-application-x-arj.png",
"application/x-backup" => "$icons_base/gnome-mime-application-x-backup.png",
"application/x-bzip-compressed-tar" => "$icons_base/gnome-mime-application-x-bzip-compressed-tar.png",
"application/x-bzip" => "$icons_base/gnome-mime-application-x-bzip.png",
"application/x-compressed-tar" => "$icons_base/gnome-mime-application-x-compressed-tar.png",
"application/x-compress" => "$icons_base/gnome-mime-application-x-compress.png",
"application/x-core-file" => "$icons_base/gnome-mime-application-x-core-file.png",
"application/x-dc-rom" => "$icons_base/gnome-mime-application-x-dc-rom.png",
"application/x-deb" => "$icons_base/gnome-mime-application-x-deb.png",
"application/x-dia-diagram" => "$icons_base/gnome-mime-application-x-dia-diagram.png",
"application/x-dvi" => "$icons_base/gnome-mime-application-x-dvi.png",
"application/x-e-theme" => "$icons_base/gnome-mime-application-x-e-theme.png",
"application/x-font-afm" => "$icons_base/gnome-mime-application-x-font-afm.png",
"application/x-font-bdf" => "$icons_base/gnome-mime-application-x-font-bdf.png",
"application/x-font-linux-psf" => "$icons_base/gnome-mime-application-x-font-linux-psf.png",
"application/x-font-pcf" => "$icons_base/gnome-mime-application-x-font-pcf.png",
"application/x-font-sunos-news" => "$icons_base/gnome-mime-application-x-font-sunos-news.png",
"application/x-font-ttf" => "$icons_base/gnome-mime-application-x-font-ttf.png",
"application/x-gameboy-rom" => "$icons_base/gnome-mime-application-x-gameboy-rom.png",
"application/x-genesis-rom" => "$icons_base/gnome-mime-application-x-genesis-rom.png",
"application/x-gnome-app-info" => "$icons_base/gnome-mime-application-x-gnome-app-info.png",
"application/x-gnumeric" => "$icons_base/gnome-mime-application-x-gnumeric.png",
"application/x-gtktalog" => "$icons_base/gnome-mime-application-x-gtktalog.png",
"application/x-gzip" => "$icons_base/gnome-mime-application-x-gzip.png",
"application/x-java-byte-code" => "$icons_base/gnome-mime-application-x-java-byte-code.png",
"application/x-kde-app-info" => "$icons_base/gnome-mime-application-x-kde-app-info.png",
"application/x-killustrator" => "$icons_base/gnome-mime-application-x-killustrator.png",
"application/x-kpresenter" => "$icons_base/gnome-mime-application-x-kpresenter.png",
"application/x-kspread" => "$icons_base/gnome-mime-application-x-kspread.png",
"application/x-kword" => "$icons_base/gnome-mime-application-x-kword.png",
"application/x-mrproject" => "$icons_base/gnome-mime-application-x-mrproject.png",
"application/x-msx-rom" => "$icons_base/gnome-mime-application-x-msx-rom.png",
"application/x-n64-rom" => "$icons_base/gnome-mime-application-x-n64-rom.png",
"application/x-nes-rom" => "$icons_base/gnome-mime-application-x-nes-rom.png",
"application/x-object-file" => "$icons_base/gnome-mime-application-x-object-file.png",
"application/x-ogg" => "$icons_base/gnome-mime-application-x-ogg.png",
"application/x-php" => "$icons_base/gnome-mime-application-x-php.png",
"application/x-python-bytecode" => "$icons_base/gnome-mime-application-x-python-bytecode.png",
"application/x-qw" => "$icons_base/gnome-mime-application-x-qw.png",
"application/x-reject" => "$icons_base/gnome-mime-application-x-reject.png",
"application/x-rpm" => "$icons_base/gnome-mime-application-x-rpm.png",
"application/x-scheme" => "$icons_base/gnome-mime-application-x-scheme.png",
"application/x-smil" => "$icons_base/gnome-mime-application-x-smil.png",
"application/x-sms-rom" => "$icons_base/gnome-mime-application-x-sms-rom.png",
"application/x-sql" => "$icons_base/gnome-mime-application-x-sql.png",
"application/x-stuffit" => "$icons_base/gnome-mime-application-x-stuffit.png",
"application/x-tex" => "$icons_base/gnome-mime-application-x-tex.png",
"application/zip" => "$icons_base/gnome-mime-application-zip.png",
"audio/ac3" => "$icons_base/gnome-mime-audio-ac3.png",
"audio/basic" => "$icons_base/gnome-mime-audio-basic.png",
"audio/" => "$icons_base/gnome-mime-audio.png",
"audio/x-aiff" => "$icons_base/gnome-mime-audio-x-aiff.png",
"audio/x-it" => "$icons_base/gnome-mime-audio-x-it.png",
"audio/x-midi" => "$icons_base/gnome-mime-audio-x-midi.png",
"audio/x-mod" => "$icons_base/gnome-mime-audio-x-mod.png",
"audio/x-mp3" => "$icons_base/gnome-mime-audio-x-mp3.png",
"audio/x-pn-realaudio" => "$icons_base/gnome-mime-audio-x-pn-realaudio.png",
"audio/x-s3m" => "$icons_base/gnome-mime-audio-x-s3m.png",
"audio/x-stm" => "$icons_base/gnome-mime-audio-x-stm.png",
"audio/x-ulaw" => "$icons_base/gnome-mime-audio-x-ulaw.png",
"audio/x-voc" => "$icons_base/gnome-mime-audio-x-voc.png",
"audio/x-wav" => "$icons_base/gnome-mime-audio-x-wav.png",
"audio/x-xi" => "$icons_base/gnome-mime-audio-x-xi.png",
"audio/x-xm" => "$icons_base/gnome-mime-audio-x-xm.png",
"image/bmp" => "$icons_base/gnome-mime-image-bmp.png",
"image/gif" => "$icons_base/gnome-mime-image-gif.png",
"image/ief" => "$icons_base/gnome-mime-image-ief.png",
"image/jpeg" => "$icons_base/gnome-mime-image-jpeg.png",
"image/" => "$icons_base/gnome-mime-image.png",
"image/png" => "$icons_base/gnome-mime-image-png.png",
"image/svg" => "$icons_base/gnome-mime-image-svg.png",
"image/tiff" => "$icons_base/gnome-mime-image-tiff.png",
"image/x-3ds" => "$icons_base/gnome-mime-image-x-3ds.png",
"image/x-applix-graphic" => "$icons_base/gnome-mime-image-x-applix-graphic.png",
"image/x-cmu-raster" => "$icons_base/gnome-mime-image-x-cmu-raster.png",
"image/x-lwo" => "$icons_base/gnome-mime-image-x-lwo.png",
"image/x-lws" => "$icons_base/gnome-mime-image-x-lws.png",
"image/x-portable-anymap" => "$icons_base/gnome-mime-image-x-portable-anymap.png",
"image/x-portable-bitmap" => "$icons_base/gnome-mime-image-x-portable-bitmap.png",
"image/x-portable-graymap" => "$icons_base/gnome-mime-image-x-portable-graymap.png",
"image/x-portable-pixmap" => "$icons_base/gnome-mime-image-x-portable-pixmap.png",
"image/x-psd" => "$icons_base/gnome-mime-image-x-psd.png",
"image/x-rgb" => "$icons_base/gnome-mime-image-x-rgb.png",
"image/x-tga" => "$icons_base/gnome-mime-image-x-tga.png",
"image/x-xbitmap" => "$icons_base/gnome-mime-image-x-xbitmap.png",
"image/x-xcf" => "$icons_base/gnome-mime-image-x-xcf.png",
"image/x-xfig" => "$icons_base/gnome-mime-image-x-xfig.png",
"image/x-xpixmap" => "$icons_base/gnome-mime-image-x-xpixmap.png",
"image/x-xwindowdump" => "$icons_base/gnome-mime-image-x-xwindowdump.png",
"text/css" => "$icons_base/gnome-mime-text-css.png",
"text/html" => "$icons_base/gnome-mime-text-html.png",
"text/" => "$icons_base/gnome-mime-text.png",
"text/x-authors" => "$icons_base/gnome-mime-text-x-authors.png",
"text/x-c-header" => "$icons_base/gnome-mime-text-x-c-header.png",
"text/x-copying" => "$icons_base/gnome-mime-text-x-copying.png",
"text/x-c" => "$icons_base/gnome-mime-text-x-c.png",
"text/x-c++" => "$icons_base/gnome-mime-text-x-c++.png",
"text/x-credits" => "$icons_base/gnome-mime-text-x-credits.png",
"text/x-csh" => "$icons_base/gnome-mime-text-x-csh.png",
"text/x-haskell" => "$icons_base/gnome-mime-text-x-haskell.png",
"text/x-install" => "$icons_base/gnome-mime-text-x-install.png",
"text/x-java" => "$icons_base/gnome-mime-text-x-java.png",
"text/x-literate-haskell" => "$icons_base/gnome-mime-text-x-literate-haskell.png",
"text/x-lyx" => "$icons_base/gnome-mime-text-x-lyx.png",
"text/x-makefile" => "$icons_base/gnome-mime-text-x-makefile.png",
"text/xml" => "$icons_base/gnome-mime-text-xml.png",
"text/x-patch" => "$icons_base/gnome-mime-text-x-patch.png",
"text/x-perl" => "$icons_base/gnome-mime-text-x-perl.png",
"text/x-python" => "$icons_base/gnome-mime-text-x-python.png",
"text/x-readme" => "$icons_base/gnome-mime-text-x-readme.png",
"text/x-sh" => "$icons_base/gnome-mime-text-x-sh.png",
"text/x-sql" => "$icons_base/gnome-mime-text-x-sql.png",
"text/x-tex" => "$icons_base/gnome-mime-text-x-tex.png",
"text/x-troff-man" => "$icons_base/gnome-mime-text-x-troff-man.png",
"text/x-zsh" => "$icons_base/gnome-mime-text-x-zsh.png",
"video/mpeg" => "$icons_base/gnome-mime-video-mpeg.png",
"video/" => "$icons_base/gnome-mime-video.png",
"video/quicktime" => "$icons_base/gnome-mime-video-quicktime.png",
"video/x-ms-asf" => "$icons_base/gnome-mime-video-x-ms-asf.png",
"video/x-msvideo" => "$icons_base/gnome-mime-video-x-msvideo.png",
"video/x-ms-wmv" => "$icons_base/gnome-mime-video-x-ms-wmv.png",
"x-directory/smb-share" => "$icons_base/gnome-mime-x-directory-smb-share.png",
"x-font/afm" => "$icons_base/gnome-mime-x-font-afm.png",
);
$icons["default"] = &$icons["regular"];
$icons["symlink"] = &$icons["bookmark"];

#-- exclude from listing
$exclude = array(
".",
basename(__FILE__),
// "..",
);
#-- mime data
$mime = array (
"ez" => "application/andrew-inset", "csm" => "application/cu-seeme", "cu"
=> "application/cu-seeme", "tsp" => "application/dsptype", "spl" =>
"application/x-futuresplash", "cpt" => "image/x-corelphotopaint", "hqx"
=> "application/mac-binhex40", "nb" => "application/mathematica", "mdb"
=> "application/msaccess", "doc" => "application/msword", "dot" =>
"application/msword", "bin" => "application/octet-stream", "oda" =>
"application/oda", "pdf" => "application/pdf", "pgp" =>
"application/pgp-signature", "ps" => "application/postscript", "ai" =>
"application/postscript", "eps" => "application/postscript", "rtf" =>
"text/rtf", "smi" => "application/smil", "smil" => "application/smil",
"mif" => "application/x-mif", "xls" => "application/vnd.ms-excel", "xlb"
=> "application/vnd.ms-excel", "ppt" => "application/vnd.ms-powerpoint",
"pps" => "application/vnd.ms-powerpoint",
"pot" => "application/vnd.ms-powerpoint", "sdw" =>
"application/vnd.stardivision.writer", "sgl" =>
"application/vnd.stardivision.writer-global", "vor" =>
"application/vnd.stardivision.writer", "sdc" =>
"application/vnd.stardivision.calc", "sda" =>
"application/vnd.stardivision.draw", "sdd" =>
"application/vnd.stardivision.impress", "sdp" =>
"application/vnd.stardivision.impress-packed", "smf" =>
"application/vnd.stardivision.math", "sds" =>
"application/vnd.stardivision.chart", "smd" =>
"application/vnd.stardivision.mail", "wbxml" =>
"application/vnd.wap.wbxml", "wmlc" => "application/vnd.wap.wmlc",
"wmlsc" => "application/vnd.wap.wmlscriptc", "wp5" =>
"application/wordperfect5.1", "zip" => "application/zip", "wk" =>
"application/x-123", "bcpio" => "application/x-bcpio", "vcd" =>
"application/x-cdlink", "pgn" => "application/x-chess-pgn", "cpio" =>
"application/x-cpio", "csh" => "text/x-csh", "deb" =>
"application/x-debian-package", "dcr" => "application/x-director", "dir"
=> "application/x-director", "dxr" => "application/x-director", "wad" =>
"application/x-doom", "dms" => "application/x-dms", "dvi" =>
"application/x-dvi", "pfa" => "application/x-font", "pfb" =>
"application/x-font", "gsf" => "application/x-font", "pcf" =>
"application/x-font", "gnumeric" => "application/x-gnumeric", "gtar" =>
"application/x-gtar", "tgz" => "application/x-gtar", "taz" =>
"application/x-gtar", "hdf" => "application/x-hdf", "phtml" =>
"application/x-httpd-php", "pht" => "application/x-httpd-php", "php" =>
"application/x-httpd-php", "phps" => "application/x-httpd-php-source",
"php3" => "application/x-httpd-php3", "php3p" =>
"application/x-httpd-php3-preprocessed", "php4" =>
"application/x-httpd-php4", "ica" => "application/x-ica", "jar" =>
"application/x-java-archive", "jnlp" => "application/x-java-jnlp-file",
"ser" => "application/x-java-serialized-object", "class" =>
"application/x-java-vm", "js" => "application/x-javascript", "chrt" =>
"application/x-kchart", "kil" => "application/x-killustrator", "kpr" =>
"application/x-kpresenter", "kpt" => "application/x-kpresenter", "skp" =>
"application/x-koan", "skd" => "application/x-koan", "skt" =>
"application/x-koan", "skm" => "application/x-koan", "ksp" =>
"application/x-kspread", "kwd" => "application/x-kword", "kwt" =>
"application/x-kword", "latex" => "application/x-latex", "lha" =>
"application/x-lha", "lzh" => "application/x-lzh", "lzx" =>
"application/x-lzx", "frm" => "application/x-maker", "maker" =>
"application/x-maker", "frame" => "application/x-maker", "fm" =>
"application/x-maker", "fb" => "application/x-maker", "book" =>
"application/x-maker", "fbdoc" => "application/x-maker", "com" =>
"application/x-msdos-program", "exe" => "application/x-msdos-program",
"bat" => "application/x-msdos-program", "dll" =>
"application/x-msdos-program", "msi" => "application/x-msi", "nc" =>
"application/x-netcdf", "cdf" => "application/x-netcdf", "pac" =>
"application/x-ns-proxy-autoconfig", "o" => "application/x-object", "ogg"
=> "application/x-ogg", "oza" => "application/x-oz-application", "pl" =>
"application/x-perl", "pm" => "application/x-perl", "crl" =>
"application/x-pkcs7-crl", "rpm" => "audio/x-pn-realaudio-plugin", "shar"
=> "application/x-shar", "swf" => "application/x-shockwave-flash", "swfl"
=> "application/x-shockwave-flash", "sh" => "text/x-sh", "sit" =>
"application/x-stuffit", "sv4cpio" => "application/x-sv4cpio", "sv4crc"
=> "application/x-sv4crc", "tar" => "application/x-tar", "tcl" =>
"text/x-tcl", "tex" => "text/x-tex", "gf" => "application/x-tex-gf", "pk"
=> "application/x-tex-pk", "texinfo" => "application/x-texinfo", "texi"
=> "application/x-texinfo", "old" => "bak", "sik" => "bak", "t" =>
"application/x-troff", "tr" => "application/x-troff", "roff" =>
"application/x-troff", "man" => "application/x-troff-man", "me" =>
"application/x-troff-me", "ms" => "application/x-troff-ms", "ustar" =>
"application/x-ustar", "src" => "application/x-wais-source", "wz" =>
"application/x-wingz", "crt" => "application/x-x509-ca-cert", "fig" =>
"application/x-xfig", "au" => "audio/basic", "snd" => "audio/basic",
"mid" => "audio/midi", "midi" => "audio/midi", "kar" => "audio/midi",
"mpga" => "audio/mpeg", "mpega" => "audio/mpeg", "mp2" => "audio/mpeg",
"mp3" => "audio/mpeg", "m3u" => "audio/x-mpegurl", "sid" =>
"audio/prs.sid", "aif" => "audio/x-aiff", "aiff" => "audio/x-aiff",
"aifc" => "audio/x-aiff", "gsm" => "audio/x-gsm", "ra" =>
"audio/x-realaudio", "rm" => "audio/x-pn-realaudio", "ram" =>
"audio/x-pn-realaudio", "pls" => "audio/x-scpls", "wav" => "audio/x-wav",
"pdb" => "chemical/x-pdb", "xyz" => "chemical/x-xyz", "bmp" =>
"image/x-ms-bmp", "gif" => "image/gif", "ief" => "image/ief", "jpeg" =>
"image/jpeg", "jpg" => "image/jpeg", "jpe" => "image/jpeg", "pcx" =>
"image/pcx", "png" => "image/png", "svg" => "xml", "svgz" => "xml",
"tiff" => "image/tiff", "tif" => "image/tiff", "wbmp" =>
"image/vnd.wap.wbmp", "ras" => "image/x-cmu-raster", "cdr" =>
"image/x-coreldraw", "pat" => "image/x-coreldrawpattern", "cdt" =>
"image/x-coreldrawtemplate", "djvu" => "image/x-djvu", "djv" =>
"image/x-djvu", "jng" => "image/x-jng", "pnm" =>
"image/x-portable-anymap", "pbm" => "image/x-portable-bitmap", "pgm" =>
"image/x-portable-graymap", "ppm" => "image/x-portable-pixmap", "rgb" =>
"image/x-rgb", "xbm" => "image/x-xbitmap", "xpm" => "image/x-xpixmap",
"xwd" => "image/x-xwindowdump", "igs" => "model/iges", "iges" =>
"model/iges", "msh" => "model/mesh", "mesh" => "model/mesh", "silo" =>
"model/mesh", "wrl" => "x-world/x-vrml", "vrml" => "x-world/x-vrml",
"csv" => "text/comma-separated-values", "css" => "text/css", "htm" =>
"text/html", "html" => "text/html", "xhtml" => "text/html", "mml" =>
"text/mathml", "asc" => "text/plain", "txt" => "text/plain", "text" =>
"text/plain", "diff" => "text/plain", "rtx" => "text/richtext", "tsv" =>
"text/tab-separated-values", "wml" => "text/vnd.wap.wml", "wmls" =>
"text/vnd.wap.wmlscript", "xml" => "text/xml", "xsl" => "text/xml", "h"
=> "text/x-chdr", "c" => "text/x-csrc", "java" => "text/x-java", "moc" =>
"text/x-moc", "p" => "text/x-pascal", "pas" => "text/x-pascal", "etx" =>
"text/x-setext", "tk" => "text/x-tcl", "ltx" => "text/x-tex", "sty" =>
"text/x-tex", "cls" => "text/x-tex", "vcs" => "text/x-vcalendar", "vcf"
=> "text/x-vcard", "dl" => "video/dl", "fli" => "video/fli", "gl" =>
"video/gl", "mpeg" => "video/mpeg", "mpg" => "video/mpeg", "mpe" =>
"video/mpeg", "qt" => "video/quicktime", "mov" => "video/quicktime",
"mxu" => "video/vnd.mpegurl", "mng" => "video/x-mng", "asf" =>
"video/x-ms-asf", "asx" => "video/x-ms-asf", "avi" => "video/x-msvideo",
"movie" => "video/x-sgi-movie", "ice" => "x-conference/x-cooltalk", "vrm"
=> "x-world/x-vrml",
);
#-- helps ---------------------------------------------------------- init ---
define("FSTAT_SIZE", 7);
define("FSTAT_DATE", 9);
#-- determine sort criteria
($sortby = $_REQUEST["sortby"])
or ($sortby = $_REQUEST["sort"]);
switch ($sortby) {
case "unsorted":
$sortby = "nothing";
break;
case "date":
$sortby = FSTAT_DATE;
break;
case "size":
$sortby = FSTAT_SIZE;
break;
case "file":
case "name":
$sortby = "filename";
break;
default:
$sortby = "filename";
}
#-- determine current dir
$dir_name = preg_replace('#[^/]+$#', '', strtok($_SERVER["REQUEST_URI"],"?"));
($current_dir = realpath($_SERVER["DOCUMENT_ROOT"].$dir_name))
or
($current_dir = ".");
if (!is_dir($current_dir)) {
$current_dir = dirname($current_dir);
}
if (isset($_REQUEST["preview"])) {
fb2i_preview();
}
#-- read in directory ---------------------------------------------- read ---
$files = array();
$sorted_files = array();
$sorted_dirs = array();
$dir_size = 0;
$total_files = 0;
if (SHORT_DIRNAME) {
$dir_name = basename($dir_name) . "/";
}
$dh = opendir($current_dir);
while ($fn = readdir($dh)) {
if ((EXCLUDE_DOTFILES && ($fn[0] == ".") && ($fn != "..")) || in_array($fn, $exclude)) {
continue;
}
#-- file infos
$stat = stat("$current_dir/$fn");
$stat["filename"] = SORT_NOCASE ? strtolower($fn) : $fn;
$stat["title"] = $fn;
if ($fn == "..") {
$stat["title"] = "Parent Directory";
}
#-- misc
if (! ($stat["is_dir"] = is_dir("$current_dir/$fn")) ) {
$dir_size += $stat[FSTAT_SIZE];
$total_files += 1;
}
#-- mime type -> icon
$stat["alt"] = "misc";
if (!($stat["icon"] = $icons[$fn])) {
if ($stat["is_dir"]) {
$stat["icon"] = $icons["directory"];
$stat["alt"] = "/";
}
else {
$stat["icon"] = $icons["default"];
}
$add_ext = array();
if (is_link("$current_dir/$fn")) {
$add_ext[] = "symlink";
}
if (is_executable("$current_dir/$fn")) {
$add_ext[] = "executable";
}
strtok($fn, ".");
$loop = 11;
while ($loop--) {
$t = $alt = $extension = "";
($t = array_pop($add_ext))
or
($extension = strtok("."))
and
( ($t = $mime[strtolower($extension)]) or ($t = ".$extension") );
if ($t) {
$stat["mime"] = $t;
#-- icon
$alt = "";
($stat["is_dir"] and ($stat["icon"] = $icons["directory"]))
or ($stat["icon"] = $icons[$fn])
or ($stat["icon"] = $icons[$t]) and ($alt = $t)
or ($stat["icon"] = $icons[$extension]) and ($alt = "$extension")
or ($stat["icon"] = $icons[$alt = strtok($t,"/")])
or ($stat["icon"] = $icons["$alt/"])
or ($stat["icon"] = $icons["$alt/*"])
or ($stat["icon"] = $icons[$alt = strtok("/")])
or ($stat["icon"] = $icons["/$alt"])
or ($stat["icon"] = $icons["*/$alt"])
or ($stat["icon"] = $icons["default"]);
if ($alt) {
$stat["alt"] = $alt;
}
}
}
}
#-- add to dirlist
$files[$fn] = $stat;
#-- add to sort hash
$sv = ($fn != "..") ? $stat[$sortby] : "\001";
if (MIX_DIRS_AND_FILES || !$stat["is_dir"]) {
$sorted_files[$fn] = $sv;
}
else {
$sorted_dirs[$fn] = $sv;
}
}
closedir($dh);
#-- sort dir
if ($_REQUEST["reverse"] || ($_REQUEST["order"]="desc")) {
if (SORT_FILES) asort($sorted_files);
if (SORT_DIRECTORIES) natsort($sorted_dirs);
}
else {
if (SORT_FILES) arsort($sorted_files);
if (SORT_DIRECTORIES) arsort($sorted_dirs);
}
#-- generate page ------------------------------------------------- print ---
$html_dirs = "";
$html_files = "";
$col = 0;
foreach (array_merge($sorted_dirs, $sorted_files) as $fn => $uu) {
if (!$col) {
$html_files .= "\n<tr>\n";
}
$stat = $files[$fn];
$d_date = date("d-M-Y H:i:s", $stat[FSTAT_DATE]);
$d_size = ($stat[FSTAT_SIZE]);
$d_desc = "";
#-- dirs
if ($stat["is_dir"]) {
$fn .= "/";
$html_dirs .= '<div align="left">'
. '<a href="' . $fn . '" class="dl_link">'
. '<img src="' . $stat["icon"]
. '" border="0" width="16" height="16" '
. 'title="date: ' . $d_date
. ' - size: ' . $d_size
. ' - desc: &quot;' . $d_desc . '&quot;">'
. $stat["title"] . "</a>"
. "</div>\n";
}
#-- files & dirs
if ($stat) {
$html_files .=
'<td align="center" valign="top" height="70" width="20%">'
. '<a href="' . $fn . '" class="f_link"'
. (PREVIEW ? ' onMouseOver="show_prev(event,\''.rawurlencode($fn).'\')" onMouseOut="hide_prev()"' : "")
. '>'
. '<img src="' . $stat["icon"] . '" border="0"'
. ' title="date: ' . $d_date
. ' - size: ' . $d_size
. ' - desc: &quot;' . $d_desc . '&quot;"'
. ' width="32" height="32"'
. ' alt="' . $stat["alt"] . '">'
. "<br>"
. $stat["title"] . "</a>"
. "<br>"
. ($stat["is_dir"] ? "<small><br></small>" :"<small><small>$d_size octets</small></small><br>")
. "</td>\n";
}
#-- close row
$col = ($col + 1) % LIST_COLS;
if (!$col) {
$html_files .= "</tr>";
}
}
#-- empty cells
if ($col) {
while ($col++ < LIST_COLS) {
$html_files .= "<td>&nbsp;</td>\n";
}
$html_files .= "</tr>\n";
}
#-- preview stuff --------------------------------------------------- prv ---
function fb2i_preview() {
global $mime, $current_dir;
#-- read file, guess type (text or image)
if (($file = $_REQUEST["preview"]) && is_readable($file="$current_dir/$file")) {
$m = "";
foreach (explode(".", $file) as $ext) {
if ($uu = $mime[$ext]) {
$m = strtok($uu, "/");
}
}
switch ($m) {
case "image":
preview_thumb($file) || ($file = "");
break;
case "text":
preview_text($file) || ($file = "");
break;
default:
$file = "";
}
}
elseif ($file) {
header("Location: http://" . $_SERVER["SERVER_NAME"] . strtok($_SERVER["REQUEST_URI"], "?") . "?preview=");
$file = false;
}
if (empty($file)) {
data("data:image/png,%89PNG%0D%0A%1A%0A%00%00%00%0DIHDR%00%00%00%28%00%00%00%15%04%03%00%00%00%C64%B1-%00%00%00%0FPLTEB%06%16N%1F3Z6JjNf%8D%90%B4%E6%2F%DE%BA%00%00%00%01bKGD%04%8Fh%D9Q%00%00%00uIDATx%DA%A5%D0%D1%0D%80+%0C%04Pb%99%00%17+%C8%00J%3B%00%91%DB%7F%26%A9%98h%94%0F%8D%FC%5Cx%B9%A6%04%83%CE1%9F%B1%B0%B0%DC1%07r%EE%81%A0%98%DE%E2s%BC%A0%B3%E8%E3%E3%CB%89%CC%85%C1%22J-%2A%0E%7E%09%C9%8D6%23%AD%7B%28%DA%9C%A0%B7%A9%A1%3F%9A%15Y%06%A9X%C3%ECH%AC%CDH%D0f%A4%B9%8D%A3m%C0u%D1%9F%9F%DF%00N%90d%1C%96%7Bk%AE%00%00%00%00IEND%AEB%60%82");
}
die();
}
function data($URI) {
if (strtok($URI, ":") == "data") {
list($type, $enc) = explode(";", strtok(","));
header("Content-Type: $type");
header("Content-Disposition: inline; filename=\"" . strtr($type, "/", ".") . "\"");
if ($enc=="base64") {
echo base64_decode(strtok("\377"));
}
else {
echo urldecode(strtok("\377"));
}
}
}
function preview_thumb($filename) {
if (DIRECTORY_SEPARATOR != "/") { return(false); }
#-- check for image
$inf = getimagensize($filename);
switch ($inf[2]) {
case 1: $type = "gif"; break;
case 2: $type = "jpeg"; break;
case 3: $type = "png"; break;
default: return(false);
}
#-- rescale
if ($inf[0] > PREVIEW_MAXWIDTH) {
if (function_exists($pf = "imagecreatefrom$type")) {
$orig_image = $pf($filename);
$orig_x = imagensx($orig_image);
$orig_y = imagensy($orig_image);
if ($type == "gif") { $type = "png"; }
if ($r = PREVIEW_MAXWIDTH / ($orig_x+1)) {
#-- new gd image
$new_x = $orig_x * $r;
$new_y = $orig_y * $r;
$truecolor = function_exists("imageistruecolor") && imageistruecolor($orig_image);
if (!$truecolor || ($type == "gif")) {
$new_image = imagecreate($new_x, $new_y);
imagepalettecopy($new_image, $orig_image);
}
else {
$new_image = imagecreatetruecolor($new_x, $new_y);
}
#-- make thumbnail
imagecopyresized($new_image, $orig_image, 0,0, 0,0, $new_x,$new_y, $orig_x,$orig_y);
imagedestroy($orig_image);
#-- output result
if (function_exists($pf = "image$type")) {
$pf($new_image) && ($ok = 1);
header("Content-Type: image/$type");
}
}
}
else {
return(false); // gd-lib does not support that format
}
}
else {
header("Content-Type: image/$type");
readfile($filename);
}
return($true);
}
function preview_text($filename) {
$text = file($filename);
$DESTX = PREVIEW_MAXWIDTH;
$DESTY = (int)($DESTX * 3 / 4);
$im = imagecreate($DESTX, $DESTY);
$fg = imagecolorallocate($im, 0x20, 0x00, 0x00);
$bg = imagecolorallocate($im, 0xDF, 0xDF, 0xFF);
$font = 1;
imagefill($im, 0,0, $bg);
$font_H = imagefontheight($font);
$line_len = 1 + (int)($DESTX / imagefontwidth($font));
$y = 1;
while (($y < $DESTY) && ($line = array_shift($text))) {
$line = substr(trim($line), 0, $line_len);
imagenstring($im, 0, 1, $y, $line, $fg);
$y += 1 + $font_H;
}
header("Content-Type: image/png");
imagepng($im);
return(true);
}
#-- template -------------------------------------------------------- end ---
include("../../mainfile.php");
include(XOOPS_ROOT_PATH."/header.php");
$xoopsOption['show_rblock'] = 1; // 1 = Avec blocs de droite - 0 = Sans blocs de droite
?>
<html>
<head>
<title>Index of <?php echo "$dir_name"; ?></title>
<style type="text/css">
<!--
body, table, td, a {
font-family: "Arial", "Verdana", sans-serif;
}
h3, h2 {
font-family: "Verdana", "Arial", sans-serif;
font-size: 13pt;
font-weight: 500;
}
a, a:hover {
color: #000000;
font-family: "Arial", "Verdana", sans-serif;
text-decoration: underline;
}
.f_link {
text-decoration: none;
font-size: 12px;
}
.dl_link {
font-size: 12px;
}
a:hover {
background-color: #ccccff;
}
a.f_link:hover img {
width:30px;
height:30px;
padding:1px;
background-color: #ffffff;
}
-->
</style>
<?php ######
if (PREVIEW) {
echo<<<END
<script type="text/javascript">
<!--
var prev = null;
function show_prev(e,file)
{
prev = document.getElementById('prev');
if ((prev) && (prev.style.visibility == "hidden"))
{
prev.src = "?preview=" + file;
if (e.pageX) {
prev.style.left = (pageXOffset + e.clientX + 10) + "px";
prev.style.top = (pageYOffset + e.clientY - 10) + "px";
} else {
prev.style.left = (document.body.scrollLeft + e.x + 10) + "px";
prev.style.top = (document.body.scrollTop + e.y - 10) + "px";
}
prev.style.visibility = "visible";
}
}
function hide_prev()
{
if (prev) {
prev.style.visibility = "hidden";
}
}
-->
</script>
END
;
}#-- if(PREVIEW)
###### ?>
</head>
<body bgcolor="#ffffff" text="#000000">
<h3>Index of <?php echo "$dir_name"; ?></h3>
<hr noshade style="height:1px">
<table align="center" width="99%" cellspacing="0" cellpadding="0" border="0">
<tr>
<td align="left">
<small><b><?php echo $dir_size; ?></b> bytes in <b><?php 0+$total_files; ?></b> files</small>
</td>
<td align="right">
<small><small>Sort by <a href="?sort=name" class="dl_link">name</a> | <a href="?sort=date" class="dl_link">date</a> | <a href="?sort=size" class="dl_link">size</a></small></small>
</td>
</tr>
</table>
<hr noshade style="height:1px">
<table width="99%" cellspacing="3">
<tr valign="top">
<td align="left" width="15%">
<?php ###
#-- print left side (directories)
echo($html_dirs);
if (PREVIEW) {
echo '
<br><br>
<img id="prev" style="border:1px ridge #333337; visibility:hidden;position:absolute;" src="?preview=" alt="">
';
}
### ?>
</td>
<td width="85%">
<table cellspacing="2" cellpadding="2" width="100%">
<?php ###
#-- print right side (files and dirs)
echo($html_files);
### ?>
</table>
</td>
</tr></table>
<hr noshade style="height:1px">
<?php
include(XOOPS_ROOT_PATH."/footer.php");
?>
</body>
</HTML>