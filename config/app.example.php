<?php

/**
 * Data Example Configuration
 *
 * Merge the keys below into your application's config/app.php (or
 * config/app_local.php) — do not replace the whole file, since this snippet
 * only contains this plugin's configuration. When copying entries that
 * reference imported classes, use fully-qualified class names or move the
 * `use` imports to the top of the target file. Customize the values as needed.
 *
 * The plugin reads keys from three namespaces:
 * - `Data` for association toggles and behavior defaults (read in src/Model/Table/*.php
 *   and src/Controller/Admin/*.php).
 * - `Country` and `Language` for the display/icon options used by
 *   src/View/Helper/DataHelper.php.
 *
 * All `Data.*.*` association toggles are enabled by default and are only disabled
 * when explicitly set to boolean false (the source checks `!== false`). Set a key
 * to false to drop the corresponding ORM association.
 */

return [
	'Data' => [
		'defaultCountryCode' => 'DE', // ISO2 code resolved by CountriesTable::getDefaultCountry()

		'Country' => [
			'State' => true, // false disables Countries hasMany States association
			'Continent' => true, // false disables Countries belongsTo Continents association
			'Timezone' => true, // false disables Countries hasMany Timezones association (also used by Admin controllers)
		],
		'State' => [
			'County' => true, // false disables States hasMany Counties association
		],
		'City' => [
			'District' => true, // false disables Cities hasMany District association
			'County' => true, // false disables Cities belongsTo Counties association
		],
		'Timezone' => [
			'Country' => true, // false disables Timezones belongsTo Countries association (Table and Admin controller)
		],
		'Address' => [
			'State' => true, // truthy enables the States list lookup in Admin/AddressesController add/edit
		],
		'Language' => [
			'dir' => 'lower', // Casing applied to language code/iso2/iso3 on marshal: 'lower' or 'upper'
		],
	],

	// Country flag display options (read by DataHelper).
	'Country' => [
		// CSS class for font-based flag icons (e.g. lipis/flag-icon-css).
		// When set, font icons are rendered instead of image files.
		'iconFontClass' => null, // e.g. 'flag-icon'
		// Custom path for country flag images. Plugin-dotted paths are supported,
		// e.g. 'MyPlugin./img/country_flags/'. Null uses the bundled Data flags.
		// NOTE: DataHelper reads camelCase `imagePath`, but CountriesController and
		// Admin/CountriesController read snake_case `image_path`. Set BOTH to the same
		// value until the source is unified, or the admin flag pages will ignore it.
		'imagePath' => null,
		'image_path' => null, // Read by Countries / Admin Countries controllers (see note)
	],

	// Language flag display options (read by DataHelper).
	'Language' => [
		// CSS class for font-based language icons.
		'iconFontClass' => null, // e.g. 'flag-icon'
		// Maps language codes to country codes for flag lookup (font icons only).
		// 'en' => 'gb' is always added as a built-in fallback.
		'map' => [
			// 'en' => 'gb',
		],
		// Custom path for language flag images. Falls back to the country
		// image path when not set.
		'imagePath' => null,
	],
];
