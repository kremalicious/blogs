<?php
/*
	this is the sidebar
*/
include( AP_CORE_OPTIONS ); ?>
 <div class="sidebar the_<?php echo $sidebar; ?> span-3<?php echo $last; ?>">
	<ul>
         <!-- regular sidebar starts here -->
         <?php if ( !dynamic_sidebar(__('Sidebar','museum-core')) ) : ?>
         <?php endif; ?>
     </ul>
</div>