<?php

namespace MyApp\GraphQL\Schema;

use GraphQL\Type\Schema as GraphQLSchema;
use GraphQL\Type\SchemaConfig;
use MyApp\GraphQL\Resolver\QueryResolver;
use MyApp\GraphQL\Resolver\MutationResolver;

class Schema {
    public static function create() {
        // Define the Query type
        $queryType = QueryResolver::create();

        // Define the Mutation type
        $mutationType = MutationResolver::create();

        // Define the schema with Query and Mutation types
        return new GraphQLSchema(
            (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
        );
    }
}
