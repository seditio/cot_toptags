# Cotonti Top Tags
This is a simple plugin-function that is used to output most popular hashtags with the following options:
1. Customizable output template
2. Variable number of hashtags
3. Optional caching

Installation is simple:
1. Download plugin
2. Upload it into the plugins folder
3. Install plugin from within the admin panel
4. Place callback function(s) & customize output template(s)
## Callback function
The plugin outputs hashtags via sedby_toptags() function with the following arguments:
```
sedby_toptags($tpl = 'toptags', $items = 10, $tt_cache = '' $tt_ttl = 0)
```
- $tpl defines template file (default toptags.tpl comes with the plugin package);
- $items defines number of hashtags;
- $tt_cache and $tt_ttl (if used together) turn on caching for the period of time specified by $tt_ttl.

Note: the function can use memory cache only if it is enabled in the config.php:
```
$cfg['cache'] = true;
```
