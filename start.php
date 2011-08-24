<?php

	function profile_noindex_init(){
		// extend profile edit form
		elgg_extend_view("profile/edit", "profile_noindex/edit_profile", 400);
		
		// extend CSS
		elgg_extend_view("css", "profile_noindex/css");
	}

	function profile_noindex_pagesetup(){
		$page_owner = page_owner_entity();
		$context = get_context();
		
		if(in_array($context, array("profile", "friends", "friendsof")) && ($page_owner instanceof ElggUser)){
			if(get_plugin_usersetting("hide_from_search_engine", $page_owner->getGUID(), "profile_noindex") == "yes"){
				// protext against search engines
				elgg_extend_view("metatags", "profile_noindex/metatags");
				
				// remove FoaF link
				elgg_unextend_view("metatags", "profile/metatags");
				
				// remove RSS/Atom/ links
				register_plugin_hook("display", "view", "profile_noindex_view_hook");
			}
		}
	}
	
	function profile_noindex_view_hook($hook, $type, $returnvalue, $params){
		global $autofeed;
		$autofeed = false;
	}

	// register default Elgg events
	register_elgg_event_handler("init", "system", "profile_noindex_init");
	register_elgg_event_handler("pagesetup", "system", "profile_noindex_pagesetup");
	