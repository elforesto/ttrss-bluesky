function blueskyArticle(id) {
	try {
		xhr.json("backend.php",	App.getPhArgs("bluesky", "getBlueSkyInfo", {id: id}),
			(reply) => {
				if (reply) {
					var share_url = "https://bsky.app/intent/compose?text="+ encodeURIComponent(reply.title)+ "%20"+encodeURIComponent(reply.link);
					console.log(share_url);
					window.open( share_url, 
								'_blank',
								'menubar=no,height=390,width=600,toolbar=no,scrollbars=no,status=no,dialog=0' );
				} else {
					Notify.error("<strong>Error encountered while initializing the Bluesky Plugin!</strong>", true);
				}
			});
	} catch (e) {
		Notify.error("blueskyArticle", e);
	}
}
