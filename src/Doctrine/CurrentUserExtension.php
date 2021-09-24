<?php


namespace App\Doctrine;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Trade;
use App\Entity\TradeComment;
use App\Entity\TradeImage;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    private const SUPPORTED_ENTITIES = [Trade::class, TradeImage::class, TradeComment::class];

    public function __construct(private Security $security, private EntityManagerInterface $em)
    {
    }

    public function applyToCollection(
        QueryBuilder                $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string                      $resourceClass,
        string                      $operationName = null
    )
    {
        $this->addWhere($resourceClass, $queryBuilder);
    }

    public function applyToItem(
        QueryBuilder                $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string                      $resourceClass,
        array                       $identifiers,
        string                      $operationName = null,
        array                       $context = []
    )
    {
        $this->addWhere($resourceClass, $queryBuilder);
    }

    private function addWhere(string $resourceClass, QueryBuilder $queryBuilder)
    {
//        dd($this->em->createQuery('SELECT o FROM App\Entity\TradeComment o INNER JOIN o.trade t  WHERE o.author = :current_user')
//            ->setParameter('current_user', $this->security->getUser())
//        ->getResult());

        if (in_array($resourceClass, self::SUPPORTED_ENTITIES) && !$this->security->isGranted('ROLE_ADMIN')) {
            $alias = $queryBuilder->getRootAliases()[0];
            $user = $this->security->getUser();
            if ($user) {
                switch ($resourceClass) {
                    case Trade::class:
                        $queryBuilder
                            ->andWhere("$alias.isPublished = 1")
                            ->orWhere("$alias.author = :current_user")
                            ->setParameter('current_user', $this->security->getUser()->getId());
                        break;
                    case TradeImage::class:
                        $queryBuilder
                            ->innerJoin("$alias.trade", 't')
                            ->innerJoin("t.author", 'u')
                            ->andwhere("t.isPublished = 1")
                            ->orWhere("t.author = :current_user")
                            ->setParameter('current_user', $this->security->getUser()->getId());
                        break;
                    case TradeComment::class:
                        $queryBuilder
                            ->innerJoin("$alias.trade", 't')
                            ->where("$alias.author = :current_user")
                            ->orWhere("t.isPublished = 1")
                            ->setParameter('current_user', $this->security->getUser()->getId());
                        break;
//                       dd($this->security->getUser()->getId(),$queryBuilder->getDQL());

                }

            }
        }
    }

}
