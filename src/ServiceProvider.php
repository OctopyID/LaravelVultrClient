<?php

namespace Octopy\Vultr;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
	/**
	 * @return void
	 */
	public function register() : void
	{
		$this->mergeConfigFrom(
			__DIR__ . '/../config/vultr.php', 'vultr'
		);

		$this->app->singleton(Client::class, function () {
			return (new Client(config('vultr.key')))->cache(config('vultr.cache'));
		});
	}

	/**
	 * @return void
	 */
	public function boot() : void
	{
		$this->registerPublishing();
	}

	/**
	 * @return void
	 */
	private function registerPublishing()
	{
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__ . '/../config/vultr.php' => config_path('vultr.php'),
			], 'vultr-config');
		}
	}

}
