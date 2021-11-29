# Disposable Basic Pack v3

phpVMS v7 module for Basic VA features

Compatible with any latest development (dev) build of phpVMS v7 released after **09.NOV.21**.  
Module blades are designed for themes using **Bootstrap v5.x** and FontAwesome v5.x (not v6) icons.

This module pack aims to cover basic needs of any Virtual Airline with some new pages, widgets and backend tools. Provides;

* Airlines page (with details of selected airline)
* Fleet page (with details of selected subfleet and/or aircraft)
* Hubs page (with details of selected hub)
* Statistics page (with basic leaderboard options)
* Support for variable aircraft addons and related displays (mainly for SimBrief integration)
* Additional customizable pre-defined content pages (apart from phpVMS v7 pages system)
* Live Weather Map (uses Windy as its source)
* Configurable JumpSeat Travel and Aircraft Transfer possibilities for pilots at frontend
* Daily random flight assignments/offerings
* Fleet/Flights/Pireps Maps (based on leaflet, mostly customizable)
* Some widgets to enhance any page/layout as per virtual airline needs

## Installation and Updates

* Manual Install : Upload contents of the package to your phpvms root `/modules` folder via ftp or your control panel's file manager
* GitHub Clone : Clone/pull repository to your phpvms root `/modules/DisposableBasic` folder
* PhpVms Module Installer : Go to admin -> addons/modules , click Add New , select downloaded file then click Add Module

* Go to admin > addons/modules enable the module
* Go to admin > dashboard (or /update) to trigger module migrations
* When migration is completed, go to admin > maintenance and clean `application` cache

:information_source: *There is a known bug in v7 core, which causes an error/exception when enabling/disabling modules manually. If you see a server error page or full stacktrace debug window when you enable a module just close that page and re-visit admin area in a different browser tab/window. You will see that the module is enabled and active, to be sure just clean your `application` cache*

### Update (from v3.xx to v3.yy)

Just follow the installation procedure by overwriting your old module files

### Update (from v2.xx series to v3.xx)

Below order and steps are really important for proper update from old modules to new combined module pack

:warning: **There is no easy going back to v2 series once v3 is installed !!!** :warning:  
**Backup your database tables and old module files before this process**  
**Only database tables starting with `disposable_` is needed to be backed up**

* From admin > addons/modules **DISABLE** all old Disposable modules
* From admin > addons/modules **DELETE** all old Disposable modules
* Go to admin > maintenance and clean `all` cache
* Install Disposable Basic module (by following installation procedure)

## Module links and routes

Module does not provide auto links to your phpvms theme, Disposable Theme v3 has some built in menu items but in case you need to manually adjust or use a different theme/menu, below are the routes and their respective url's module provide

Named Routes and Url's

```php

DBasic.airlines  /dairlines         // Airlines index page
DBasic.airline   /dairlines/DSP     // Airline details page, needs an {icao} code to run

DBasic.hubs      /dhubs             // Hubs index page
DBasic.hub       /dhubs/LTAI        // Hub details page, needs an {icao} code to run

DBasic.fleet     /dfleet            // Fleet index page
DBasic.subfleet  /dfleet/B738-DSP   // Subfleet details page, needs a {subfleet_type} code to run
DBasic.aircraft  /daircraft/TC-DHA  // Aircraft details page, needs a {registration} code to run

DBasic.awards    /dawards           // Awards index page
DBasic.news      /dnews             // News index page
DBasic.livewx    /dlivewx           // Live Weather Map index page
DBasic.pireps    /dpireps           // All Pireps index page
DBasic.ranks     /dranks            // Ranks index page
DBasic.roster    /droster           // Roster index page (full roster)
DBasic.stats     /dstats            // Statistics index page
```

Also for embedding in your main (landing) sites, two public url's are available.  
These pages will have no logo, background image or menu items. They are suitable for iframe usage at your landing pages (or main sites)

```php
/dp_roster  // Pilot roster
/dp_stats   // Statistics
/dp_page    // Empty page in which you can place widgets like Flight Board etc as per your needs
```

Usage examples;

```html
<a class="nav-link" href="{{ route('DBasic.fleet') }}" title="Fleet">
  Fleet
  <i class="fas fa-plane mx-1"></i>
</a>

<a class="nav-link" href="{{ route('DBasic.subfleet', [$subfleet->type]) }}" title="Fleet">
  {{ $subfleet->type }}
  <i class="fas fa-link mx-1"></i>
</a>

<a class="nav-link" href="{{ route('DBasic.aircraft', [$aircraft->registration]) }}" title="Fleet">
  {{ $aircraft->registration }}
  <i class="fas fa-paper-plane mx-1"></i>
</a>

<a class="nav-link" href="/dfleet" title="Fleet">
  Fleet
  <i class="fas fa-plane mx-1"></i>
</a>

<a class="nav-link" href="/daircraft/{{ $aircraft->registration}}" title="Fleet">
  {{ $aircraft->registration }}
  <i class="fas fa-plane mx-1"></i>
</a>

<iframe src="https://your.phpvms.site/dp_roster" style="border:none; display:block; width: 500px; height: 600px;" title="Roster"></iframe>
```

