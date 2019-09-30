<?php

namespace App\Twig;

use App\Entity\user_conversation;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppExtension extends AbstractExtension
{
    public function getName(){
        return 'extensions';
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            // new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getRandomString', [$this, 'randomizeNumber']),
            new TwigFunction('createCaptchaImage', [$this, 'makeCaptcha']),
        ];
    }

    public function randomizeNumber($length = 6)
    {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }

    public function makeCaptcha($length = 6)
    {
    $randomString = $this->randomizeNumber($length);
    header('Content-Type:image/jpeg');
    $image = imagecreatetruecolor(340, 50);
    $color = imagecolorallocate($image, rand(40, 220), rand(40, 220), rand(40, 220)); 
    imagefill($image, 0, 0, $color);
    imagetruecolortopalette($image, false, rand(20,240));
    $textcolor = imagecolorallocate($image, 240,240,240);
    imagestring($image, 8, 145, 15, $randomString, $textcolor);
    imagejpeg($image, $_SERVER["DOCUMENT_ROOT"].'\public\resources\captchaImage.jpeg');    
    imagedestroy($image);
    $_SESSION['captcha'] = $randomString;
    }
}