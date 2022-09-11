<?php
    $dir = "../../acticle/";
    if (is_dir($dir)) {
        $arr = scandir($dir);
    }
    $arrlength = count($arr);
    $res = '';

    for ($x = 0; $x < $arrlength; $x++) {
        if (preg_match("/.+\.txt/", $arr[$x])) {
            $filename = $arr[$x]; 
            $filename = str_replace(strrchr($filename, ".txt"),"",$filename);
            $res .= '<label style="cursor: pointer;"><input name="Acticle" type="radio" value="' . $filename . '">' . $filename . '</label>';
        }
    }
    echo $res;
?>
