<?php
    header('Content-Type:application/json');
    $dir = "../acticle/";
    if (is_dir($dir)) {
        $arr = scandir($dir);
    }
    $arrlength = count($arr);

    $res = [];
    for ($x = 0; $x < $arrlength; $x++) {
        if (preg_match("/.+\.txt/", $arr[$x])) {
            $filename = $arr[$x]; 
            $filename = str_replace(strrchr($filename, ".txt"),"",$filename);
            $result = array("title"=>$filename, "id"=>$x);
            array_push($res, $result);
        }
    }
    echo json_encode($res, JSON_UNESCAPED_UNICODE);
?>
