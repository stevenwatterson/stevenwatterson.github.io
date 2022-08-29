<?php
require_once("header.php");

$id = isset($_GET['id']) ? $_GET['id'] : "";

// If there's only one guestbook just show it and don't ask for more
if ($id == "" && count($imSettings['guestbooks']) < 2)
{
	$keys = array_keys($imSettings['guestbooks']);
	$id = $imSettings['guestbooks'][$keys[0]]['id'];
}
?>
<div id="imAdminPage">
	<div id="imBody">
		<div class="imContent">
			 <?php if (count($imSettings['guestbooks']) > 1): // Select a guestbook?>
 				<script type="text/javascript">
 					function showGb( obj ) {
 						var val = $( obj ).val();
 						if (val !== "")
 							window.top.location.href = "guestbook.php?id=" + val;
 						else
 							window.top.location.href = "guestbook.php";
 					}
 				</script>
				<select onchange="showGb(this)" style="width: 100%;">
					<option value=""><?php echo l10n("admin_guestbook_select", "Select a guestbook") ?></option>
<?php foreach($imSettings['guestbooks'] as $gbid => $gb): ?>
					<option value="<?php echo $gbid?>"<?php echo ($gbid == $id ? " selected" : "") ?>><?php echo $gb['pagetitle'] . " - " . (strlen($gb['celltitle']) ? $gb['celltitle'] : $gbid) ?></option>
<?php endforeach; ?>
				</select>
<?php endif; 
if ($id != ""):
// Show the comments of a guestbook ?>
  			<div class="imBlogPostComment">
 <?php
				$data = $imSettings['guestbooks'][$id];
				$gb = new ImTopic($id, "../");
				$gb->setPostUrl('guestbook.php?id=' . $id);
				switch($data['sendmode'])
				{
					case "file":
						$gb->loadXML($data['folder']);
					break;
				}
				if (count($gb->comments->getAll()))
				{
					$gb->showSummary($data['rating'], TRUE);
				}
				$gb->showAdminComments($data['rating'], $data['order']);
endif; ?>
			</div>
		</div>
	</div>
</div>
<?php require_once("footer.php"); ?>
