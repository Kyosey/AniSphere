<?php

namespace App\Factory;

use App\Entity\Genre;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Genre>
 */
final class GenreFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Genre::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'name' => self::faker()->unique()->randomElement([
                'Action',
                'Adventure',
                'Fantasy',
                'Horror',
                'Isekai',
                'Mecha',
                'Romance',
                'Science-Fiction',
                'Slice of Life',
                'Sports',
                'Thriller',
                'Mystery',
                'Psychological',
                'Supernatural',
                'Ecchi',
                'Mecha'
            ]),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Genre $genre): void {})
        ;
    }
}
