<?php

    namespace MyApp\helper;

    class ParseProduct {

        static function convertInStockToBool($products) {

            $transformedData = array_map(function($product) {
                $product['inStock'] = (bool) $product['inStock'];
                return $product;
            }, $products);

            return $transformedData;
        }

        static function extractProduct($data) {
            $product = [
                'id' => $data[0]['productId'],
                'name' => $data[0]['productName'],
                'inStock' => (bool)$data[0]['inStock'],
                'category' => $data[0]['category'],
                'brand' => $data[0]['brand'],
            ];

            return $product;
        }

        static function extractAttributes($data) {
            $attributes = [];

            

            foreach ($data as $item) {
                $attributeId = $item['attributeId'];
                
                if (!isset($attributes[$attributeId])) {
                    $attributes[$attributeId] = [
                        'id' => $item['attributeId'],
                        'name' => $item['attributeName'],
                        'type' => $item['type'],
                    ];
                }
                $attributes[$attributeId]['items'][] = [
                    'id' => $item['itemId'],
                    'value' => $item['value'],
                    'displayValue' => $item['displayValue']
                ];
            }
    
            $attributes = array_values($attributes);

            return $attributes;
        }
        
    }

?>