<?php
// src/Controller/RegionController.php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Region;

class RegionController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        $product = $doctrine->getRepository(Region::class)->findAll();
        return $product;
    }
}