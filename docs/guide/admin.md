# Administration

Loading Data with routes enabled registers public plugin routes and routes under the `Admin` prefix. For example, the countries screen is `/admin/data/countries` with the standard dashed route class. Your application's route scope or base path can change that URL.

The controllers inherit your `AppController` and use its initialization and request handling. There is no plugin-specific standalone mode, automatic admin authentication, or `Data.adminAccess` callback. Configure authentication and authorization in your application before exposing these routes. An `Admin` prefix alone does not restrict access.

The supplied templates use Tools helpers and your application layout. Load Tools and provide the layout, Flash support, navigation, and middleware your application expects. Search filtering is optional and requires the Search plugin to be installed and loaded.

## Manage data

The Admin controllers include screens for continents, countries, states, cities, postal codes, languages, currencies, addresses, MIME types, MIME type images, and timezones. Not every screen is a complete CRUD interface. Some import and image utilities assume application directories or optional packages.

Start with country and timezone management after migrating the complete schema. Do not expose address administration until you have configured its [address dependencies](../reference/addresses).

## Review sync changes

The country and timezone sync actions retrieve remote datasets and show proposed changes. Applying a selection requires a POST request. Missing upstream rows are not proposed for deletion because a partial catalog cannot establish that stored data is obsolete. Review edits before submitting, and keep a database backup.

The timezone sync compares the provider's data with your stored rows. Canonical records and aliases require careful review; importing a list does not necessarily establish every alias relationship.

For public applications that only need country lookups or flags, disable Data's routes and expose a smaller, application-specific controller instead.

An empty remote catalog produces no sync changes. A network failure or parser failure must not propose deleting all existing records.

When a remote source is unavailable or cannot be parsed, the sync screen displays a warning instead of presenting an empty result as proof that the records are current.