## Usage and Module Settings

Check module admin page to view all features and possible settings module offers.

When enabled module can listen pirep events and change Aircraft states (PARKED, IN USE, PARKED) which simply blocks simultaneous usage of aircraft by multiple pilots.
Even though there are some background checks and a cron feature to release possible stuck aircraft admins can also manually park an aircraft from admin panel.

Also module can send customized Discord notifications when a pirep gets filed, it is a separate feature compared to phpvms core system. It only sends one message per pirep.

As additional features, you can define addon based specifications for your fleet members. Like defining two profiles for a Boeing B737-800 like one for `Zibo` and another for `PMDG`.
These definitions can be per aircraft, per subfleet or per icao type and used both for visual display at respective pages (aircraft/subfleet) and be used with SimBrief API for proper 
flight planning.

If you are not developing your own pirep checks and/or not using Disposable Special/Extended module solutions you can simply skip using Maintenance periods etc. They are here just for 
backward compatibility and some va's already based their custom code on them.

For runways, simply check `Support Files` folder. There is a world runways database shipped with the module, it is quite old but still usefull for most airports. You can import those runways 
and have runway selection at SimBrief flight planning form. This is an optional feature like the maintenance details definitions.

As an additional feature, module provides a quick database health check here. Technically it is a helper for you to solve problems, like finding out missing airports or broken relationships 'caused 
by either import problems or hard deleting records from your database. Provided results are mostly for usage in your sql queries to fix things manually when needed.

### Stable Approach Plugin Support

For auto receiving approach reports and matching them with pireps, below steps required to be completed at phpvms side;

1. Add a new custom user profile field with the name `Stable Approach ID`, and make it active
2. Pilots using X-Plane and Stable Approach Plugin then should add their plugin generated user id's by editing their profile

Rest is updating and setting up the plugin for auto report uploads, below url should be used by pilots at plugin settings.

`https://your.phpvms.url/dstable/new`

Refer to plugin documentation (wiki, discord) for further details. Module only gets the reports generated by the plugin and stores/displays them.

## Widgets

When needed, you can use below widgets to enhance the data provided by your pages.

```php
@widget('DBasic::ActiveBookings')
@widget('DBasic::ActiveUsers')
@widget('DBasic::AirportAssets')
@widget('DBasic::AirportInfo')
@widget('DBasic::Discord')
@widget('DBasic::FleetOverview')
@widget('DBasic::FlightBoard')
@widget('DBasic::FlightTimeMultiplier')
@widget('DBasic::FuelCalculator')
@widget('DBasic::JumpSeat')
@widget('DBasic::LeaderBoard')
@widget('DBasic::Map')
@widget('DBasic::PersonalStats')
@widget('DBasic::RandomFlights')
@widget('DBasic::Stats')
@widget('DBasic::SunriseSunset')
@widget('DBasic::TransferAircraft')
@widget('DBasic::WhazzUp')
```

### Active Bookings

Shows either active SimBrief bookings or bids.

```php
@widget('DBasic::ActiveBookings', ['source' => 'bids'])
```

* `'source'` can be `'bids'` or `'simbrief'`

### Active Users

Show active users browsing your website (only members), needs the session to be handled by database.

```php
@widget('DBasic::ActiveUsers', ['margin' => 5])
```

* `'margin'` can be any number you wish for inactivity time limit (in minutes)

### Airport Assets

Shows pilots, aircraft or pireps of an airport.

```php
@widget('DBasic::AirportAssets', ['location' => $airport->id, 'type' => 'pireps', 'count' => 50])
```

* `'location'` must be an ICAO code like `$airport->id` or plain text `ETNL`  
* `'type'` can be either `'pilots'` , `'pireps'` or `'aircraft'`  
* `'count'` can be used to limit the displayed assets and must be numeric like 50 or 100 etc.

### Airport Info

Shows all your airports in a dropdown and provides a link to visit their pages.

```php
@widget('DBasic::AirportInfo', ['type' => 'nohubs'])
```

* `'type'` can be `'all'` , `'hubs'` or `'nohubs'`

This widget is designed my @macofallico and slightly enhanced by me. Distributed in this pack with his permission.

### Discord

Shows real time data from your Discord Server. Be advised, you should enable widget support of your Discord server first.

```php
@widget('DBasic::Discord', ['server' => 123456789123456789, 'bots' => true, 'bot' => ' Server Bot'])
```

