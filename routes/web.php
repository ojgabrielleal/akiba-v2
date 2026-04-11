<?php 

use Illuminate\Support\Facades\Route;

// Private controllers
use App\Http\Controllers\Private\LoginController;
use App\Http\Controllers\Private\AdministrationController;
use App\Http\Controllers\Private\LocutionController;
use App\Http\Controllers\Private\DashboardController;
use App\Http\Controllers\Private\PostController;
use App\Http\Controllers\Private\ReviewController;
use App\Http\Controllers\Private\EventController;
use App\Http\Controllers\Private\RadioController;
use App\Http\Controllers\Private\PodcastController;
use App\Http\Controllers\Private\RepositoryController;
use App\Http\Controllers\Private\MediaController;
use App\Http\Controllers\Private\ProfileController;

// Provisory controllers
use App\Http\Controllers\Provisory\HomeController;

// Cast controllers
use App\Http\Controllers\Cast\CastController;


/*
|--------------------------------------------------------------------------
| Provisory routes
|--------------------------------------------------------------------------
*/
$provisory = function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('', 'render')->name('home');
        Route::post('song-request','createSongRequest');
    });
};

/*
|--------------------------------------------------------------------------
| Private routes
|--------------------------------------------------------------------------
*/
$private = function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('', 'render')->name('login');
        Route::post('auth', 'login');
    });

    Route::middleware(['inertia', 'auth'])->group(function () {
        Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
            Route::get('', 'render')->name('painel.dashboard');
            Route::prefix('activity')->group(function () {
                Route::post('{activity:uuid}/confirm', 'confirmActivityParticipant');
            });
            Route::prefix('task')->group(function () {
                Route::post('{task:uuid}/complete', 'markTaskCompleted');
            });
        });

        Route::prefix('materias')->controller(PostController::class)->group(function () {
            Route::get('', 'render')->name('painel.materias');
            Route::post('', 'createPost');
            Route::patch('{post:uuid}', 'updatePost');
            Route::get('{post:uuid}', 'showPost');
        });

        Route::prefix('reviews')->controller(ReviewController::class)->group(function () {
            Route::get('', 'render')->name('painel.reviews');
            Route::post('', 'createReview');
            Route::patch('{review:uuid}', 'updateReview');
            Route::get('{review:uuid}', 'showReview');
        });

        Route::prefix('eventos')->controller(EventController::class)->group(function () {
            Route::get('', 'render')->name('painel.eventos');
            Route::post('', 'createEvent');
            Route::patch('{event:uuid}', 'updateEvent');
            Route::get('{event:uuid}', 'showEvent');
        });

        Route::prefix('locucao')->controller(LocutionController::class)->group(function () {
            Route::prefix('locution')->group(function () {
                Route::post('start/{program:uuid}', 'startLocution');
                Route::patch('finish', 'finishLocution');
            });
            Route::prefix('songrequest')->group(function () {
                Route::patch('{songRequest:uuid}/played', 'markSongRequestAsPlayed');
                Route::patch('{songRequest:uuid}/canceled', 'markSongRequestAsCanceled');
                Route::patch('toggle', 'toggleSongRequestBoxStatus');
            });
            Route::get('', 'render')->name('painel.locucao');
        });

        Route::prefix('radio')->controller(RadioController::class)->group(function () {
            Route::prefix('program')->group(function () {
                Route::post('', 'createProgram');
                Route::patch('{program:uuid}', 'updateProgram');
                Route::get('{program:uuid}', 'showProgram');
                Route::delete('{program:uuid}', 'deactivateProgram');
            });
            Route::prefix('music-ranking')->group(function () {
                Route::post('', 'generateMusicRanking');
                Route::patch('{music:uuid}', 'updateMusicRanking');
            });
            Route::prefix('listener-month')->group(function () {
                Route::post('', 'createListenerMonth');
                Route::get('found', 'showListenerMonthFound');
            });
            Route::get('', 'render')->name('painel.radio');
        });

        Route::prefix('podcasts')->controller(PodcastController::class)->group(function () {
            Route::get('', 'render')->name('painel.podcasts');
            Route::post('', 'createPodcast');
            Route::patch('{podcast:uuid}', 'updatePodcast');
            Route::delete('{podcast:uuid}', 'deactivatePodcast');
            Route::get('{podcast:uuid}', 'showPodcast');
        });

        Route::prefix('marketing')->controller(RepositoryController::class)->group(function () {
            Route::prefix('repository')->group(function () {
                Route::post('', 'createRepository');
                Route::get('{repository:uuid}', 'showRepository');
                Route::patch('{repository:uuid}', 'updateRepository');
                Route::delete('{repository:uuid}', 'deactivateRepository');
            });
            Route::get('', 'render')->name('painel.marketing');
        });

        Route::prefix('medias')->controller(MediaController::class)->group(function () {
            Route::prefix('event')->group(function () {
                Route::delete('{event:uuid}', 'deactivateEvent');
            });
            Route::prefix('poll')->group(function () {
                Route::post('', 'createPoll');
                Route::patch('{poll:uuid}', 'updatePoll');
                Route::delete('{poll:uuid}', 'deactivatePoll');
                Route::get('{poll:uuid}', 'showPoll');
                Route::prefix('vote')->group(function () {
                    Route::post('{pollOption:uuid}', 'createVote');
                });
            });
            Route::get('', 'render')->name('painel.medias');
        });

        Route::prefix('adms')->controller(AdministrationController::class)->group(function () {
            Route::prefix('user')->group(function () {
                Route::post('', 'createUser');
                Route::get('{user:uuid}', 'showUser');
                Route::delete('{user:uuid}', 'deactivateUser');
                Route::patch('{user:uuid}', 'updateUserAccess');
                Route::prefix('roles')->group(function () {
                    Route::patch('{user:uuid}', 'changeUserRoles');
                });
            });
            Route::prefix('roles')->group(function(){
                Route::post('', 'createRole');
                Route::get('{role:uuid}', 'showRole');
                Route::patch('{role:uuid}', 'updateRole');
                Route::delete('{role:uuid}', 'removeRole');
            });
            Route::prefix('calendar')->group(function(){
                Route::post('', 'createCalendar');
                Route::get('{calendar:uuid}', 'showCalendar');
                Route::patch('{calendar:uuid}', 'updateCalendar');
            });
            Route::prefix('activity')->group(function () {
                Route::post('', 'createActivity');
                Route::get('{activity:uuid}', 'showActivity');
                Route::patch('{activity:uuid}', 'updateActivity');
                Route::delete('{activity:uuid}', 'removeActivity');
            });
            Route::get('', 'render')->name('painel.adms');
        });

        Route::prefix('profile')->controller(ProfileController::class)->group(function () {
            Route::patch('{user:uuid}', 'updateProfile');
            Route::get('{user:uuid}', 'render')->name('painel.profile');
        });
    });
};

/*
|--------------------------------------------------------------------------
| Stream routes
|--------------------------------------------------------------------------
*/
$stream = function () {
    Route::controller(CastController::class)->group(function () {
        Route::get('', 'redirectStream');
        Route::get('metadata', 'showMetadata');
    });
};

/*
|--------------------------------------------------------------------------
| Domains first
|--------------------------------------------------------------------------
*/
Route::domain('stream.akiba.com.br')->group($stream);
Route::prefix('cast')->group($stream);

Route::domain('painel.akiba.com.br')->group($private);
Route::prefix('admin')->group($private);

Route::prefix('')->group($provisory);