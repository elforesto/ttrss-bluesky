<?php
class Bluesky extends Plugin {
	private $host;

	function about() {
		return array(1.0,
			"Share article on Bluesky",
			"@elforesto.bsky.social");
	}

	function api_version() {
		return 2;
	}

	function init($host) {
		$this->host = $host;
		$host->add_hook($host::HOOK_ARTICLE_BUTTON, $this);
	}

	function get_js() {
		return file_get_contents(dirname(__FILE__) . "/bluesky.js");
	}

	function hook_article_button($line) {
		$article_id = $line["id"];
		return "<img id=\"blueskyImgId\" src=\"plugins.local/bluesky/bluesky.png\"
			class='tagsPic' style=\"cursor : pointer;\"
			onclick=\"blueskyArticle($article_id)\"
			title='".__('Share on Bluesky')."'/>";
	}

	function getBlueskyInfo() {
		$id = $_REQUEST['id'];
		$sth = $this->pdo->prepare("SELECT title, link
				FROM ttrss_entries, ttrss_user_entries
				WHERE id = ? AND ref_id = id AND owner_uid = ?");
		$sth->execute([$id, $_SESSION['uid']]);
		if ($row = $sth->fetch()) {
			$title = truncate_string(strip_tags($row['title']), 100, '...');
			$article_link = $row['link'];
		}

		$source = 'button';		
		$result = json_encode(array("title" => $title, "link" => $article_link, "id" => $id));

		print $result;
	}
}
?>
