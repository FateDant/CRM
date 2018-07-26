<?php
namespace lib;
use think\Session;

/**
 * Class Captcha
 */
class Captcha {
    //成员属性
    private $width = 100;   //画布的宽度
    private $height = 30;   //画布的高度
    private $number = 4;    //验证码的字符个数
    private $font_file = 'HWHPZT.ttf';  //验证码的字体文件
    private $font_size = 20;    //验证码的字体大小

    public function __set($p, $v) {
        if (property_exists($this, $p)) {
            $this->$p = $v;
        }
    }

    public function __get($p) {
        if (property_exists($this, $p)) {
            return $this->$p;
        }
    }

    //生成随机的字符
    public function makeCode() {
        //大写字母
        $upper = range('A', 'Z');
        //小写字母
        $lower = range('a', 'z');
        //数字
        $number = range(3, 9);
        //把3个数组合并成一个数组
        $code = array_merge($lower, $upper, $number);
        //打乱数组合并成一个数组
        shuffle($code);
        //根据属性中指定的字符个数，创建字符
        $str = '';
        for ($i = 0; $i < $this->number; $i++) {
            $str .= $code[$i];
        }
        return $str;
    }

    //开始绘制验证码
    public function makeImage() {
        //1.创建画布，背景颜色随机产生
        $image = imagecreatetruecolor($this->width, $this->height);
        //2.分配颜色
        $color = imagecolorallocate($image, mt_rand(100, 255), mt_rand(100, 255), mt_rand(100, 255));
        imagefill($image, 0, 0, $color);
        //3.开始绘制文字
        $code = $this->makecode();
        //将验证码保存到session中
        Session::set('code',$code);
        for ($i = 0; $i < strlen($code); $i++) {
            imagettftext($image, $this->font_size, mt_rand(-30, 30), ($this->width / $this->number) * $i + 5, 20, mt_rand(0, 100), $this->font_file, $code[$i]);
        }
        //4.绘制100个干扰像素点
        for($i = 0;$i<100;$i++){
            imagesetpixel($image,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,100));
        }
        //5.输出到浏览器
        header("Content-Type:image/png");
        imagepng($image);
        //6.销毁图像资源
        imagedestroy($image);
    }
}
?>