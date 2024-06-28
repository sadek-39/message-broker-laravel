<?php

namespace App\Service;

use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function create($data)
    {
        return $this->productRepository->create($data);
    }

    public function getAll()
    {
        return $this->productRepository->getAll();
    }

}
