Route::view('/', 'media.home')->name('home');
Route::prefix('legalhealthcheck')->name('legal.healthcheck.')->group(function () {
    Route::view('/', 'legal.healthcheck.landing')->name('landing');
    Route::view('/assess', 'legal.healthcheck.assessment')->name('assessment');
    Route::view('/results/{id}', 'legal.healthcheck.results')->name('results');
});
Route::view('/services/legal/tiers', 'services.legal-tiers')->name('services.legal.tiers');
Route::view('/partners', 'partners.index')->name('partners.index');
Route::view('/services', 'services.index')->name('services.index');
Route::view('/faq', 'faq.index')->name('faq');