* `'server'` is your Discord server id.  
* `'bots'` can be `true` or `false` and control displaying of Bots as online users
* `'bot'` should be the distinctive name part you give to your bots. For hiding 'Weahter Bot' and 'MEE6 Bot' for example, use `' Bot'` for this option

### Fleet Overview

Displays the airports your fleet is located or gives a SubFleet / ICAO type based count.

```php
@widget('DBasic::FleetOverview', ['type' => 'location', 'hubs' => false])
```

* `'type'` can be `'location'` , `'subfleet'` or `'icao'`  
* `'hubs'` can be either `true` or `false`

### Flight Board

Shows current/active flights. It has no custom settings.

```php
@widget('DBasic::FlightBoard')
```

### Flight Time Multiplier

A Basic flight time calculator. No special settings.

```php
@widget('DBasic::FlightTimeMultiplier')
```

Some VA's or platforms offer double or multiplied hours for some tours and events, thus this may come in handy.

### Fuel Calculator

Basic fuel calculator.

```php
@widget('DBasic::FuelCalculator', ['aircraft' => $aircraft->id])
```

* `'aircraft'` must be an aircraft's id (numeric value, not registration or name etc).

Widget uses either that aircraft's pirep average consumption or if not flown before it uses subfleet average.
Also it is possible to define an ICAO type based manufacturer consumption value (via module admin interface), then it will be used as primary source.

Considering the basic calculation, provided results should not be used for airline ops. Can be used for general aviation or for short range trips etc.

### Jumpseat Travel

Adds frontend pilot self transfer capability to phpVMS v7.

```php
@widget('DBasic::JumpSeat', ['base' => 0.25, 'price' => 'auto'])
```

* `'base'` forces the auto price system to use any given numeric value (like `0.25` cents per nautical mile)  
* `'price'` can be `'free'` , `'auto'` or a fixed numeric value like `250`. Currency is based on your phpvms v7 setttings  
* `'list'` can be `'hubs'` only and limits the destinations to hubs only  
* `'dest'` can be a fixed airport ICAO code (like `'LTFG'` or `$flight->dpt_airport_id`) and removes the selection dropdown. Provides direct travel to that destination

### Leader Board

Provides a leader board according to config options defined.

```php
@widget('DBasic::LeaderBoard', ['source' => 'pilot', 'hub' => $hub->id, 'count' => 3, 'period' => 'lastm', 'type' => 'lrate_low'])
```

* `'source'` should be `'pilot'`, `'airline'`, `'dep'` or `'arr'`
* `'hub'` can be an airport ID like `$hub->id` or plain text `'EDDH'`
* `'count'` can be any number you want (except 0 of course)
* `'type'` should be `'flight'`, `'time'`, `'distance'`, `'lrate'`, `'lrate_low'`, `'lrate_high'` or `'score'`
* `'period'` can be `'currentm'`, `'lastm'`, `'prevm'`, `'currenty'`, `'lasty'` or `'prevy'`  

The example above will give you the Top 3 pilots of that Hub for last month according to lowest landing rate recorded by acars.

To save server resources, past time based results will be cached until the end of month or year. Others will be cached until the end of day.

### Map

Generates a leaflet map according to config options defined.

```php
@widget('DBasic::Map', ['source' => 'fleet', 'airline' => $airline->id])
@widget('DBasic::Map', ['source' => $hub->id, 'limit' => 1000])
```

* `'source'` can be an airport_id (like `$airport->id` or `'EHAM'`), an airline_id (like `$airline->id` or `3`), `'user'`, `'fleet'`
* `'visible'` can be either `true` or `false` (to show or skip visible flights as per phpvms settings)
* `'limit'` can be a numeric value like `500` (to limit the drawn flights/pireps on the map due to performance reasons)

* When `'source' => 'fleet'` is used then you can define a specific airline with `'airline' => $airline->id` (or `'airline' => 3`) to show results for that airline

### Personal Stats

Provides personal pirep statistics per pilot according to config options defined.

```php
@widget('DBasic::PersonalStats', ['user' => $user->id, 'period' => 'lastm', 'type' => 'avglanding'])
```

