<?php

    namespace MyApp\services;

    use MyApp\models\categoryModel\Category;

    class CategoryService {
        private $categoryRepository;

        public function __construct($categoryRepository) {
            $this->categoryRepository = $categoryRepository;
        }

        public function getCategories() {
            $categoriesData = $this->categoryRepository->fetchCategories();

            $categories = [];

            foreach($categoriesData as $category) {
                $categoryObj = new Category($category);
                $categories[] = $categoryObj->getDetails();
            }

            return $categories;
        }
    }
?>