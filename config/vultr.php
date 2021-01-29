<?php

return [

	/*
	|--------------------------------------------------------------------------
	| API Key
	|--------------------------------------------------------------------------
	|
	| The Vultr API v2 uses API keys for authentication.
	| You can manage your API keys in the https://my.vultr.com/settings/#settingsapi.
	|
	| Please do not share API keys publicly, or embed them in client-side code.
	| It is a good security practice to restrict their use by IP address.
	|
	*/
	'key'   => env('VULTR_API_KEY'),

	/*
	|--------------------------------------------------------------------------
	| Caching
	|--------------------------------------------------------------------------
	|
	| If it is set to more than 0 then a valid response will be automatically stored.
	|
	| The number set in this section shows the active period of the cache,
	| the bigger the number, the longer the cache will be.
	|
	| Stored cache depends on the driver cache used.
	|
	*/
	'cache' => env('VULTR_CACHE_LIFETIME', 60),
];
