<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Repository Interfaces
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\MissionRepositoryInterface;
use App\Repositories\Interfaces\ApplicationRepositoryInterface;
use App\Repositories\Interfaces\ProgressRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\BadgeRepositoryInterface;
use App\Repositories\Interfaces\PortfolioRepositoryInterface;
use App\Repositories\Interfaces\PointRepositoryInterface;

// Repository Implementations
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\MissionRepository;
use App\Repositories\Eloquent\ApplicationRepository;
use App\Repositories\Eloquent\ProgressRepository;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Eloquent\BadgeRepository;
use App\Repositories\Eloquent\PortfolioRepository;
use App\Repositories\Eloquent\PointRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All repository bindings.
     */
    public array $bindings = [
        UserRepositoryInterface::class => UserRepository::class,
        MissionRepositoryInterface::class => MissionRepository::class,
        ApplicationRepositoryInterface::class => ApplicationRepository::class,
        ProgressRepositoryInterface::class => ProgressRepository::class,
        ReviewRepositoryInterface::class => ReviewRepository::class,
        BadgeRepositoryInterface::class => BadgeRepository::class,
        PortfolioRepositoryInterface::class => PortfolioRepository::class,
        PointRepositoryInterface::class => PointRepository::class,
    ];

    public function register(): void
    {
        foreach ($this->bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    public function boot(): void
    {
        //
    }
}
