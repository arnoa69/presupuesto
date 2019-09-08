<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class AppFixtures extends Fixture
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function load(ObjectManager $manager)
    {
        $category = new Category();        
        $category->setCategoryName('Pintor');
        $category->setParentCategory(0);
        $category->setCategoryPrice(0);
        $this->em->persist($category);
        $this->em->flush();
        $category = new Category();        
        $category->setCategoryName('Pintar Interior De Vivienda');
        $category->setParentCategory((int)$this->em->getConnection()->lastInsertId());
        $category->setCategoryPrice(100);
        $manager->persist($category);
        $category = new Category();        
        $category->setCategoryName('Pintar Exterior Casa');
        $category->setParentCategory((int)$this->em->getConnection()->lastInsertId());
        $category->setCategoryPrice(200);
        $manager->persist($category);
        $category = new Category();        
        $category->setCategoryName('Pintar Interior De Local');
        $category->setParentCategory((int)$this->em->getConnection()->lastInsertId());
        $category->setCategoryPrice(300);
        $manager->persist($category);
        $manager->flush();

        $category = new Category();        
        $category->setCategoryName('Carpinteros');
        $category->setParentCategory(0);
        $category->setCategoryPrice(0);
        $manager->persist($category);
        $manager->flush();        
        $category = new Category();        
        $category->setCategoryName('Carpintera Aluminio');
        $category->setParentCategory((int)$this->em->getConnection()->lastInsertId());
        $category->setCategoryPrice(100);
        $manager->persist($category);
        $category = new Category();        
        $category->setCategoryName('Carpintera Metalica');
        $category->setParentCategory((int)$this->em->getConnection()->lastInsertId());
        $category->setCategoryPrice(200);
        $manager->persist($category);
        $category = new Category();        
        $category->setCategoryName('Carpintera PVC');
        $category->setParentCategory((int)$this->em->getConnection()->lastInsertId());
        $category->setCategoryPrice(300);
        $manager->persist($category);
        $manager->flush();
        
        $category = new Category();        
        $category->setCategoryName('Arquitectos');
        $category->setParentCategory(0);
        $category->setCategoryPrice(0);
        $manager->persist($category);
        $manager->flush();
        $category = new Category();        
        $category->setCategoryName('Proyecto nueva construccion');
        $category->setParentCategory((int)$this->em->getConnection()->lastInsertId());
        $category->setCategoryPrice(100);
        $manager->persist($category);
        $category = new Category();        
        $category->setCategoryName('Proyecto de reforma');
        $category->setParentCategory((int)$this->em->getConnection()->lastInsertId());
        $category->setCategoryPrice(200);
        $manager->persist($category);
        $category = new Category();        
        $category->setCategoryName('Legaliza Vivienda');
        $category->setParentCategory((int)$this->em->getConnection()->lastInsertId());
        $category->setCategoryPrice(300);
        $manager->persist($category);        
        $manager->flush();
    }

}
