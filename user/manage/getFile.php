<?php
    define('BASE_PATH',str_replace('\\','/',realpath(dirname(__FILE__).'/'))."/");  // 获取根目录
    $dir = BASE_PATH . "acticle/";
    if (is_dir($dir)) {
        $arr = scandir($dir);
    }
    $arrlength = count($arr);

    for ($x = 0; $x < $arrlength; $x++) {
        if (preg_match("/.+\.txt/", $arr[$x])) {
            $filename = $arr[$x]; 
            $filename = str_replace(strrchr($filename, ".txt"),"",$filename);
            $res .= '<label style="cursor: pointer;"><input name="Acticle" type="radio" value="' . $filename . '">' . $filename . '</label>';
        }
    }
    echo $res;
?>