* `'user'` can be a user's id like `$user->id` or `3`  
* `'period'` can be any number of days (like `15`, except 0 of course), `'currentm'`, `'lastm'`, `'prevm'`, `'currenty'`, `'lasty'`, `'q1'`, `'q2'`, `'q3'`, `'q4'`  
* `'disp'` can be `'full'` to display the results in a pre-defined card  
* `'type'` can be `'avglanding'`, `'avgscore'`, `'avgtime'`, '`tottime'`, `'avgdistance'`, `'totdistance'`, `'avgfuel'`, `'totfuel'` or `'totflight'`

Above example will give the average landing rate of that user for last month.

To save server resources, past time based results will be cached until the end of month or year. Others will be cached until the end of day.

### Random Flights

Picks up some random flights by following your phpVms settings and config options defined.

```php
@widget('DBasic::RandomFlights', ['count' => 3, 'hub' => true, 'daily' => true])
```

* `'count'` can be any number you wish like `3` (except 0 of course)
* `'daily'` can be `true` or `false`. Which will force widget to pick random flights once per day
* `'hub'` can be `true` or `false`. It will force the widget to pick up random flights departing from user's own hub/home airport

Above example will pick 3 random flights departing from that user's hub/home airport for that day.

In any config, random flights will be refreshed each day.

### Stable Approach

Show a pirep's Stable Approach Report in a modal.

* `'pirep'` should be the full pirep model (like `$pirep`)
* `'button'` can be either `true` or `false` (default is false). Changes the clickable item to a button (default is badge)

```php
@widget('DBasic::StableApproach', ['pirep' => $pirep])
@widget('DBasic::StableApproach', ['pirep' => $user->last_pirep, 'button' => true])
```

First example is for generic usage (ex. pirep details page), second one uses a bigger button and a user's last pirep (ex. user profile page)

### Statistics

Provides mainly pirep based statistics for an airline, aircraft or your entire v7 installation.

```php
@widget('DBasic::Stats', ['type' => 'aircraft', 'id' => $aircraft->id])
```

* `'type'` can be `'airline'` , `'aircraft'`, `'home'` (for generic but slightly reduced result set)
* `'id'` can be airline's or aircraft's numeric id like `$airline->id`, `$aircraft->id`, or just `3`

### Sunrise Sunset Details

Provides times related to sun's position for a given location.

```php
@widget('DBasic::SunriseSunset', ['location' => $airport->id, 'type' => 'civil', 'card' => true])
```

* `'location'` should be an airport's icao id like `$airport->id` or `LWSK`
* `'type'` can be `'civil'` or `'nautical'` (defines the twilight periods)
* `'card'` can be `true` or `false` (to display results in a card or just in a single line)

### Transfer Aircraft

Adds frontend pilot self aircraft transfer capability to phpVms v7.

```php
@widget('DBasic::TransferAircraft', ['price' => 'auto', 'landing' => 6])
```

* `'price'` can be `'free'`, `'auto'` or a fixed numeric value like `25000`
* `'list'` can be `'hub'` (ac parked at its hub), `'hubs'` (ac parked at any hub), `'nohubs'` (ac parked at non hub locations)
* `'aircraft'` can be an aircraft's id (like `$aircraft->id`) which removes the selection dropdown and transfers provided aircraft
* `'landing'` can be any number hours like `24` which blocks transfer of recently used/landed aircraft

Above example will calculate automatic transfer price according to great circle distance between airports and will allow only transfer of aircraft which are landed at least 6 hours from that time.
There is no `base` price definition for this widget. It uses airport fuel prices, that aircraft's average fuel consumption and ground handling costs.

### WhazzUp

Provides live server data for IVAO and VATSIM networks.

```php
@widget('DBasic::WhazzUp', ['network' => 'IVAO', 'field_name' => 'IVAO ID', 'refresh' => 300])
```

* `'network'` should be `'IVAO'` or `'VATSIM'`
* `'refresh'` can be any number in seconds greater than `15` (as per network requirements)
* `'field_name'` should be the exact custom profile field name you defined at phpvms > admin > users > custom fields page for that Network.

Providing a wrong `field name` value will result in `No Online .... flights found` result even if you have pilots flying online.

## Duplicating Module Blades/Views

Technically all blade files should work with your template but they are mainly designed for Bootstrap v5.* compatible themes. So if something looks weird in your template then you need to edit the blades files. I kindly suggest copying/duplicating them under your theme folder and do your changes there, directly editing module files will only make updating harder for you.

All Disposable Modules are capable of displaying customized files located under your theme folders;

* Original Location : phpvms root `/modules/DisposableBasic/Resources/views/widgets/some_file.blade.php`
* Target Location   : phpvms root `/resources/views/layouts/YourTheme/modules/DisposableBasic/widgets/some_file.blade.php`

As you can see from the above example, filename and sub-folder location is not changed. We only copy a file from a location to another and have a copied version of it.  
If you have duplicated blades and encounter problems after updating the module or after editing, just rename them to see if the provided original works fine.

## Release / Update Notes

XX.NOV.21

* Added support for receiving Stable Approach (X-Plane) reports.
* Added new widget for Stable Approach support

26.NOV.21

* Added some failsafe for positive (or zero) landing rates
* Italian translation (Thanks Fabietto for his support)

21.NOV.21

* Fix monetary value display issues (Airline overall finance)

18.NOV.21

* Fixed JumpSeat Travel widget's button (Quick Travel option)
* Recuded Discord widget's vertical size for crowded servers (it uses overflow-auto now)

16.NOV.21

* Initial Release
