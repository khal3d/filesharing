<?php

namespace App\Controller;

use App\Form\UploadType;
use App\Service\UploadService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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
        $form = $this->createForm(UploadType::class, null, [
            'action' => $this->generateUrl('file-upload')
        ]);

        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Method("POST")
     * @Route("/", name="file-upload")
     * @param SessionInterface $session
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function uploadPost(SessionInterface $session, Request $request, Packages $assetPackage)
    {
        $form = $this->createForm(UploadType::class, null, [
            'action' => $this->generateUrl('file-upload')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $upload = new UploadService($session, $this->getParameter('public_directory'));

            try {
                $file = $upload->store($request->files->get('file'));

                return $this->json([
                    'file' => $request->getUriForPath($file['publicFileURI']),
                    'dir' => $request->getUriForPath($file['publicDir'].'/'),
                ]);
            } catch (IOExceptionInterface $exception) {
                return $this->json([
                    'errorMsg' => $exception->getMessage(),
                ]);
            }
        }

        return $this->json([
            'errorMsg' => 'Error'
        ]);
    }
}
