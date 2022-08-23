<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;

#[ApiResource(
    collectionOperations:[
        // "get"=>[
        //     "status"=>Response:: HTTP_OK
        // ],
        "catalogue"=>[
            "method"=>"GET",
            "path"=>"/catalogues",
            "normalization_context"=> ['groups' => ['catalogues:red:simple']],
            // "force_eager"=> false
        ],
        ],
        itemOperations:[]
)]

class Catalogue
{
   #[ApiProperty(
    identifier:true
     )]
     private $id;
}
