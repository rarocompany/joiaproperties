/**
 * Common scripts for Admin
 *
 * @package   PT_Content_Views_Pro
 * @author    PT Guy <http://www.contentviewspro.com/>
 * @license   GPL-2.0+
 * @link      http://www.contentviewspro.com/
 * @copyright 2014 PT Guy
 */

( function ( $ ) {
	"use strict";

	$.PT_CV_Admin_Pro = $.PT_CV_Admin_Pro || { };
	PT_CV_ADMIN_PRO = PT_CV_ADMIN_PRO || { };
	PT_CV_PUBLIC = PT_CV_PUBLIC || { };
	ajaxurl = ajaxurl || { };
	var _prefix = PT_CV_PUBLIC._prefix;

	$.PT_CV_Admin_Pro = function ( options ) {
		this.options = options;

		this._search_by_title();
		this._colorpicker();
		this._public_trigger();
		this._live_filter();
		this._live_filter_style_settings();
		this._custom_field_sort();
		this._custom_field_filter();
		this._datepicker();
		this._custom_text_bg_color();
		this._duplicate_view();
		this._custom_trigger();
		this._popover();
		this._select2_for_font_families();
		this._padding_margin();
		this._sortable_params();
		this._toggle_select_terms();
		this._pagination_disable();
		this._shuffle_filter_constraint();
		this._toggle_field_settings();
		this._group_overlay_settings();

		// View type select2 with icons
		if ( $( '[name="' + _prefix + 'view-type"]' ).is( 'select' ) ) {
			var formatLayout = function ( layout ) {
				if ( !layout.id ) {
					return layout.text;
				}
				return '<span><img src="' + PT_CV_ADMIN_PRO.layout_image_dir + layout.id.toLowerCase() + '.png" class="cvp-layout-flag" /> ' + layout.text + '</span>';
			};

			$( '[name="' + _prefix + 'view-type"]' ).select2( {
				dropdownCssClass: 'cvp-layouts',
				formatResult: formatLayout,
				formatSelection: formatLayout
			} );
		}

		// Text align with icon
		var text_align = function ( align ) {
			if ( !align.id ) {
				return align.text;
			}
			var _class = ( ( align.id === 'justify' ) ? '' : 'align' ) + align.id;
			return '<span><span class="dashicons dashicons-editor-' + _class + '"></span> ' + align.text + '</span>';
		};
		$( '[name*="text-align"]' ).select2( {
			formatResult: text_align,
			formatSelection: text_align
		} );

		// Prevent clicking in filter options
		$( '.pt-params .' + _prefix + 'filter-bar a' ).click( function ( e ) {
			e.preventDefault();
		} );

		// Select 2 - Sortable
		$( '.' + _prefix + 'select2-sortable' ).select2Sortable( { bindOrder: 'sortableStop' } );
	};

	$.PT_CV_Admin_Pro.prototype = {
		/* Move text color & background color of Thumbnail overlay to a group, they are served 2 different selectors */
		_group_overlay_settings: function () {
			var $mask_text_color = $( '.' + _prefix + 'font-mask-text' );
			$( '.' + _prefix + 'text-color', $mask_text_color ).insertBefore( $( '.' + _prefix + 'bg-color', '.' + _prefix + 'font-mask' ) );
			$mask_text_color.parent().remove();
		},
		/**
		 * Search post by title
		 * @returns {undefined}
		 */
		_search_by_title: function () {

			var _nonce = PT_CV_ADMIN_PRO._nonce;
			var content_type = '[name="' + _prefix + 'content-type' + '"]';

			// Send ajax request to search posts by Title
			var fn_search_by_title = function ( _title, callback ) {
				var _post_type;
				if ( $( content_type ).is( 'input:radio' ) ) {
					_post_type = $( content_type + ':checked' ).val();
				} else {
					_post_type = $( content_type ).val();
				}

				// Data to query
				var data = {
					ajax_nonce: _nonce,
					action: 'search_by_title',
					data: 'search_title=' + _title + '&post_type=' + _post_type
				};

				// Sent POST request
				$.ajax( {
					type: "POST",
					url: ajaxurl,
					data: data,
					dataType: 'json'
				} ).done( function ( response ) {
					if ( response === -1 ) {
						location.reload();
					}

					// Show options by callback of selectize
					callback( response );
				} );
			};

			// Use "selectize" to search, select, remove, drag & drop
			var fn_selectize = function ( $this ) {
				$this.selectize( {
					plugins: [ 'remove_button', 'drag_drop', 'restore_on_backspace' ],
					delimiter: ',',
					persist: false,
					valueField: 'id',
					labelField: 'title',
					searchField: 'title',
					createFilter: function ( input ) {
						var match, regex;
						regex = new RegExp( '\\d+' );
						match = input.match( regex );
						if ( match )
							return !this.options.hasOwnProperty( match[0] );

						return false;
					},
					create: true,
					hideSelected: true,
					closeAfterSelect: true,
					render: {
						item: function ( item, escape ) {
							return '<div>' +
								'<span class="title">' + escape( item.title ) + '</span>' +
								'</div>';
						},
						option: function ( item, escape ) {
							return '<div>' +
								'<span class="title">' + escape( item.title ) + '</span>' +
								'</div>';
						}
					},
					load: function ( query, callback ) {
						if ( !query.length )
							return callback();

						// Call ajax request to search posts by Title
						fn_search_by_title( query, callback );
					}
				} );
			};

			// Apply above functions for Post_in, Post_not_in fields
			var post_fields = new Array( $( '[name="' + _prefix + 'post__in"]' ), $( '[name="' + _prefix + 'post__not_in"]' ) );
			$.each( post_fields, function ( idx, value ) {
				fn_selectize( value );
			} );
		},
		/**
		 * WP Color picker
		 */
		_colorpicker: function () {
			if ( PT_CV_ADMIN_PRO.supported_version ) {
				$( '.' + _prefix + 'color' ).wpColorPicker();
			}
		},
		/**
		 * Trigger for Preview
		 */
		_public_trigger: function () {
			var $self = this;

			var $pt_cv_public_js_pro = new cvp_js( { _autoload: 0 } );
			$( 'body' ).bind( _prefix + 'admin-preview', function () {
				$pt_cv_public_js_pro.reset_after();
				$self._exclude_posts();
				$self._dragdrop_posts();
				$self._live_filter_reposition();

				$( window ).trigger( 'load' );
			} );
		},
		_dragdrop_posts: function () {

			var fn_sortable_posts_admin = function () {
				if ( !( $( '[name="' + _prefix + 'advanced-settings[]"][value="order"]' ).is( ':checked' ) && $( '[name="' + _prefix + 'orderby"]' ).first().val() === 'dragdrop' ) ) {
					return;
				}

				$( '.' + _prefix + 'page' ).not( ':hidden' ).sortable( { items: '.' + _prefix + 'content-item', update: function ( event, ui ) {
						var $page = $( ui.item ).closest( '.' + _prefix + 'page' );
						var cur_page = $page.data( 'id' ).replace( _prefix + 'page-', '' );
						var $fieldorderdd = $( '[name="' + _prefix + 'order-dragdrop-pids"]' ).first(),
							sindex = $fieldorderdd.val(),
							obj = sindex ? JSON.parse( sindex ) : { },
							cur_index = $page.sortable( 'toArray', { attribute: 'data-pid' } );

						obj[cur_page] = cur_index;
						$fieldorderdd.val( JSON.stringify( obj ) );
						$fieldorderdd.attr( 'value', JSON.stringify( obj ) );
					}, sort: function ( event, ui ) {
						/* Manually correct position of dragging item */
						//var $offset = $( ui.placeholder ).position();
						//$( ui.item ).css( 'left', $offset.left );

						$( ui.placeholder ).css( 'height', $( ui.item ).css( 'height' ) );
					} } );
			};
			$( 'body' ).bind( _prefix + 'pagination-finished', function () {
				fn_sortable_posts_admin();
			} );

			fn_sortable_posts_admin();
		},
		_live_filter_reposition: function () {
			var $wrapper = $( '.' + _prefix + 'wrapper' ), lfilters = '.cvp-live-filter';
			if ( $wrapper.children( lfilters ).length > 1 ) {
				$wrapper.sortable( {
					items: lfilters,
					update: function ( event, ui ) {
						var cur_index = $( ui.item ).closest( '.' + _prefix + 'wrapper' ).sortable( 'toArray', { attribute: 'data-name' } ),
							$field = $( '[name="' + _prefix + 'position-live-filters"]' );

						$field.val( cur_index );
						$field.attr( 'value', cur_index );
					}
				} );

				$wrapper.prepend( '<p class="text-center cvp-highlight">' + PT_CV_ADMIN_PRO.message.reposition_lf + '.</p>' );
			}
		},
		_custom_field_common: function ( this_prefix, ctf_table, tpl, ctf_class, ctf_live_filter_enable, toggle_relation, type ) {
			// Add field
			$( '#' + this_prefix + 'add' ).click( function ( e ) {
				e.preventDefault();

				// Append new row of setting to table
				ctf_table.append( tpl.clone().attr( 'class', ctf_class ) );
				ctf_table.find( '.' + ctf_class ).last().find( ctf_live_filter_enable ).trigger( 'ctf-add' );

				// Enable select2 for Field Name
				ctf_table.find( 'select.' + this_prefix + 'key' ).last().select2();

				if ( type === 'filterby' ) {
					// Trigger change for 'Field type' to display valid Operator
					ctf_table.find( '[name^="' + this_prefix + 'type"]' ).last().trigger( 'change' );

					// Toggle Relation option
					if ( typeof toggle_relation === 'function' ) {
						toggle_relation();
					}
				} else {
					ctf_table.find( '[name*="order-custom-field-type"]' ).last().trigger( 'change' );
				}

				// Toggle Preview button
				$( 'body' ).trigger( _prefix + 'preview-btn-toggle' );
			} );

			var get_ctf_item = function ( $this ) {
				return $this.closest( '.' + ctf_class );
			};

			// Delete field
			$( '.pt-wrap' ).on( 'click', '.' + this_prefix + 'delete', function ( e ) {
				e.preventDefault();

				if ( confirm( PT_CV_ADMIN_PRO.message.delete ) ) {
					get_ctf_item( $( this ) ).remove();
				}

				if ( type === 'filterby' ) {
					// Toggle Relation option
					toggle_relation();
				}

				// Toggle Preview button
				$( 'body' ).trigger( _prefix + 'preview-btn-toggle' );
			} );

			// Toggle Live Filter settings
			var ctf_live_filter_toggle_handle = function () {
				var toggle_ctf_live_filter_settings = function ( $checkbox ) {
					if ( $checkbox.is( ':checked' ) ) {
						$checkbox.closest( '.pt-form-group' ).nextAll( '.pt-form-group' ).removeClass( 'hidden' );

						if ( type === 'filterby' ) {
							// Hide backend settings: Operator to compare, Value to compare
							$checkbox.closest( '.pt-form-group' ).prev().addClass( 'hidden' );
							$checkbox.closest( '.pt-form-group' ).prev().prev().addClass( 'hidden' );
						}
					} else {
						$checkbox.closest( '.pt-form-group' ).nextAll( '.pt-form-group' ).addClass( 'hidden' );

						if ( type === 'filterby' ) {
							// Show backend settings: Operator to compare, Value to compare
							$checkbox.closest( '.pt-form-group' ).prev().removeClass( 'hidden' );
							$checkbox.closest( '.pt-form-group' ).prev().prev().removeClass( 'hidden' );
						}
					}
				};

				// Need the finish action, otherwise it won't work as expected
				$( '.pt-wrap' ).on( 'finish-do-dependence', function () {
					$( ctf_live_filter_enable ).each( function () {
						toggle_ctf_live_filter_settings( $( this ) );
					} );
				} );

				$( ctf_table ).on( 'change ctf-add', ctf_live_filter_enable, function () {
					toggle_ctf_live_filter_settings( $( this ) );
				} );
			};
			ctf_live_filter_toggle_handle();

			// Correct the checked status of checkbox of each custom field
			var ctf_live_filter_checkbox_handle = function () {
				$( 'body' ).on( _prefix + 'admin-preview-start', function () {
					$( 'input[type=checkbox]:not(:checked)', '.' + ctf_class ).each( function () {
						$( this ).attr( 'checked', true ).val( 0 );
					} );

					window.cvp_admin_form = $( '#' + _prefix + 'form-view' ).serialize();
				} );

				$( 'body' ).on( _prefix + 'admin-preview', function () {
					$( 'input[type=checkbox]:checked', '.' + ctf_class ).each( function () {
						if ( $( this ).val() === '0' ) {
							$( this ).attr( 'checked', false ).val( 'yes' );
						}
					} );
				} );

				$( '#' + _prefix + 'form-view' ).submit( function () {
					$( 'input[type=checkbox]:not(:checked)', '.' + ctf_class ).each( function () {
						$( this ).attr( 'checked', true ).val( 0 );
					} );
				} );
			};
			ctf_live_filter_checkbox_handle();

		},
		_live_filter: function () {
			// Toggle on change live filter type
			var selector = '[name*="live-filter-type"]';

			$( '.pt-wrap' ).on( 'finish-do-dependence', function () {
				var fn_do = function ( $this ) {
					var type = $this.val(), $group = $this.closest( '.ctf-item' );

					var $common_settings = $group.find( '.' + _prefix + 'live-filter-settings-common' ),
						$range_settings = $group.find( '.' + _prefix + 'live-filter-settings-range_slider' ),
						$date_settings = $group.find( '.' + _prefix + 'live-filter-settings-date_range' ),
						$operator_settings = $group.find( '.' + _prefix + 'live-filter-settings-operator' ),
						$default_text = $group.find( '.' + _prefix + 'live-filter-settings-default_text' );

					if ( type === 'range_slider' ) {
						$common_settings.hide();
						$date_settings.hide();
						$range_settings.show();
					} else if ( type === 'date_range' ) {
						$common_settings.hide();
						$date_settings.show();
						$range_settings.hide();

						$group.find( '[name*="' + _prefix + 'ctf-filter-type"]' ).val( 'DATE' );
					} else {
						$common_settings.show();
						$date_settings.hide();
						$range_settings.hide();
					}

					if ( type === 'checkbox' ) {
						$operator_settings.show();
					} else {
						$operator_settings.hide();
					}

					if ( [ 'radio', 'dropdown', 'button' ].indexOf( type ) >= 0 ) {
						$default_text.show();
					} else {
						$default_text.hide();
					}
				};

				$( '.pt-wrap' ).on( 'change', selector, function ( e ) {
					fn_do( $( this ) );
				} );

				$( '.pt-wrap' ).on( 'change', '[name*="ctf-filter-live-filter-enable"]', function ( e ) {
					fn_do( $( this ).closest( '.ctf-item' ).find( selector ) );
				} );

				$( selector, '.pt-wrap' ).each( function () {
					fn_do( $( this ) );
				} );
			} );

		},
		_live_filter_style_settings: function () {
			var lf_els = '[name*="live-filter-enable"]', $lf_sort = $( '[name="pt-cv-livesort-options[]"]' );

			var fn_count_lf = function () {
				var c = $( lf_els + ':checked' ).length;
				c += ( $lf_sort.val() !== null ) ? 1 : 0;

				$( '[class*="font-lf-"]', '#' + _prefix + 'style-settings' ).each( function () {
					if ( c > 0 ) {
						$( this ).parent().show();
					} else {
						$( this ).parent().hide();
					}
				} );
			};

			$( '.pt-wrap' ).on( 'finish-do-dependence', function () {
				fn_count_lf();
			} );

			$( lf_els ).on( 'change', function () {
				fn_count_lf();
			} );

			$lf_sort.on( 'change', function () {
				fn_count_lf();
			} );
		},
		_custom_field_sort: function () {
			var this_prefix = _prefix + 'ctf-sort-', ctf_class = 'ctf-sort-item', ctf_live_filter_enable = '[name="' + _prefix + 'order-custom-field-live-filter-enable[]"]';
			var ctf_table = $( '#' + _prefix + 'ctf-sort-list' );

			// Template HTML of Setting for a field
			var tpl = $( '.ctf-sort-tpl' );
			$( '.ctf-sort-tpl' ).remove();

			this._custom_field_common( this_prefix, ctf_table, tpl, ctf_class, ctf_live_filter_enable, null, 'sortby' );

			var get_ctf_item = function ( $this ) {
				return $this.closest( '.' + ctf_class );
			};

			// Toggle MySQL Date format field
			$( '.pt-wrap' ).on( 'finish-do-dependence', function () {
				var field_sort_type = '[name*="order-custom-field-type"]';

				var fn_do = function ( $this ) {
					var type = $this.val(), $date_field = get_ctf_item( $this ).find( '.' + _prefix + 'date-format' ), $tsc = get_ctf_item( $this ).find( '.' + _prefix + 'thousand-commas' );

					if ( type === 'DATE' || type === 'DATETIME' ) {
						$date_field.show();
					} else {
						$date_field.hide();
					}

					if ( type === 'NUMERIC' ) {
						$tsc.show();
					} else {
						$tsc.hide();
					}
				};

				$( '.pt-wrap' ).on( 'change', field_sort_type, function ( e ) {
					fn_do( $( this ) );
				} );

				$( field_sort_type, '.pt-wrap' ).each( function () {
					fn_do( $( this ) );
				} );
			} );
		},
		/**
		 * Custom field management
		 * @returns {undefined}
		 */
		_custom_field_filter: function () {
			var this_prefix = _prefix + 'ctf-filter-', ctf_class = 'ctf-item', ctf_live_filter_enable = '[name="' + this_prefix + 'live-filter-enable[]"]';
			var ctf_table = $( '#' + _prefix + 'ctf-list' );

			// Template HTML of Setting for a field
			var tpl = $( '.ctf-tpl' );
			$( '.ctf-tpl' ).remove();

			// Enable select2 for existed key
			ctf_table.find( 'select.' + this_prefix + 'key' ).select2();

			// Show/Hide the relation option
			var toggle_relation = function () {
				// Table of custom fields
				var ctf_list = $( '#' + _prefix + 'ctf-list' );
				// Number of custom fields
				var ctf_count = ctf_list.find( '.' + ctf_class ).length;

				// Relation group
				var ctf_relation = $( '.' + _prefix + 'ctf-relation' ).closest( '.pt-form-group' );

				if ( ctf_count > 1 ) {
					ctf_relation.show();
				} else {
					ctf_relation.hide();
				}
			};

			this._custom_field_common( this_prefix, ctf_table, tpl, ctf_class, ctf_live_filter_enable, toggle_relation, 'filterby' );

			var get_ctf_item = function ( $this ) {
				return $this.closest( '.' + ctf_class );
			};

			// Toggle placeholder of Value field
			var arr_comma_value_ope = new Array( 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' );
			var arr_date_no_val = new Array( 'TODAY', 'NOW_FUTURE', 'IN_PAST', 'EXISTS', 'NOT EXISTS' );
			var toggle_placeholder = function ( $this, operator_val ) {
				// Value field
				var $value = get_ctf_item( $this ).find( '[name^="' + this_prefix + 'value"]' ),
					$date_format = get_ctf_item( $this ).find( '.' + _prefix + 'date-format-ctf' );
				// Type field
				var $type = get_ctf_item( $this ).find( '[name^="' + this_prefix + 'type"]' );
				var type = $type.val();

				// Reset placeholder
				$value.attr( 'placeholder', '' );

				if ( $.inArray( operator_val, arr_comma_value_ope ) >= 0 ) {
					$value.attr( 'placeholder', 'Enter comma separated values' );
				} else if ( $.inArray( operator_val, arr_date_no_val ) >= 0 ) {
					$value.attr( 'placeholder', '' );
				} else {
					if ( type === 'BINARY' ) {
						$value.attr( 'placeholder', 'Enter 1 for True, 0 for False' );
					}
				}

				if ( type === 'DATE' || type === 'DATETIME' ) {
					$date_format.show();
				} else {
					$date_format.hide();
				}
			};

			// Toggle Operator base on Type
			$( '.pt-wrap' ).on( 'change', '[name^="' + this_prefix + 'type"]', function ( e ) {
				var type = $( this ).val();

				// Value field
				var $value = get_ctf_item( $( this ) ).find( '[name^="' + this_prefix + 'value"]' );

				if ( type === 'DATE' || type === 'DATETIME' ) {
					$value.datepicker( { changeMonth: true, changeYear: true, dateFormat: "yy/mm/dd", constrainInput: false } );

					$( '#' + _prefix + 'date-guide' ).removeClass( 'hidden' );
				} else {
					$value.datepicker( 'destroy' );

					$( '#' + _prefix + 'date-guide' ).addClass( 'hidden' );
				}

				// Get operator selectbox
				var $operator = get_ctf_item( $( this ) ).find( '[name^="' + this_prefix + 'operator"]' );
				var operator_val = $operator.val();

				toggle_placeholder( $( this ), operator_val );

				var $options = $operator.find( 'option' );
				// Hide all options
				$options.hide();

				// Show options for this type
				var $matched = $options.filter( function () {
					return $.inArray( $( this ).attr( 'value' ), PT_CV_ADMIN_PRO.custom_field.type_operator[type] ) >= 0;
				} );
				$matched.show();

				// If selected value is hidden => Set first option as new value
				if ( operator_val === '' || $operator.find( 'option[value="' + operator_val + '"]' ).css( 'display' ) === 'none' ) {
					$operator.val( $matched.first().attr( 'value' ) );
				}
			} );
			$( '[name^="' + this_prefix + 'type"]' ).trigger( 'change' );

			$( '.pt-wrap' ).on( 'change', '[name^="' + this_prefix + 'operator"]', function ( e ) {
				var operator_val = $( this ).val();
				toggle_placeholder( $( this ), operator_val );
			} );

			toggle_relation();
		},
		/**
		 * Show datepicker
		 * @returns {undefined}
		 */
		_datepicker: function () {
			$( '.' + _prefix + 'datepicker' ).datepicker( { changeMonth: true, changeYear: true, dateFormat: "yy/mm/dd" } );
		},
		/**
		 * Custom text for background color
		 * @returns {undefined}
		 */
		_custom_text_bg_color: function () {
			setTimeout( function () {
				$( '.wp-color-result', '.' + _prefix + 'text-color' ).attr( 'title', PT_CV_ADMIN_PRO.message.textcolor );
				$( '.wp-color-result', '.' + _prefix + 'bg-color' ).attr( 'title', PT_CV_ADMIN_PRO.message.bgcolor );

				// WP 4.9
				$( '.wp-color-result-text', '.' + _prefix + 'text-color' ).html( PT_CV_ADMIN_PRO.message.textcolor );
				$( '.wp-color-result-text', '.' + _prefix + 'bg-color' ).html( PT_CV_ADMIN_PRO.message.bgcolor );
			}, 500 );
		},
		/**
		 * Duplicate a View
		 * @returns {undefined}
		 */
		_duplicate_view: function () {
			// If this is 'duplicate' action
			var patt = /action=duplicate/g;
			if ( patt.test( window.location ) ) {

				$( 'body' ).css( { opacity: '0.1', cursor: 'progress' } );

				// Empty IDs
				$( '[name="' + _prefix + 'post-id' + '"]' ).val( 0 );
				$( '[name="' + _prefix + 'view-id' + '"]' ).val( 0 );

				// Append 'Copy' to View Title
				var $view_title = $( '[name="' + _prefix + 'view-title' + '"]' ).get( 0 );
				var view_title = $( $view_title ).val();
				if ( view_title !== '' ) {
					$( $view_title ).val( view_title + ' - Copy' );
				}

				// Trigger submit form
				$( '#' + _prefix + 'form-view' ).submit();
			}
		},
		/**
		 * Add custom trigger for functions
		 * @returns {undefined}
		 */
		_custom_trigger: function () {
			// Toggle Order Advanced Settings box
			var $order_advance_settings = $( '#' + _prefix + 'group-order #' + _prefix + 'group-advanced' );
			$( '.pt-wrap' ).on( 'content-type-change', function ( e, content_type ) {
				if ( content_type === 'product' ) {
					$order_advance_settings.removeClass( 'hidden' );
				} else {
					// Hide Order Advanced Settings box
					$order_advance_settings.addClass( 'hidden' );
				}
			} );

			// Toggle some settings of Shuffle Filter
			$( '.pt-wrap' ).on( _prefix + 'multiple-taxonomies', function ( e, is_multi ) {
				if ( is_multi ) {
					$( '.' + _prefix + 'for-multi-taxo' ).show();
				} else {
					$( '.' + _prefix + 'for-multi-taxo' ).hide();
				}
			} );
		},
		/**
		 * Show popover
		 *
		 * @returns {undefined}
		 */
		_popover: function () {
			$( '.pop-over-trigger' ).popover( { html: true, trigger: 'hover' } );
		},
		/**
		 * Enable select2 for font family
		 *
		 * @returns {undefined}
		 */
		_select2_for_font_families: function () {
			$( 'select[name*="' + _prefix + 'font-family"]' ).select2( { dropdownCssClass: _prefix + 'font-family' } );
		},
		_padding_margin: function () {
			$( '<span />', { 'class': 'glyphicon glyphicon-remove-circle', 'style': 'cursor: pointer; top: -15px;', 'click': function () {
					$( this ).parent().find( 'input' ).val( '' );
				} } ).appendTo( '.cv-padding-margin' );
		},
		/**
		 * Allow to sort Fields display, Meta fields
		 *
		 * @returns {undefined}
		 */
		_sortable_params: function () {
			$( '.' + _prefix + 'field-display' ).sortable( { items: '.form-group:not(.' + _prefix + 'thumb-position)', update: function ( event, ui ) {
					$( 'body' ).trigger( _prefix + 'preview-btn-toggle' );
				} } );
			$( '.' + _prefix + 'meta-fields-settings' ).sortable( { items: '.form-group', update: function ( event, ui ) {
					$( 'body' ).trigger( _prefix + 'preview-btn-toggle' );
				} } );
			$( '#' + _prefix + 'content-ads' ).sortable( { items: '.' + _prefix + 'ad-item', update: function ( event, ui ) {
				} } );
		},
		/**
		 * Show/hide Group of select terms quickly
		 * @returns {undefined}
		 */
		_toggle_select_terms: function () {
			$( '.' + _prefix + 'term-quick-filter' ).click( function () {
				$( this ).toggleClass( 'show' );
			} );
		},
		/**
		 * Disable pagination in some cases
		 *
		 * @returns {undefined}
		 */
		_pagination_disable: function () {
			var pagination_type = '[name="' + _prefix + 'pagination-type' + '"]',
				pagination_style = '[name="' + _prefix + 'pagination-style' + '"]',
				pagination_enable = '[name="' + _prefix + 'enable-pagination' + '"]';

			// Disable Numbered pagination
			var _do_disable = function () {
				$( pagination_style + '[value="regular"]' ).attr( 'disabled', true );

				if ( $( pagination_style + '[value="regular"]' ).is( ':checked' ) ) {
					// Uncheck it
					$( pagination_style + '[value="regular"]' ).attr( 'checked', false );

					// Select another option
					$( pagination_style + '[value="loadmore"]' ).attr( 'checked', true );
				}
			};

			var current_values = { viewtype: 'grid', shuffle: 0 };
			var should_disable = { viewtype: 'timeline', shuffle: 'yes' };
			var _check_disable = function ( type, value ) {
				current_values[type] = value;

				if ( current_values[type] === should_disable[type] ) {
					_do_disable();
				} else {
					if ( current_values.viewtype !== should_disable.viewtype && current_values.shuffle !== should_disable.shuffle ) {
						$( pagination_style ).removeAttr( 'disabled' );
					}
				}
			};

			// Constraint with View type
			var _with_view_type = function () {
				var view_type = '[name="' + _prefix + 'view-type' + '"]';
				var fn_selector = function () {
					var this_val;
					if ( $( view_type ).is( 'input:radio' ) ) {
						this_val = $( view_type + ':checked' ).val();
					} else {
						this_val = $( view_type ).val();
					}

					// Timeline
					_check_disable( 'viewtype', this_val );

					// Glossary
					if ( this_val === 'glossary' ) {
						if ( $( pagination_enable ).is( ':checked' ) ) {
							$( pagination_enable ).trigger( 'click' );
						}
						$( pagination_enable ).attr( 'checked', false );
						$( pagination_enable ).attr( 'disabled', true );
					} else {
						// Enable pagination
						$( pagination_enable ).removeAttr( 'disabled' );
					}
				};

				fn_selector();
				$( view_type ).change( function () {
					fn_selector();
				} );
			};
			_with_view_type();

			// Constraint with Shuffle Filter
			var _with_shuffle_filter = function () {
				var fn_selector = function ( this_val ) {
					_check_disable( 'shuffle', this_val );
				};

				var selector = '[name="' + _prefix + 'enable-taxonomy-filter' + '"]';
				// Run on page load
				fn_selector( $( selector + ':checked' ).val() );
				// Run on change
				$( selector ).change( function () {
					fn_selector( $( selector + ':checked' ).val() );
				} );
			};
			_with_shuffle_filter();

			// Constraint with Live Filter
			var _with_live_filter = function () {
				var selector = '[name*="live-filter-enable"]', pagination_enable = '[name="' + _prefix + 'enable-pagination' + '"]';

				var fn_constraint = function ( action ) {
					var disabled = action === 'add' ? true : false;

					$( pagination_type + '[value="normal"]' ).attr( 'disabled', disabled );

					$( pagination_style + '[value="infinite"]' ).attr( 'disabled', disabled );
					$( pagination_style + '[value="loadmore"]' ).attr( 'disabled', disabled );
					//$( pagination_style ).trigger( 'change' );

					if ( action === 'add' ) {
						$( pagination_style + '[value="regular"]' ).attr( 'checked', true );
					}

					if ( action === 'add' && $( pagination_enable ).is( ':checked' ) ) {
						$( '.cvp-show-on-lf-pagination' ).removeClass( 'hidden' );
					} else {
						$( '.cvp-show-on-lf-pagination' ).addClass( 'hidden' );
					}
				};

				// Run on page load (Need the finish action, otherwise it won't work as expected)
				var fn_check = function () {
					var count = 0;
					$( selector + ':checked' ).each( function () {
						if ( $( this ).val() !== '0' && $( this ).closest( '.hidden' ).length === 0 ) {
							count++;
						}
					} );

					if ( $( 'select[name*="livesort-options"]' ).val() !== null ) {
						count++;
					}

					if ( count ) {
						fn_constraint( 'add' );
					} else {
						fn_constraint( 'remove' );
					}
				};
				$( '.pt-wrap' ).on( 'finish-do-dependence finish-toggle-group', function () {
					fn_check();
				} );

				$( selector ).change( function () {
					fn_check();
				} );

				$( pagination_enable ).change( function () {
					fn_check();
				} );

				$( 'select[name*="livesort-options"]' ).change( function () {
					fn_check();
				} );
			};
			_with_live_filter();
		},
		/**
		 * Show alert/disable option has constraint with "Shuffle Filter" feature
		 * @returns {undefined}
		 */
		_shuffle_filter_constraint: function () {
			var $enable_shuffle = $( '[name="' + _prefix + 'enable-taxonomy-filter' + '"]' );
			var fn_enable_disable = function ( valid ) {
				if ( valid ) {
					$enable_shuffle.removeAttr( 'checked' );
					$enable_shuffle.attr( 'disabled', true );
					$enable_shuffle.trigger( 'change' );
				} else {
					// Enable
					$enable_shuffle.attr( 'disabled', false );
				}
			};

			var view_type = '[name="' + _prefix + 'view-type' + '"]';
			var fn_view_type = function () {
				var this_val;
				if ( $( view_type ).is( 'input:radio' ) ) {
					this_val = $( view_type + ':checked' ).val();
				} else {
					this_val = $( view_type ).val();
				}

				if ( typeof this_val === 'undefined' ) {
					return;
				}

				// Only works with Grid
				var expect_val = [ 'grid', 'pinterest', 'masonry', 'collapsible' ];
				fn_enable_disable( $.inArray( this_val, expect_val ) < 0 );
			};

			// Run on page load
			fn_view_type();
			// Run on change
			$( view_type ).change( function () {
				fn_view_type();
			} );
		},
		/* Toggle settings under Field Settings */
		_toggle_field_settings: function () {
			if ( !PT_CV_ADMIN_PRO.enable_toggle_settings ) {
				return;
			}

			// Field settings
			var $field_settings = $( '.' + _prefix + 'field-setting > .control-label' ).not( ':empty' );

			// Add + sign to label
			$field_settings.each( function () {
				$( this ).append( '<span class="setting-toggle-sign dashicons dashicons-plus"></span>' );
			} );

			// Show/Hide settings
			$( '.' + _prefix + 'field-setting > .control-label' ).on( 'toggle-setting', function ( e, status ) {
				$( this ).children( 'span' ).toggle( !status );

				// Related settings of this label
				var $related_settings = $( this ).next( '.pt-params' ).first();

				// Content settings
				if ( $( this ).parent( '.' + _prefix + 'content-setting' ).length > 0 ) {
					$related_settings = $related_settings.add( $( '.' + _prefix + 'excerpt-setting' ) );
				}

				// Meta-field settings
				if ( $( this ).parent( '.' + _prefix + 'metafield-setting' ).length > 0 ) {
					$related_settings = $related_settings.add( $( '.' + _prefix + 'metafield-extra' ) );
				}

				$related_settings.toggle( status );
			} );

			// Hide settings on page load
			$field_settings.each( function () {
				$( this ).trigger( 'toggle-setting', [ false ] );
			} );

			// Do action on click
			$( '.' + _prefix + 'field-setting > .control-label' ).on( 'click', function () {
				// Show settings of this
				$( this ).trigger( 'toggle-setting', [ true ] );

				// Select other settings (not this and not empty)
				$( '.' + _prefix + 'field-setting > .control-label' ).not( this ).not( ':empty' ).trigger( 'toggle-setting', [ false ] );
			} );
		},
		/**
		 * Show delete button to exclude posts
		 * @returns {undefined}
		 */
		_exclude_posts: function () {
			// Show button
			$( '.' + _prefix + 'content-item' ).each( function () {
				$( this ).prepend( '<span class="glyphicon glyphicon-eye-close" title="Hide this post"></span>' );
			} );

			// Click button
			$( '.glyphicon-eye-close', '.preview-wrapper' ).on( 'click', function ( e ) {
				e.preventDefault();

				var $not_in_field = $( '[name="' + _prefix + 'post__not_in"]' );
				var $selectize = $not_in_field.next( '.selectize-control' );

				// Trigger type ID to exclude field
				var post_id = $( this ).parent().attr( 'data-pid' );
				$selectize.find( 'input' ).attr( 'value', post_id );
				$selectize.find( 'input' ).trigger( 'keyup' );

				// Trigger click Add button
				$selectize.find( '.create' ).first().trigger( 'click' );

				// Highlight new added post
				$selectize.find( '.items' ).first().find( 'div' ).last().fadeOut( 100 ).fadeIn( 100 ).fadeOut( 100 ).fadeIn( 100, function () {
					// Refresh preview
					$( '#' + _prefix + 'show-preview' ).trigger( 'click' );
				} );
			} );
		}
	};

	$( function () {
		new $.PT_CV_Admin_Pro();
	} );
}( jQuery ) );