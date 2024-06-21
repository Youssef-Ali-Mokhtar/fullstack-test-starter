<?php

namespace MyApp\graphql\schema;

use GraphQL\Type\Schema as GraphQLSchema;
use GraphQL\Type\SchemaConfig;
use MyApp\graphql\resolver\QueryResolver;
use MyApp\graphql\resolver\MutationResolver;
use MyApp\graphql\ServiceContainer;

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
