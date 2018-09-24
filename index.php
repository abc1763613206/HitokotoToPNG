<?php $counter = intval(file_get_contents("counter.dat")); ?>
<?php 

putenv('GDFONTPATH=' . realpath('.'));
header("Content-type: image/png");

$url="https://v1.hitokoto.cn/"; 
$UserAgent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0; SLCC1; .NET CLR 2.0.50727; .NET CLR 3.0.04506; .NET CLR 3.5.21022; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';  
$curl = curl_init(); 
curl_setopt($curl, CURLOPT_URL, $url); 
curl_setopt($curl, CURLOPT_HEADER, 0);  
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
curl_setopt($curl, CURLOPT_ENCODING, '');  
curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);  
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);  
$data = curl_exec($curl);
$data = json_decode($data, true);
$content = $data['hitokoto'];
$from = $data['from'];
//$unixtime = $data['created_at'];
//$unixtime = (int)$unixtime;
$font = 'msyh.ttf';
$box = imagettfbbox ( 20 , 0 , $font , $content.'   '.$from ); //测量距离
$min_x = min( array($box[0], $box[2], $box[4], $box[6]) ); 
$max_x = max( array($box[0], $box[2], $box[4], $box[6]) ); 
$min_y = min( array($box[1], $box[3], $box[5], $box[7]) ); 
$max_y = max( array($box[1], $box[3], $box[5], $box[7]) ); 
$width = abs($box[4] - $box[0]);
$height = abs($box[5] - $box[1]);
$left   = abs( $min_x ) + $width; 
$top    = abs( $min_y ) + $height; 
//echo $width.','.$height;
$im = imagecreate($width,$height+15);   //建立画布
$black = ImageColorAllocate($im, 0,0,0);//定义黑色的值
$red = ImageColorAllocate($im, 255,0,0);//红色
$blue = ImageColorAllocate($im, 0,0,255);
$skyblue = ImageColorAllocate($im,136,193,255);
$white = ImageColorAllocate($im,255,255,255);

ImageFill($im,0,0,$white);



imagettftext ( $im , 15 , 0 , $min_x+10, $height , $black , $font , $content.'   —— '.$from );
imagepng($im);
imagedestroy($im);
?>
