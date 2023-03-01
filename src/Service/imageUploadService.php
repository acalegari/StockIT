<?php
namespace App\Service;

use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class imageUploadService {

    private $params;

    //retrieve params services.yaml
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function add(UploadedFile $image, ?string $folder = '', ?int $width = 200, ?int $height = 200) {

        $message = 'Format d\'image incorect';
        //change name of the uploaded image randomly  + change extension to webp 
        $fichier = md5(uniqid(rand(), true)). '.webp';

        //retrieve image information: width;height
        $imageInfo = getimagesize($image);

        //check if image has information
        if ($imageInfo === false) {
            throw new Exception($message);
        }

        //check image's format -> mime
        switch ($imageInfo['mime']) {
            case 'image/png': 
                $imageSrc = imagecreatefrompng($image);
                break;
            case 'image/jpeg':
                $imageSrc = imagecreatefromjpeg($image);
                break;
            case 'image/webp':
                $imageSrc = imagecreatefromwebp($image);
                break;
            default:
                throw new Exception($message);
        }

        //Reframe image
        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];

        /* Check image orientation
            1: W inferior to H = -1
            2: W equal to H = 0
            3: W superior to H = 1 */
        switch ($imageWidth <=> $imageHeight) {
            case -1: //portrait
                $squareSize = $imageWidth;
                $src_x = 0; // no change larger
                $src_y = ($imageHeight - $squareSize) / 2; //cut the top and bottom from the height ?? not sure to check
                break;
            case 0: //square
                $squareSize = $imageWidth;
                $src_x = 0; // no change larger
                $src_y = 0; // no change height
                break;
            case 1: //landscape
                $squareSize = $imageHeight;
                $src_x = ($imageHeight - $squareSize) / 2; //cut the top and bottom from the height ?? not sure to check
                $src_y = 0;
                break;
        }

        //Create new image following the resize image perfomed before
        $resizeImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($resizeImage, $imageSrc, 0, 0, $src_x, $src_y, $width, $height, $squareSize, $squareSize);

        //path -> services.yaml
        $path = $this->params->get('images_directory') . $folder;
        $pathDestination = $path.'/resize/';

        //Create path location if !exist
        if(!file_exists($pathDestination)){
            mkdir($pathDestination, 0755, true);
        }

        //Store the reframe image
        imagewebp($resizeImage, $pathDestination.$width.'x'.$height.'-'.$fichier);
        //move image into correct path
        $image->move($path.'/',$fichier);

        return $fichier;
    }

    public function delete(string $fichier, ?string $folder = '', ?int $width = 200, ?int $height = 200) {
        if ($fichier !== 'default.webp') {
            $success = false;
            $path = $this->params->get('images_directory') . $folder;
            $data = $path.'/resize/'.$width.'x'.$height.'-'.$fichier;
            $fichier;

            if(file_exists($data)) {
                unlink($data);
                $success = true;
            }

            $original = $path.'/'.$fichier;
            if(file_exists($original)) {
                unlink($original);
                $success = true;
            }
            return $success;
        }
        return false;
    }
}