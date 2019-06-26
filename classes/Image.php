<?php


class Image
{
    const BASE_PATH = './';

    const IMAGES_DIRECTORY_TITLE = 'images/';

    public function getListOfImages() : array
    {
        $files = array_diff(scandir(self::BASE_PATH . self::IMAGES_DIRECTORY_TITLE), ['..', '.']);

        return $files;
    }

    public function getRandomImageWithPath() : string
    {
        return self::BASE_PATH . self::IMAGES_DIRECTORY_TITLE . $this->getListOfImages()[array_rand($this->getListOfImages())];
    }

    public function getContent() : string
    {
        $filename = self::getRandomImageWithPath();

        $handle = fopen($filename, "rb");

        $contents = fread($handle, filesize($filename));

        fclose($handle);

        return $contents;
    }
}