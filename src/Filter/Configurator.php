<?php

namespace App\Filter;


use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;

class Configurator
{
    protected $em;
    protected $reader;

    public function __construct(EntityManagerInterface $em, Reader $reader)
    {
        $this->em              = $em;
        $this->reader          = $reader;
    }

    public function onKernelRequest()
    {
        /** @var RestrictFilter $filter */
        $filter = $this->em->getFilters()->enable('restrict_filter');
        $filter->setReader($this->reader);
    }
}