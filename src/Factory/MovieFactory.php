<?php

namespace App\Factory;

use App\Entity\Movie;
use App\Factory\StudioFactory;
use App\Factory\DirectorFactory;
use App\Factory\CharacterFactory;
use App\Factory\GenreFactory;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Movie>
 */
final class MovieFactory extends PersistentProxyObjectFactory
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
        return Movie::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'title' => self::faker()->sentence(3),
            'releaseYear' => self::faker()->year(),
            'synopsis' => self::faker()->paragraph(),
            'duration' => self::faker()->numberBetween(60, 130),
            'studio' => StudioFactory::new(),
            'directors' => DirectorFactory::new()->many(self::faker()->numberBetween(1, 2)),
            'characters' => CharacterFactory::new()->many(self::faker()->numberBetween(2, 5)),
            'genres' => GenreFactory::new()->many(self::faker()->numberBetween(1, 3)),
            'image' => 'https://picsum.photos/seed/' . self::faker()->unique()->word() . '/600/400',
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Movie $movie): void {})
        ;
    }
}
