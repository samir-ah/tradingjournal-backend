<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Event\Event;
use Vich\UploaderBundle\Event\Events;

class ImageUploadSubscriber implements EventSubscriberInterface
{
    public function onVichUploaderPostUpload(Event $event)
    {
        /**
         * @var $uploadedFile UploadedFile
         */
        $uploadedFile = $event->getMapping()->getFile($event->getObject());
//        dump($event->getMapping()->getFile($event->getObject()));
        $gdImage = match ($uploadedFile->getMimeType()) {
            'image/png' => imagecreatefrompng($uploadedFile->getPathname()),
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($uploadedFile->getPathname())
        };
        unlink($uploadedFile->getPathname());
        $finfo = pathinfo($uploadedFile->getFilename());
        $newFilename = $finfo['filename'] . '.jpg';
        $newPathName = $uploadedFile->getPath() . DIRECTORY_SEPARATOR . $finfo['filename'] . '.jpg';
        imagejpeg($gdImage, $newPathName, 75);
        $event->getMapping()->setFileName($event->getObject(), $newFilename);

    }

    public static function getSubscribedEvents()
    {
        return [
            Events::POST_UPLOAD => 'onVichUploaderPostUpload',
        ];
    }
}
