<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$config['sitemaps_search_engines'] = array(
     array("host" => "www.google.com", "url" => "/webmasters/tools/ping?sitemap="),
    // array("host" => "search.yahooapis.com", "url" => "/SiteExplorerService/V1/ping?sitemap="),
    // array("host" => "submissions.ask.com"),
    array("host" => "www.bing.com", "url" => "/webmaster/ping.aspx?siteMap="),
    array("host" => "www.sitemapwriter.com", "url" => "/notify.php?crawler=all&url=")
);

/**
 * Compress the finished sitemap using gzencode,
 * and save it
 */
$config['sitemaps_gzip'] = TRUE;
$config['sitemaps_gzip_path'] = FCPATH.'sitemaps/{file_name}.gz';

/**
 * Same as the above two, but for sitemap indexes
 */
$config['sitemaps_index_gzip'] = FALSE;
$config['sitemaps_index_gzip_path'] = '{file_name}.gz';

/**
 * Debugging mode and various errors
 */
$config['sitemaps_debug'] = FALSE;
$config['sitemaps_filesize_error'] = TRUE;
$config['sitemaps_log_http_responses'] = TRUE;

/**
 * XML header and footer for sitemaps
 */
$config['sitemaps_header'] = "<\x3Fxml version=\"1.0\" encoding=\"UTF-8\"\x3F>\n" .
    "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n\t" .
    "xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n\t" .
    "xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n\t\t\t    " .
    "http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">";

$config['sitemaps_footer'] = "</urlset>\n";

/**
 * ...and indexes
 */
$config['sitemaps_index_header'] = "<\x3Fxml version=\"1.0\" encoding=\"UTF-8\"\x3F>\n" .
    "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";
$config['sitemaps_index_footer'] = "</sitemapindex>\n";

/**
 * User agent that is sent during ping
 */
$config['sitemaps_user_agent'] = "User-Agent: Mozilla/5.0 (compatible; " . PHP_OS . ") PHP/" . PHP_VERSION . "\r\n";