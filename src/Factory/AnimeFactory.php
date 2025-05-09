<?php

namespace App\Factory;

use App\Entity\Anime;
use App\Factory\StudioFactory;
use App\Factory\DirectorFactory;
use App\Factory\CharacterFactory;
use App\Factory\GenreFactory;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Anime>
 */
final class AnimeFactory extends PersistentProxyObjectFactory
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
        return Anime::class;
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
            'episodeCount' => self::faker()->numberBetween(12, 100),
            'durationPerEpisode' => self::faker()->numberBetween(20, 30),
            'studio' => StudioFactory::new(),
            'directors' => DirectorFactory::new()->many(self::faker()->numberBetween(1, 2)),
            'characters' => CharacterFactory::new()->many(self::faker()->numberBetween(2, 5)),
            'genres' => GenreFactory::new()->many(self::faker()->numberBetween(1, 3)),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Anime $anime): void {})
        ;
    }
}
