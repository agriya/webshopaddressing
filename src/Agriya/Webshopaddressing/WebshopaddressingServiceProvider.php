<?php namespace Agriya\Webshopaddressing;

use Illuminate\Support\ServiceProvider;

class WebshopaddressingServiceProvider extends ServiceProvider {

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
		$this->package('agriya/webshopaddressing');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		$this->app['webshopaddressing'] = $this->app->share(function($app){

			return new Webshopaddressing();
		});
		$this->app->booting(function(){

			\Illuminate\Foundation\AliasLoader::getInstance()->alias('Webshopaddressing','Agriya\Webshopaddressing\Facades\Webshopaddressing');
		});
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
