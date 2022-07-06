<?php 

namespace App\DataProvider;


use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

 class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(MenuRepository $menuRepository , BurgerRepository $burgerRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->burgerRepository = $burgerRepository;
    }
   

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $catalogue=[];
        $catalogue['menu']=$this->menuRepository->findAll();
        $catalogue['burger']=$this->burgerRepository->findAll();


        // $context['menu']=$this->menuRepository->findAll();
        // $context['menu']=$this->BurgerRepository->findAll();
        return $catalogue;

    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Catalogue::class ;
    }
}