<?php echo !defined("GUVENLIK") ? die("Vaoww! Bu ne cesaret?") : null;?><?php
$xml_Content .= '<?xml version="1.0" encoding="UTF-8"?>';
$xml_Content .= '<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
foreach ($mapLinks as $map){
$xml_Content .= '
<url>
<loc>'.$map['adres'].'</loc>
<lastmod>'.$timestamp.'</lastmod>
<priority>0.8</priority>
</url>
';
}
$xml_Content .= '</urlset>';
?>