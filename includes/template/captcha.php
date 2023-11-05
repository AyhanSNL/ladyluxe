<?Php
session_start();
function random($length){
//create a or array string called chars
    $chars ="abcdefghijklmnopqrstuvwxyz23456789";
    $str = "";
    //is the variable which is equal to the length of the string called chars
    $size = strlen($chars);
    for($i=0; $i<$length; $i++){
        $str .= $chars[rand(0, $size-1)];

    }
    return $str;
}
//the gd image adaptor in xampp
$cap = random(5);
$_SESSION['secure_code'] = $cap;
$image = imagecreate(60, 20);
$background = imagecolorallocate($image, 233, 236, 239);
$foreground = imagecolorallocate($image, 0, 0, 0);
//this is going to write our string in the image
imagestring($image, 5,5,1,$cap,$foreground);
header("Content-type: image/png");
imagepng($image);
?>

