<?php
	require_once("header.php");
	@include_once("../res/blog.inc.php");
?>
<div id="imAdminPage">
	<div id="imBody">
		<div class="imContent">
<?php
			$testedFolders = array();
			$test = new imTest();
			$test->doTest(true, $test->php_version_test(), l10n('admin_test_version') . ": " . PHP_VERSION, l10n('admin_test_version_suggestion'));
			$test->doTest(true, $test->session_test(), l10n('admin_test_session'), l10n('admin_test_session_suggestion'));

			@chdir("../.");
			// Site root folder
			if (isset($imSettings['general']['public_folder'])) {
				$testedFolders[] = $imSettings['general']['public_folder'];
				$test->doTest(true, $test->writable_folder_test($imSettings['general']['public_folder']), l10n('admin_test_folder') . ($imSettings['general']['public_folder'] != "" ? " (" . $imSettings['general']['public_folder'] . ")": " (site root folder)"), l10n("admin_test_folder_suggestion"));
			}

			// Blog public folder
			if (isset($imSettings['blog']) && $imSettings['blog']['sendmode'] == 'file' && !in_array($imSettings['blog']['folder'], $testedFolders)) {
				$testedFolders[] = $imSettings['blog']['folder'];
				$test->doTest(true, $test->writable_folder_test($imSettings['blog']['folder']), l10n('admin_test_folder') . ($imSettings['blog']['folder'] != "" ? " (" . $imSettings['blog']['folder'] . ")": " (site root folder)"), l10n("admin_test_folder_suggestion"));
			}
			
			// Guestbooks public folder
			if (isset($imSettings['guestbooks'])) {
				foreach($imSettings['guestbooks'] as $gb) {
					if ($gb['sendmode'] == 'file') {
						// Check this folder only if it's different from the blog's one
						if (!in_array($gb['folder'], $testedFolders)) {
							$testedFolders[] = $gb['folder'];
							$test->doTest(true, $test->writable_folder_test($gb['folder']), l10n('admin_test_folder') . ($gb['folder'] != "" ? " (" . $gb['folder'] . ")" :  " (site root folder)"), l10n("admin_test_folder_suggestion"));
						}
					}
				}			
			}
			@chdir("admin");

			// Databases
			if (isset($imSettings['databases'])) {
				foreach($imSettings['databases'] as $db) {
					$tst = $test->mysql_test($db['host'], $db['user'], $db['password'], $db['database']);
					$test->doTest(true, $tst, l10n('admin_test_database') . " (" . $db['description'] . ")", l10n("admin_test_database_suggestion"));
				}
			}
			 
			if (isset($_POST['send'])) {
				$attachment = array();
				if (is_uploaded_file($_FILES['attachment']['tmp_name']) && file_exists($_FILES['attachment']['tmp_name'])) {
					$attachment = array(array(
						"name" => $_FILES['attachment']['name'],
						"mime" => $_FILES['attachment']['type'],
						"content" => file_get_contents($_FILES['attachment']['tmp_name'])
					));
				}
				$ImMailer->setEmailType($_POST['type']);
				$ImMailer->send($_POST['from'], $_POST['to'], $_POST['subject'], strip_tags($_POST['body']), nl2br($_POST['body']), $attachment);
				echo "<script>window.top.location.href = 'website_test.php';</script>";
			}
?>
		</div>
		<div class="imContent" style="margin-top: 15px; padding: 5px;">
			<h2 style="margin: 5px 0 15px 0; text-align: center;"><?php echo l10n('admin_test_email', 'Email form test'); ?></h2>
			<form action="website_test.php" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<td style="vertical-align: middle;">
							<label for="type"><?php echo l10n('form_script_type'); ?></label>
						</td>
						<td>
							<!-- enable disable the attachment field basing on the email type -->
							<select name="type" id="type" onchange="var a = $('#attachment, [for=attachment]'); $(this).val() == 'text' ? a.val('').hide(0) : a.show(0)">
								<option value="html"><?php echo l10n('form_script_type_html'); ?></option>
								<option value="html-x"><?php echo l10n('form_script_type_html_x'); ?></option>
								<option value="text"><?php echo l10n('form_script_type_text'); ?></option>
							</select>
							<a href="download.php?what=emaillibrary"><?php echo l10n("admin_download", "Download") ?></a>
						</td>
					</tr>
					<tr>
						<td>
							<label for="from"><?php echo l10n('form_from'); ?></label>
						</td>
						<td>
							<input type="text" name="from" id="from"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="to"><?php echo l10n('form_to'); ?></label>
						</td>
						<td>
							<input type="text" id="to" name="to"/>
						</td>
					</tr>
					<tr>
						<td>
							<label for="subject"><?php echo l10n('form_subject'); ?></label>
						</td>
						<td>
							<input type="text" id="subject" name="subject"/>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<textarea name="body" id="body" style="width: 99%;" rows="10"></textarea>	
						</td>
					</tr>
					<tr>
						<td>
							<label for="attachment"><?php echo l10n('form_attachment', 'Attachment: '); ?></label>
						</td>
						<td>
							<input type="file" name="attachment" id="attachment" />
						</td>
					</tr>
				</table>
				<div style="text-align: center; margin-top: 10px;">
					<input type="submit" value="<?php echo l10n('form_submit'); ?>" name="send">
					<input type="reset" value="<?php echo l10n('form_reset'); ?>">	
				</div>				
			</form>
			<script>$(document).ready(function () { $("#from").focus(); });</script>
<?php 
?>
		</div>
	</div>
</div>
<?php
require_once("footer.php");
?>
