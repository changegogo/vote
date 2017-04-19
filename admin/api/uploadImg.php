<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/19
 * Time: 10:01
 * 200 上传成功
 * 201 图片不存在
 * 202 图片太大
 * 203 同名文件已经存在了
 * 204 移动文件出错
 * 205
 */

header("Access-Control-Allow-Origin: *");
header('Content-type: application/json;charset=UTF-8');
//上传文件类型列表
$uptypes=array(
    'image/jpg',
    'image/jpeg',
    'image/png',
    'image/pjpeg',
    'image/gif',
    'image/bmp',
    'image/x-png'
);
$max_file_size=2000000;     //上传文件大小限制, 单位BYTE
$destination_folder="../../public/votegroup/shunanqikuangshida/votegroupimg/"; //上传文件路径
$destination_folder_abs="/vote/public/votegroup/shunanqikuangshida/votegroupimg/"; //上传文件路径
$watermark=1;      //是否附加水印(1为加水印,其他为不加水印);
$watertype=1;      //水印类型(1为文字,2为图片)
$waterposition=1;     //水印位置(1为左下角,2为右下角,3为左上角,4为右上角,5为居中);
$waterstring="http://www.xplore.cn/";  //水印字符串
$waterimg="xplore.gif";    //水印图片
$imgpreview=1;      //是否生成预览图(1为生成,其他为不生成);
$imgpreviewsize=1/2;    //缩略图比例

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if (!is_uploaded_file($_FILES["upfile"]["tmp_name"]))
        //是否存在文件
    {
        $arr = array("code"=>201,"msg"=>"图片不存在");
        echo json_encode($arr);
        exit;
    }

    $file = $_FILES["upfile"];
    if($max_file_size < $file["size"])
        //检查文件大小
    {
        $arr = array("code"=>202,"msg"=>"图片太大");
        echo json_encode($arr);
        exit;
    }

    if(!in_array($file["type"], $uptypes))
        //检查文件类型
    {
        $arr = array("code"=>202,"msg"=>"文件类型不符".$file["type"]);
        echo json_encode($arr);
        exit;
    }

    if(!file_exists($destination_folder))
    {
        mkdir($destination_folder);
    }

    $filename=$file["tmp_name"];
    $image_size = getimagesize($filename);
    $pinfo=pathinfo($file["name"]);
    $ftype=$pinfo['extension'];
    $destination = $destination_folder.time().".".$ftype;
    if (file_exists($destination) && $overwrite != true)
    {
        $arr = array("code"=>203,"msg"=>"同名文件已经存在了");
        echo json_encode($arr);
        exit;
    }

    if(!move_uploaded_file ($filename, $destination))
    {
        $arr = array("code"=>204,"msg"=>"移动文件出错");
        echo json_encode($arr);
        exit;
    }

    $pinfo=pathinfo($destination);
    $fname=$pinfo["basename"];

    $arr = array("code"=>200,"msg"=>"上传成功","result"=>array("filepath"=>$destination_folder_abs.$fname,"width"=>$image_size[0],"height"=>$image_size[1],"size"=>$file["size"]));
    echo json_encode($arr);
}
?>