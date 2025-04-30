<?php

namespace App\Providers;

use App\Domain\Repositories\AssessmentRepository;
use App\Domain\Repositories\CountryRepository;
use App\Domain\Repositories\GameInstancesRepository;
use App\Domain\Repositories\GameProgressRepository;
use App\Domain\Repositories\GameSessionsRepository;
use App\Domain\Repositories\GameSettingRepository;
use App\Domain\Repositories\HangmanRepository;
use App\Domain\Repositories\MemoryGameRepository;
use App\Domain\Repositories\ProgrammingGameRepository;
use App\Domain\Repositories\PuzzleRepository;
use App\Domain\Repositories\SolveTheWordRepository;
use App\Domain\Repositories\UserRepository;
use App\Domain\Repositories\WordsRepository;
use App\Infrastructure\Adapters\EloquentAssessmentRepository;
use App\Infrastructure\Adapters\EloquentCountryRepository;
use App\Infrastructure\Adapters\EloquentGameInstancesRepository;
use App\Infrastructure\Adapters\EloquentGameProgressRepository;
use App\Infrastructure\Adapters\EloquentGameSessionsRepository;
use App\Infrastructure\Adapters\EloquentGameSettingRepository;
use App\Infrastructure\Adapters\EloquentHangmanRepository;
use App\Infrastructure\Adapters\EloquentMemoryGameRepository;
use App\Infrastructure\Adapters\EloquentProgrammingGameRepository;
use App\Infrastructure\Adapters\EloquentPuzzleRepository;
use App\Infrastructure\Adapters\EloquentSolveTheWordRepository;
use App\Infrastructure\Adapters\EloquentUserRepository;
use App\Infrastructure\Adapters\EloquentWordsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CountryRepository::class,
            EloquentCountryRepository::class
        );
        $this->app->bind(
            UserRepository::class,
            EloquentUserRepository::class
        );
        $this->app->bind(
            GameInstancesRepository::class,
            EloquentGameInstancesRepository::class
        );
        $this->app->bind(
            ProgrammingGameRepository::class,
            EloquentProgrammingGameRepository::class
        );
        $this->app->bind(
            AssessmentRepository::class,
            EloquentAssessmentRepository::class
        );
        $this->app->bind(
            GameSettingRepository::class,
            EloquentGameSettingRepository::class
        );
        $this->app->bind(
            HangmanRepository::class,
            EloquentHangmanRepository::class
        );
        $this->app->bind(
            SolveTheWordRepository::class,
            EloquentSolveTheWordRepository::class
        );
        $this->app->bind(
            MemoryGameRepository::class,
            EloquentMemoryGameRepository::class
        );
        $this->app->bind(
            PuzzleRepository::class,
            EloquentPuzzleRepository::class
        );
        $this->app->bind(
            GameSessionsRepository::class,
            EloquentGameSessionsRepository::class
        );
        $this->app->bind(
            WordsRepository::class,
            EloquentWordsRepository::class
        );
        $this->app->bind(
            GameProgressRepository::class,
            EloquentGameProgressRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
