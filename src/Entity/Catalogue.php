<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
#[ApiResource(
    collectionOperations:[
        "catlogue"=>[
            "method"=>"GET",
            "path"=>"/catlogue",
        ]
        ],
        itemOperations:[]
)]

class Catalogue
{
   
}
