<?php
/**
 * Toptags Plugin
 *
 * @package toptags
 * @author Dmitri Beliavski
 * @copyright (c) 2025 sed.by
 */

defined('COT_CODE') or die('Wrong URL');

 // define globals
define('SEDBY_TOPTAGS_REALM', '[SEDBY] Toptags');

function sedby_toptags($tpl = 'toptags', $items = 10, $tt_cache = '', $tt_ttl = 0) {

  if (Cot::$cache && !empty($tt_cache) && ((int)$tt_ttl > 0)) {
    $enableCache = true;
    $cache_name = str_replace(' ', '_', $tt_cache);
  }

  if ($enableCache && Cot::$cache->db->exists($tt_cache, SEDBY_TOPTAGS_REALM)) {
    $output = Cot::$cache->db->get($cache_name, SEDBY_TOPTAGS_REALM);
  } else {

    global $db_tag_references;

    $t = new XTemplate(cot_tplfile($tpl, 'plug'));

    $query = "SELECT *, COUNT(tag) AS tagQTY
    FROM $db_tag_references
    GROUP BY tag, tag_area
    ORDER BY tagQTY DESC
    LIMIT $items";

    $res = Cot::$db->query($query);
    $jj = 1;

    while ($row = $res->fetch()) {
      $t->assign(array(
        'PAGE_ROW_NUM'     => $jj,
        'PAGE_ROW_ODDEVEN' => cot_build_oddeven($jj),

        'PAGE_ROW_TAG' => $row['tag'],
        'PAGE_ROW_URL' => cot_url('tags', array('a' => $row['tag_area'] == 'page' ? 'pages' : 'forums', 't' => $row['tag'])),
      ));

      $t->parse("MAIN.PAGE_ROW");
      $jj++;
    }

    $t->parse();
    $output = $t->text();

    if ($enableCache) {
      Cot::$cache->db->store($tt_cache, $output, SEDBY_TOPTAGS_REALM, (int)$tt_ttl);
    }
  }
  return $output;
}
