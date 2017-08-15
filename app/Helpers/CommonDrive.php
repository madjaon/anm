<?php 
namespace App\Helpers;

class CommonDrive
{
    static function uploadFileToGDrive($imagename, $foldername, $source = null)
    {
        if($source == null) {
            $source = CommonMethod::getDomainSource();
        }

        if(empty($imagename)) {
            return '';
        }
        
        // check & get full image url
        $fileurl = CommonMethod::getFullImageLink($imagename, $source);
        // $fileurl = CommonMethod::getfullurl($imagename, $source);
        
        if($fileurl == '') {
            return '';
        }

        $filename = basename(CommonMethod::removeParameters($fileurl));

        $filename = CommonMethod::changeFileNameImage($filename, 1);

        $dir = self::checkDirGDrive($foldername, '/', false);

        // if (!$dir) {
        //     // create dir
        //     $makeDir = \Storage::cloud()->makeDirectory($foldername);
        //     if($makeDir) {
        //         $dir = self::checkDirGDrive($foldername, '/', false);
        //     }
        // }
        
        // check file ton tai hay chua
        $file = self::checkFileGDrive($filename, $dir['path'], true);

        // if(!$file) {
        //     // put in dir
        //     \Storage::cloud()->put($dir['path'].'/'.$filename, file_get_contents($fileurl));

        //     // get file upload
        //     $file = self::checkFileGDrive($filename, $dir['path'], true);
        // }
                    
        if($file) {
            return $file['basename'];
        }

        return null;
    }

    // $recursive = false; // Get subdirectories also?
    static function checkDirGDrive($name, $dir, $recursive)
    {
        return collect(\Storage::cloud()->listContents($dir, $recursive))
                    ->where('type', 'dir')
                    ->where('filename', $name)
                    ->first(); // There could be duplicate directory names!
    }

    static function checkFileGDrive($name, $dir, $recursive)
    {
        return collect(\Storage::cloud()->listContents($dir, $recursive))
                    ->where('type', 'file')
                    ->where('filename', pathinfo($name, PATHINFO_FILENAME))
                    ->where('extension', pathinfo($name, PATHINFO_EXTENSION))
                    ->sortBy('timestamp')
                    ->last();
    }

    static function getLinkByDriveId($id)
    {
        if(!empty($id)) {
            return 'https://drive.google.com/uc?id=' . $id;;
        } else {
            return '';
        }
    }

}