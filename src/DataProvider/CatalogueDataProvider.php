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
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return  Catalogue::class=== $resourceClass  ;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $catalogue=[];
        $catalogue['menus']=$this->menuRepository->findAll();
        $catalogue['burgers']=$this->burgerRepository->findAll();
        // dd($catalogue);
        return $catalogue;

        // $context['menu']=$this->menuRepository->findAll();
        // $context['menu']=$this->BurgerRepository->findAll();

    }
    
}