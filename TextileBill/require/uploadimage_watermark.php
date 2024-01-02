<?php

function Imageupload($fileName, $Size, $maxW, $fullPath, $relPath, $colorR, $colorG, $colorB, $maxH, $file, $tmpname) {
    $WaterMarkText = "https://www.nbaysmart.com/";
    $folder = $relPath;
    //$maxlimit = $maxSize;
    $allowed_ext = "jpg,jpeg,gif,png,bmp";
    $match = "";

    if ($Size > 0) {
        $filename = strtolower($fileName);
        $filename = preg_replace('/\s/', '_', $filename);
        if ($Size < 1) {
            $errorList[] = "File size is empty.";
        }
        /* if($filesize > $maxlimit){ 
          $errorList[] = "File size is too big.";
          } */
        if (count($errorList) < 1) {
            $file_ext = preg_split("/\./", $filename);
            $allowed_ext = preg_split("/\,/", $allowed_ext);
            foreach ($allowed_ext as $ext) {
                if ($ext == end($file_ext)) {
                    $match = "1"; // File is allowed
                    $NUM = time();
                    $front_name = substr($file_ext[0], 0, 15);
                    $newfilename = $file . "." . end($file_ext);
                    $filetype = end($file_ext);
                    $save = $folder . $newfilename;
                    if (!file_exists($save)) {
                        list($width_orig, $height_orig) = getimagesize($tmpname);
                        $width_orig . "-" . $height_orig;
                        if ($maxH == null) {
                            if ($width_orig < $maxW) {
                                $fwidth = $width_orig;
                            } else {
                                $fwidth = $maxW;
                            }
                            $ratio_orig = $width_orig / $height_orig;
                            $fheight = $fwidth / $ratio_orig;

                            $blank_height = $fheight;
                            $top_offset = 0;
                        } else {
                            if ($width_orig <= $maxW && $height_orig <= $maxH) {
                                $fheight = $height_orig;
                                $fwidth = $width_orig;
                            } else {
                                if ($width_orig > $maxW) {
                                    $ratio = ($width_orig / $maxW);
                                    $fwidth = $maxW;
                                    $fheight = ($height_orig / $ratio);
                                    if ($fheight > $maxH) {
                                        $ratio = ($fheight / $maxH);
                                        $fheight = $maxH;
                                        $fwidth = ($fwidth / $ratio);
                                    }
                                }
                                if ($height_orig > $maxH) {
                                    $ratio = ($height_orig / $maxH);
                                    $fheight = $maxH;
                                    $fwidth = ($width_orig / $ratio);
                                    if ($fwidth > $maxW) {
                                        $ratio = ($fwidth / $maxW);
                                        $fwidth = $maxW;
                                        $fheight = ($fheight / $ratio);
                                    }
                                }
                            }
                            if ($fheight == 0 || $fwidth == 0 || $height_orig == 0 || $width_orig == 0) {
                                die("FATAL ERROR REPORT ERROR CODE [add-pic-line-67-orig] to <a href='http://www.atwebresults.com'>AT WEB RESULTS</a>");
                            }
                            if ($fheight < 45) {
                                $blank_height = 45;
                                $top_offset = round(($blank_height - $fheight) / 2);
                            } else {
                                $blank_height = $fheight;
                            }
                        }
                        $imaall_p = imagecreatetruecolor($fwidth, $blank_height);
                        $white = imagecolorallocate($imaall_p, $colorR, $colorG, $colorB);
                        imagefill($imaall_p, 0, 0, $white);
                        switch ($filetype) {
                            case "gif":
                                $image = @imagecreatefromgif($tmpname);
                                break;
                            case "jpg":
                                $image = @imagecreatefromjpeg($tmpname);
                                break;
                            case "jpeg":
                                $image = @imagecreatefromjpeg($tmpname);
                                break;
                            case "png":
                                $image = @imagecreatefrompng($tmpname);
                                break;
                        }
                        @imagecopyresampled($imaall_p, $image, 0, $top_offset, 0, 0, $fwidth, $fheight, $width_orig, $height_orig);
                        $black = imagecolorallocatealpha($imaall_p, 158, 155, 159, 70);
                        $font = '../monofont.ttf';
                        $font_size = 15;
                        imagettftext($imaall_p, $font_size, 0, 10, 90, $black, $font, $WaterMarkText);

                        switch ($filetype) {
                            case "gif":
                                if (!@imagegif($imaall_p, $save)) {
                                    $errorList[] = "PERMISSION DENIED [GIF]";
                                }
                                break;
                            case "jpg":
                                if (!@imagejpeg($imaall_p, $save, 100)) {
                                    $errorList[] = "PERMISSION DENIED [JPG]";
                                }
                                break;
                            case "jpeg":
                                if (!@imagejpeg($imaall_p, $save, 100)) {
                                    $errorList[] = "PERMISSION DENIED [JPEG]";
                                }
                                break;
                            case "png":
                                if (!@imagepng($imaall_p, $save, 0)) {
                                    $errorList[] = "PERMISSION DENIED [PNG]";
                                }
                                break;
                        }
                        @imagedestroy($filename);
                    } else {
                        $errorList[] = "CANNOT MAKE IMAGE IT ALREADY EXISTS";
                    }
                }
            }
        }
    } else {
        $errorList[] = "NO FILE SELECTED";
    }
    if (!$match) {
        $errorList[] = "File type isn't allowed: $filename";
    }
    if (sizeof($errorList) == 0) {
        return $fullPath . $newfilename;
    } else {
        $eMessage = array();
        for ($x = 0; $x < sizeof($errorList); $x++) {
            $eMessage[] = $errorList[$x];
        }
        return $eMessage;
    }
}

function watermark($fileName, $Size, $maxW, $fullPath, $relPath, $colorR, $colorG, $colorB, $maxH, $file, $tmpname) {
    
}

?>