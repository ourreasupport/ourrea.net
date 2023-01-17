(
	function( $ ) {
		'use strict';

		var MaxcoachGridHandler = function( $scope, $ ) {
			var $element = $scope.find( '.maxcoach-grid-wrapper' );

			$element.MaxcoachGridLayout();
		};

		$( window ).on( 'elementor/frontend/init', function() {
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-image-gallery.default', MaxcoachGridHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-testimonial-grid.default', MaxcoachGridHandler );
			elementorFrontend.hooks.addAction( 'frontend/element_ready/tm-product-categories.default', MaxcoachGridHandler );
		} );
	}
)( jQuery );
