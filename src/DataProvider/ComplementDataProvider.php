<?php 
namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\FritteRepository;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function __construct(FritteRepository $fritteRepository , BoissonRepository $boissonRepository)
    {
        $this->fritteRepository = $fritteRepository;
        $this->boissonRepository = $boissonRepository;
    }
   

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        $complement=[];
        $complement['fritte']=$this->fritteRepository->findAll();
        $complement['boisson']=$this->boissonRepository->findAll();


        // $context['menu']=$this->menuRepository->findAll();
        // $context['menu']=$this->BurgerRepository->findAll();
        return $complement;

    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return $resourceClass === Complement::class ;
    }
}