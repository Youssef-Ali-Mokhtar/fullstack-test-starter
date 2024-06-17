<?php

namespace MyApp\GraphQL\Schema;

use GraphQL\Type\Schema as GraphQLSchema;
use GraphQL\Type\SchemaConfig;
use MyApp\GraphQL\Resolver\QueryResolver;
use MyApp\GraphQL\Resolver\MutationResolver;
use MyApp\GraphQL\ServiceContainer;

class Schema {
    public static function create() {
        $serviceContainer = new ServiceContainer();

        // Define the Query type
        $queryType = QueryResolver::create($serviceContainer);
        $mutationType = MutationResolver::create($serviceContainer);

        // Define the schema with Query and Mutation types
        return new GraphQLSchema(
            (new SchemaConfig())
                ->setQuery($queryType)
                ->setMutation($mutationType)
        );
    }
}
