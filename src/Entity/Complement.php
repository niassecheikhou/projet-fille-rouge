<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    collectionOperations:[
        "complement"=>[
            "method"=>"GET",
            "path"=>"/complements",
            'normalization_context' => ['groups' => ['complement:red:simple']],

        ]

        
        ],
        itemOperations:[]
)]
class Complement 
{
   

   

   

    
    
}
