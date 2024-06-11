<?php

    namespace MyApp\helper;

    class ParseProduct {

        public static function aggregateData($data) {
            $organizedData = [];
    
            foreach ($data as $row) {
                $id = $row['productId'];
                if (!isset($organizedData[$id])) {
                    $organizedData[$id] = [];
                }
                $organizedData[$id][] = $row;
            }
    
            return $organizedData;
        }

        static function extractProduct($data) {
            $product = [
                'id' => $data[0]['productId'],
                'name' => $data[0]['productName'],
                'inStock' => (bool)$data[0]['inStock'],
                'description' => $data[0]['description'],
                'category' => $data[0]['category'],
                'brand' => $data[0]['brand'],
            ];

            $prices = [];

            foreach($data as $item) {
                $priceId = $item['priceId'];
                $prices[$priceId] = [
                    'amount'=> round($item['amount'], 2),
                    'currency'=> [
                        'label'=>$item['currencyLabel'],
                        'symbol'=>$item['currencySymbol']
                    ]
                    ];
            }

            $product['prices'] = array_values($prices);

            return $product;
        }

        static function extractAttributes($data) {
            $attributes = [];
        
            if (empty($data) || !isset($data[0]['attributeId'])) {
                return $attributes;
            }
        
            foreach ($data as $item) {
                $attributeId = $item['attributeId'];
                $itemId = $item['itemId'];
                
                if (!isset($attributes[$attributeId])) {
                    $attributes[$attributeId] = [
                        'id' => $attributeId,
                        'name' => $item['attributeName'],
                        'type' => $item['type'],
                        'items' => []
                    ];
                }
        
                // Add the item to the attribute if it doesn't already exist
                if (!isset($attributes[$attributeId]['items'][$itemId])) {
                    $attributes[$attributeId]['items'][$itemId] = [
                        'id' => $itemId,
                        'value' => $item['value'],
                        'displayValue' => $item['displayValue']
                    ];
                }
            }
            
            // Convert items associative array to indexed array
            foreach ($attributes as &$attribute) {
                $attribute['items'] = array_values($attribute['items']);
            }
        
            return array_values($attributes);
        }
        
    }
