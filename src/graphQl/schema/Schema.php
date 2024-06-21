<?php

namespace MyApp\graphQl\schema;

use GraphQL\Type\Schema as GraphQLSchema;
use GraphQL\Type\SchemaConfig;
use MyApp\graphQl\resolver\QueryResolver;
use MyApp\graphQl\resolver\MutationResolver;
use MyApp\graphQl\ServiceContainer;

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
