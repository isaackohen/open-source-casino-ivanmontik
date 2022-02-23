<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;
use Laravel\Jetstream\Http\Controllers\Inertia\ApiTokenController;
use Laravel\Jetstream\Http\Controllers\Inertia\CurrentUserController;
use Laravel\Jetstream\Http\Controllers\Inertia\OtherBrowserSessionsController;
use Laravel\Jetstream\Http\Controllers\Inertia\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Inertia\ProfilePhotoController;
use Laravel\Jetstream\Http\Controllers\Inertia\TeamController;
use Laravel\Jetstream\Http\Controllers\Inertia\TeamMemberController;
use Laravel\Jetstream\Http\Controllers\Inertia\TermsOfServiceController;
use Laravel\Jetstream\Http\Controllers\TeamInvitationController;
use Laravel\Jetstream\Jetstream;
use App\Http\Controllers\Games\ThirdpartyGamesController;
use App\Http\Controllers\Profile\UserProfileController;
use App\Http\Controllers\Profile\CurrenciesController;

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
        Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
    }

    Route::group(['middleware' => ['auth', 'verified']], function () {
        // User & Profile...
        Route::get('/user/profile', [UserProfileController::class, 'show'])
            ->name('profile.show');

        Route::put('/data/selectedCurrency', [CurrenciesController::class, 'selectedCurrency'])
            ->name('user.data.selectedCurrency');

        Route::put('/data/updateBalances', [CurrenciesController::class, 'updateBalances'])
            ->name('user.data.updateBalances');

        Route::put('/data/updateGames', [ThirdpartyGamesController::class, 'updateGames'])
            ->name('user.data.updateGames');

        Route::get('/data/launchGame', [ThirdpartyGamesController::class, 'play'])
            ->name('user.data.launchGame');

        Route::get('/user/paymentHistory', [UserProfileController::class, 'showPaymentHistory'])
            ->name('payment.history.show');

        Route::post('/user/withdrawRequest', [UserProfileController::class, 'withdrawRequest'])
            ->name('payment.withdraw.request');


        Route::get('/data/currentBalance', [CurrenciesController::class, 'currentBalance'])
            ->name('user.data.currentBalance');

        Route::delete('/user/other-browser-sessions', [OtherBrowserSessionsController::class, 'destroy'])
            ->name('other-browser-sessions.destroy');

        Route::delete('/user/profile-photo', [ProfilePhotoController::class, 'destroy'])
            ->name('current-user-photo.destroy');

        if (Jetstream::hasAccountDeletionFeatures()) {
            Route::delete('/user', [CurrentUserController::class, 'destroy'])
                ->name('current-user.destroy');
        }

        // API...
        if (Jetstream::hasApiFeatures()) {
            Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
            Route::post('/user/api-tokens', [ApiTokenController::class, 'store'])->name('api-tokens.store');
            Route::put('/user/api-tokens/{token}', [ApiTokenController::class, 'update'])->name('api-tokens.update');
            Route::delete('/user/api-tokens/{token}', [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
        }

        // Teams...
        if (Jetstream::hasTeamFeatures()) {
            Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
            Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
            Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
            Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
            Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
            Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');
            Route::post('/teams/{team}/members', [TeamMemberController::class, 'store'])->name('team-members.store');
            Route::put('/teams/{team}/members/{user}', [TeamMemberController::class, 'update'])->name('team-members.update');
            Route::delete('/teams/{team}/members/{user}', [TeamMemberController::class, 'destroy'])->name('team-members.destroy');

            Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept'])
                ->middleware(['signed'])
                ->name('team-invitations.accept');

            Route::delete('/team-invitations/{invitation}', [TeamInvitationController::class, 'destroy'])
                ->name('team-invitations.destroy');
        }
    });
});
