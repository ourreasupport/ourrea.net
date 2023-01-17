var GOLO_STRIPE = GOLO_STRIPE || {};
(
	function( $ ) {
		'use strict';
		
		GOLO_STRIPE = {
			init: function() {
				var current = $( 'input[name="payment_method"]:checked' ).val();
				if ( current == 'stripe' ) {
					GOLO_STRIPE.setupForm();
				}
				$( 'input[name="payment_method"]' ).on( 'change', function() {
					var current = $( 'input[name="payment_method"]:checked' ).val();
					$( '#learn-press-checkout' ).removeClass( 'pay-with-stripe' );
					if ( current == 'stripe' ) {
						$( '#learn-press-checkout' ).addClass( 'pay-with-stripe' );
						GOLO_STRIPE.setupForm();
					}
				} );
			},

			setupForm: function() {
				var self  = this,
				    $form = $( '#learn-press-checkout.pay-with-stripe' );

				if ( $form.length === 0 ) {
					return;
				}
				var formId = $form.attr( 'id' );
				// Set formData array index of the current form ID to match the localized data passed over for form settings.
				var formData = tm_stripe_vars[ 'tm_stripe_per_package' ];
				// Variable to hold the Stripe configuration.
				var stripeHandler = null;
				var $submitBtn = $form.find( '#learn-press-checkout-place-order' );

				if ( $submitBtn.length ) {
					stripeHandler = StripeCheckout.configure( {
						// Key param MUST be sent hgolo instead of stripeHandler.open().
						key: formData.key,
						token: function( token, args ) {
							$( '<input>' ).attr( {
								type: 'hidden',
								name: 'stripeToken',
								value: token.id
							} ).appendTo( $form );

							$( '<input>' ).attr( {
								type: 'hidden',
								name: 'stripeTokenType',
								value: token.type
							} ).appendTo( $form );

							if ( token.email ) {
								$( '<input>' ).attr( {
									type: 'hidden',
									name: 'stripeEmail',
									value: token.email
								} ).appendTo( $form );
							}
							$form.submit();
						},
					} );

					$submitBtn.on( 'click', function( event ) {
						var current = $( 'input[name="payment_method"]:checked' ).val();
						if ( current == 'stripe' ) {
							event.preventDefault();
							stripeHandler.open( formData.params );
						}
					} );
				}

				// Close Checkout on page navigation:
				window.addEventListener( 'popstate', function() {
					if ( stripeHandler != null ) {
						stripeHandler.close();
					}
				} );

			}

		};

		$( document ).ready( function() {
			GOLO_STRIPE.init();
		} );

	}
)( jQuery );
