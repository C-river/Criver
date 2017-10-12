<?php

namespace App\Providers;

use App\Article;
use App\Discussion;
use Illuminate\Support\ServiceProvider;
use App\Tools\FileManager\BaseManager;
use App\Tools\FileManager\UpyunManager;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		// Laravel 5.5  1071 Specified key was too long; max key length is 767 bytes
		Schema::defaultStringLength(191);
		
        $lang = config('app.locale') != 'zh_cn' ? config('app.locale') : 'zh';
        \Carbon\Carbon::setLocale($lang);

        Relation::morphMap([
            'discussions' => Discussion::class,
            'articles'    => Article::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('uploader', function ($app) {
            $config = config('filesystems.default', 'public');

            if ($config == 'upyun') {
                return new UpyunManager();
            }

            return new BaseManager();
        });
    }
}
