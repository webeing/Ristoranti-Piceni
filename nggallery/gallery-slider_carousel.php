<?php 
/**
Template Page for the gallery carousel

Follow variables are useable :

	$gallery     : Contain all about the gallery
	$images      : Contain all images, path, title
	$pagination  : Contain the pagination content
	$current     : Contain the selected image
	$prev/$next  : Contain link to the next/previous gallery page
	

 You can check the content when you insert the tag <?php var_dump($variable) ?>
 If you would like to show the timestamp of the image ,you can use <?php echo $exif['created_timestamp'] ?>
**/
?>
<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?><?php if (!empty ($gallery)) : ?>

<div class="ngg-galleryoverview">

	<ul class="ngg-thumbnail-carousel-list">
	
		<!-- PREV LINK -->	
		<?php if ($prev) : ?>
		<li class="ngg-prev">
			<a class="prev" href="<?php echo $prev ?>">&#9668;</a>
		</li>
		<?php endif; ?>
		
		<!-- Thumbnail list -->
		<?php foreach ( $images as $image ) : ?>
		<?php if ( $image->hidden ) continue; ?>
		<li id="ngg-image-<?php echo $image->pid ?>" class="ngg-thumbnail-carousel-list-item" >
			<a href="<?php echo $image->imageURL ?>" title="<?php echo $image->description ?>" class="fancybox" rel="fancygallery">
				<img width="230" title="<?php echo $image->alttext ?>" alt="<?php echo $image->alttext ?>" src="<?php echo $image->thumbnailURL ?>" />
			</a>
		</li>

	 	<?php endforeach; ?>
	 	
	 	<!-- NEXT LINK -->
		<?php if ($next) : ?>
		<li class="ngg-next">
			<a class="next" href="<?php echo $next ?>">&#9658;</a>
		</li>
		<?php endif; ?>
	 	
	</ul>
 	
</div>

<?php endif; ?>