<?php

namespace FluxBB\Core;

use Illuminate\Support\ServiceProvider;
use FluxBB\Models\GroupRepository;
use FluxBB\Models\ConfigRepository;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('fluxbb/core', 'fluxbb');

        // Add another namespace for localized mail templates
        $locale = $this->app['config']['app.locale'];
        $this->app['view']->addNamespace('fluxbb:mail', __DIR__ . '/../../lang/' . $locale . '/mail/');

        include __DIR__.'/../../start.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerViewComposers();
        $this->registerEventHandlers();
    }

    /**
     * Register the IoC container bindings.
     *
     * @return void
     */
    protected function registerBindings()
    {
        $this->app->bind('FluxBB\Models\GroupRepositoryInterface', function ($app) {
            return new GroupRepository($app['cache']);
        });

        $this->app->bind('FluxBB\Models\ConfigRepositoryInterface', function ($app) {
            return new ConfigRepository($app['cache.store'], $app['db']->connection('fluxbb'));
        });
    }

    /**
     * Register any view composers.
     *
     * @return void
     */
    protected function registerViewComposers()
    {
        $this->app->resolving('view', function ($view) {
            $view->composer('fluxbb::layout.main', 'FluxBB\View\AlertsComposer');
            $view->composer('fluxbb::layout.partials.footer', 'FluxBB\View\FooterComposer');
        });
    }

    /**
     * Register any event handlers.
     *
     * @return void
     */
    protected function registerEventHandlers()
    {
        $events = $this->app['events'];

        $events->listen('user.registered', 'FluxBB\Handlers\SendWelcomeEmail');
        $events->listen('user.posted', 'FluxBB\Handlers\UpdateUserPostStats');
        $events->listen('user.posted', 'FluxBB\Handlers\UpdateForumStats');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
