<?php
	require_once("header.php");
	@include_once("../res/blog.inc.php");
?>
<div id="imAdminPage">
	<div id="imBody">
		<div class="imContent">
			<!-- Show the available categories -->
			<script>
			function showCategory( obj ) {
				var cat = $( obj ).val();
				if ( cat !== "" )
					window.top.location.href = '<?php echo basename($_SERVER['PHP_SELF']) ?>?category=' + cat;
				else
					window.top.location.href = '<?php echo basename($_SERVER['PHP_SELF']) ?>';
			}

			function showPost( obj, objcat ) {
				var post = $( obj ).val(),
					cat = $( objcat ).val();
				if ( post !== "" && cat !== "" )
					window.top.location.href = '<?php echo basename($_SERVER['PHP_SELF']) ?>?category=' + cat + '&post=' + post;
				else
					window.top.location.href = '<?php echo basename($_SERVER['PHP_SELF']) ?>';	
			}
			</script>
			<select name="category" id="category" onchange="showCategory(this)">
				<option value=""><?php echo l10n("admin_category_select", "Select a category:")?></option>
<?php foreach($imSettings['blog']['posts_cat'] as $category => $posts): ?>
				<option value="<?php echo $category ?>"<?php echo $category == @$_GET['category'] ? " selected" : "" ?>><?php echo str_replace("_", " ", $category) ?></option>
<?php endforeach; ?>
			</select>
<?php if (isset($_GET['category'])): ?>
			<select name="post" id="post" onchange="showPost(this, '#category')">
				<option value=""><?php echo l10n("admin_post_select", "Select a post:")?></option>
<?php foreach($imSettings['blog']['posts_cat'][$_GET['category']] as $post): ?>
				<option value="<?php echo $post ?>"<?php echo $post == @$_GET['post'] ? " selected" : "" ?>><?php echo $imSettings['blog']['posts'][$post]['title'] ?></option>
<?php endforeach; ?>
			</select>
<?php endif; ?>
<?php 
	if (isset($_GET['category']) && isset($_GET['post']))
	{
		$data = $imSettings['blog'];
		$topic = new ImTopic($data['file_prefix'] . 'pc' . $_GET['post'], "../");
		$topic->setPostUrl('blog.php?category=' . $_GET['category'] . '&post=' . $_GET['post']);
		switch($data['sendmode'])
		{
			case "file":
				$topic->loadXML($data['folder']);
			break;
		}
		if (count($topic->comments->getAll()))
		{
			$topic->showSummary($data['comment_type'] != "comment", TRUE);
		}
		$topic->showAdminComments($data['comment_type'] != "comment", $data['comments_order']);
	}
?>
		</div>
	</div>
</div>
<?php require_once("footer.php"); ?>
