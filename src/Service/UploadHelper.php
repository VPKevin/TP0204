<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadHelper
{
    const AD_IMAGE = 'uploads/ads_images';
    const DEFAULT_IMAGE = '';

    private string $publicPath;
    private FilesystemOperator $defaultStorage;

    public function __construct(string $publicPath, FilesystemOperator $defaultStorage)
    {
        $this->publicPath = $publicPath;
        $this->defaultStorage = $defaultStorage;
    }

    /**
     * @throws FilesystemException
     */
    public function uploadAdImage(UploadedFile $file, $existingFilename = null): string
    {
//        $destination = $this->publicPath . '/' . self::AD_IMAGE;
        $originFileName = $file->getClientOriginalName();
        $baseFileName = pathinfo($originFileName, PATHINFO_FILENAME);
        $fileName = Urlizer::urlize($baseFileName). '-' . uniqid() . '.' . $file->guessExtension();
//        $file->move($destination, $fileName);

        if ($existingFilename) {
            $this->defaultStorage->delete(self::AD_IMAGE . '/' . $existingFilename);
        }

        $stream = fopen($file->getPathname(), 'r');
        $this->defaultStorage->writeStream(
            self::AD_IMAGE . '/' . $fileName,
            $stream
        );
        if (is_resource($stream)) {
            fclose($stream);
        }

        return $fileName;
    }
}