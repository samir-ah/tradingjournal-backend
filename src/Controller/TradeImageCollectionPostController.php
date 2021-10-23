<?php

namespace App\Controller;
use App\Entity\Trade;
use App\Entity\TradeImage;
use App\Repository\TradeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

#[AsController]
class TradeImageCollectionPostController extends AbstractController
{
    public function __construct(private KernelInterface $appKernel,private EntityManagerInterface $em,private AuthorizationCheckerInterface $checker,private TradeRepository $tradeRepository)
    {
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function __invoke(Request $request): TradeImage
    {   $tradeId = $request->request->getInt('trade');
        $tradeObject = $this->tradeRepository->findOneBy(['id'=> $tradeId]);

        if ($this->checker->isGranted('ROLE_ADMIN') || $this->checker->isGranted('CAN_EDIT',$tradeObject)) {
            $imageUrl = $request->request->get('imageUrl');
            $uploadedFileForm = $request->files->get('file');

            if (!$uploadedFileForm && !$imageUrl) {
                throw new BadRequestHttpException('"file" is required');
            }

            $tradeImageObject = new TradeImage();
            $tradeImageObject->setTrade($this->em->getReference(Trade::class,$tradeObject->getId()));

            if($uploadedFileForm){ //upload from form
                $tradeImageObject->setFile( $uploadedFileForm) ;
            }
            else{ //upload from external url
                $fileUniqueName = md5(uniqid(rand(), true)) . ".png";
                $filePathName = $this->appKernel->getProjectDir() . '/public/uploads/trades/' . $fileUniqueName;
                copy($imageUrl, $filePathName);
                $mimeType = mime_content_type($filePathName);

                $gdImage = match ($mimeType) {
                    'image/png' => imagecreatefrompng($filePathName),
                    'image/jpeg', 'image/jpg' => imagecreatefromjpeg($filePathName)
                };
                if(!$gdImage){
                    throw new BadRequestHttpException('Cet URL n\'est pas valide');
                }
                $finfo = pathinfo($filePathName);
                $newFilename = $finfo['filename'] . '.jpg';
                $newPathName = $finfo['dirname'] . DIRECTORY_SEPARATOR . $newFilename;
                imagejpeg($gdImage, $newPathName, 75);
                unlink($filePathName);
                $tradeImageObject->setImageFile($newFilename);
            }



            return $tradeImageObject;
        }
        throw new AccessDeniedHttpException('Vous ne pouvez pas uploader une image pour ce trade');
    }

}