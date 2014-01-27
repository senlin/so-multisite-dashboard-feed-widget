<?php
$url = network_site_url('/feed/');
$rss = fetch_feed($url);
if (!is_wp_error($rss)) { // Checks that the object is created correctly
    // Figure out how many total items there are, but limit it to 3.
    $maxitems = $rss->get_item_quantity(3);
    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items(0, $maxitems);
}
if (!empty($maxitems)) {
?>
	<div class="rss-widget">
    	<ul>
<?php
    // Loop through each feed item and display each item as a hyperlink.
    foreach ($rss_items as $item) {

?>
			<li><a class="rsswidget" href='<?php echo $item->get_permalink(); ?>'><?php echo $item->get_title(); ?></a> <span class="rss-date"><?php echo $item->get_date('j F Y'); ?></span></li>
<?php } ?>
		</ul>
	</div>
<?php
}
?>