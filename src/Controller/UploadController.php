<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UploadController extends Controller
{
    /**
     * @Method("GET")
     * @Route("/", name="homepage")
     * @Template()
     */
    public function index()
    {
        return [];
    }

    /**
     * @Method("POST")
     * @Route("/", name="file-upload")
     */
    public function uploadPost()
    {
        $uploadDirectory = $this->get('kernel')->getProjectDir() . '/public/uploads/yo-'.mt_rand();
        $fileSystem = new Filesystem();

        try {
            $fileSystem->mkdir($uploadDirectory);
        } catch (IOExceptionInterface $exception) {
            return $this->json([
                'errorMsg' => $exception->getMessage(),
            ]);
        }

        return $this->json([
            'uploadDir' => $uploadDirectory,
        ]);
    }
}
