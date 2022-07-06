<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
#[ApiResource(
    collectionOperations:[
        "catlogue"=>[
            "method"=>"GET",
            "path"=>"/catalogues",
        ]
        ],
        itemOperations:[]
)]

class Catalogue
{
   
}
