<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UploadService
{
    protected $fileSystem;
    protected $session;
    private $uploadDir;

    public function __construct(SessionInterface $session, $uploadDir)
    {
        $this->fileSystem = new Filesystem();
        $this->uploadDir = $uploadDir;
        $this->session = $session;
    }

    /**
     * @return string
     */
    public function createSessionDirectory()
    {
        if( ! $this->session->get('user_dir') ) {
            $this->session->set('user_dir', mt_rand(10000000000, 999999999999));
        }

        $this->fileSystem->mkdir($this->getUploadDestination());

        return $this->getUploadDestination();
    }

    /**
     * @return bool|string
     */
    protected function getUploadDestination()
    {
        return realpath(realpath($this->uploadDir) . '/uploads/'. $this->session->get('user_dir'));
    }

    /**
     * @return mixed
     */
    protected function getPublicUploadDestination()
    {
        return str_replace($this->uploadDir,'',$this->getUploadDestination());
    }

    /**
     * @param UploadedFile $file
     * @return array
     */
    public function store(UploadedFile $file)
    {
        $storedFile = $file->move($this->createSessionDirectory(), $file->getClientOriginalName());

        return [
            'realPath' => $storedFile->getRealPath(),
            'publicFileURI' => str_replace($this->uploadDir, '', $storedFile->getRealPath()),
            'publicDir' => $this->getPublicUploadDestination(),
        ];
    }
}
