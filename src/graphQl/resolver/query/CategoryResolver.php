<?php

namespace MyApp\graphQl\resolver\query;

use MyApp\services\CategoryService;

class CategoryResolver {
    private $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function getCategories() {
        return $this->categoryService->getCategories();
    }
}
