Event.observe(window, 'load', function() {
	function jsColor(mainId, exceptions){
		if($$(mainId).length){
			var selection = 'input.input-text:not('+ exceptions +')';
			var selected_items = $$(mainId)[0].select(selection);
			selected_items.each(function(val){
				new jscolor.color(val);
			});
		}
	}
	jsColor('#meigee_minimalism_design_base');
	jsColor('#meigee_minimalism_design_catlabels');
	jsColor('#meigee_minimalism_design_header', '#meigee_minimalism_design_header_header_border_width, #meigee_minimalism_design_header_links_dropdown_border_width, #meigee_minimalism_design_header_links_dropdown_divider_width, #meigee_minimalism_design_header_cart_dropdown_border_width, #meigee_minimalism_design_header_cart_dropdown_divider_width, #meigee_minimalism_design_header_login_input_border_width, #meigee_minimalism_design_header_login_divider_width');
	jsColor('#meigee_minimalism_design_menu', '#meigee_minimalism_design_menu_submenu_border_width, #meigee_minimalism_design_menu_submenu_borders_width');
	jsColor('#meigee_minimalism_design_headerslider');
	jsColor('#meigee_minimalism_design_content');
	jsColor('#meigee_minimalism_design_buttons', '#meigee_minimalism_design_buttons_buttons1_border_width, #meigee_minimalism_design_buttons_buttons2_border_width, #meigee_minimalism_design_buttons_quick_view_border_width');
	jsColor('#meigee_minimalism_design_products', '#meigee_minimalism_design_products_product_border_width');
	jsColor('#meigee_minimalism_design_social_links');
	jsColor('#meigee_minimalism_design_footer', '#meigee_minimalism_design_footer_footer_border_width');
});