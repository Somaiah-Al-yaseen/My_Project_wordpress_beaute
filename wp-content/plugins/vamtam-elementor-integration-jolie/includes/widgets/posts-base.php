<?php
namespace VamtamElementor\Widgets\PostsBase;

use ElementorPro\Modules\Posts\Skins\Skin_Classic as Elementor_Posts_Classic_Skin;
use ElementorPro\Modules\ThemeBuilder\Skins\Posts_Archive_Skin_Classic as Elementor_Archive_Posts_Classic_Skin;

// Extending the Posts/Posts_Archive widgets.

// Is Pro Widget.
if ( ! \VamtamElementorIntregration::is_elementor_pro_active() ) {
	return;
}

if ( vamtam_theme_supports( 'posts-base--extra-pagination-controls' ) ) {
    function add_extra_pagination_controls( $controls_manager, $widget ) {
        $widget->start_injection( [
            'of' => 'pagination_color_heading',
            'at' => 'before',
        ] );
        $widget->add_control(
            'show_pagination_border',
            [
                'label' => __( 'Border', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::SWITCHER,
                'label_off' => __( 'Hide', 'vamtam-elementor-integration' ),
                'label_on' => __( 'Show', 'vamtam-elementor-integration' ),
                'default' => 'yes',
                'return_value' => 'yes',
                'prefix_class' => 'elementor-show-pagination-border-',
            ]
        );
        $widget->add_control(
            'pagination_border_color',
            [
                'label' => __( 'Border Color', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'show_pagination_border' => 'yes',
                ],
            ]
        );
        $widget->add_control(
            'pagination_padding',
            [
                'label' => __( 'Padding', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::SLIDER,
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'size_units' => [ 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers' => 'padding: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
        $widget->end_injection();

        // Due to injection points getting messed up cause of the insertions of the tabs, we add the rest
        // at before_section_end cause otherwise the ACTIVE tab won't show.
        \Vamtam_Elementor_Utils::remove_tabs( $controls_manager, $widget, 'pagination_colors' );
        \Vamtam_Elementor_Utils::remove_control( $controls_manager, $widget, 'pagination_spacing' );
        \Vamtam_Elementor_Utils::remove_control( $controls_manager, $widget, 'pagination_spacing_top' );

        $widget->start_controls_tabs( 'pagination_colors' );

        $widget->start_controls_tab(
            'pagination_color_normal',
            [
                'label' => __( 'Normal', 'vamtam-elementor-integration' ),
            ]
        );

        $widget->add_control(
            'pagination_color',
            [
                'label' => __( 'Color', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers:not(.dots)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'pagination_bg_color',
            [
                'label' => __( 'Background Color', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers:not(.dots)' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'pagination_color_hover',
            [
                'label' => __( 'Hover', 'vamtam-elementor-integration' ),
            ]
        );

        $widget->add_control(
            'pagination_hover_color',
            [
                'label' => __( 'Color', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination a.page-numbers:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'pagination_hover_bg_color',
            [
                'label' => __( 'Background Color', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'pagination_color_active',
            [
                'label' => __( 'Active', 'vamtam-elementor-integration' ),
            ]
        );

        $widget->add_control(
            'pagination_active_color',
            [
                'label' => __( 'Color', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers.current' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'pagination_active_bg_color',
            [
                'label' => __( 'Background Color', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination .page-numbers.current' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $widget->end_controls_tab();
        $widget->end_controls_tabs();

        $widget->add_responsive_control(
            'pagination_spacing',
            [
                'label' => __( 'Space Between', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::SLIDER,
                'separator' => 'before',
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body:not(.rtl) {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:first-child)' => 'margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    'body.rtl {{WRAPPER}} .elementor-pagination .page-numbers:not(:last-child)' => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );

        $widget->add_responsive_control(
            'pagination_spacing_top',
            [
                'label' => __( 'Spacing', 'vamtam-elementor-integration' ),
                'type' => $controls_manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );
    }
    // Style - Pagination Section.
    function section_pagination_style_before_section_end( $widget, $args ) {
        $controls_manager = \Elementor\Plugin::instance()->controls_manager;
        add_extra_pagination_controls( $controls_manager, $widget );
    }

    // Theme Settings.
    if ( \Vamtam_Elementor_Utils::is_widget_mod_active( 'posts' ) ) {
        add_action( 'elementor/element/posts/section_pagination_style/before_section_end', __NAMESPACE__ . '\section_pagination_style_before_section_end', 10, 2 );
    }
    // Theme Settings.
    if ( \Vamtam_Elementor_Utils::is_widget_mod_active( 'archive-posts' ) ) {
        add_action( 'elementor/element/archive-posts/section_pagination_style/before_section_end', __NAMESPACE__ . '\section_pagination_style_before_section_end', 10, 2 );
    }
}

if ( vamtam_theme_supports( 'posts-base--display-categories' ) ) {
	// We need new Skin for displaying post categories.
	trait Vamtam_PostsBase_Classic_Skin_Overrides  {

		public function get_id() {
			return 'vamtam_classic';
		}

		public function get_title() {
			return esc_html__( 'Classic (Vamtam)', 'vamtam-elementor-integration' );
		}

		protected function render_meta_data() {
			/** @var array $settings e.g. [ 'author', 'date', ... ] */
			$settings = $this->get_instance_value( 'meta_data' );
			if ( empty( $settings ) ) {
				return;
			}
			?>
			<div class="elementor-post__meta-data">
				<?php
				if ( in_array( 'author', $settings ) ) {
					$this->render_author();
				}

				if ( in_array( 'date', $settings ) ) {
					$this->render_date_by_type();
				}

				if ( in_array( 'time', $settings ) ) {
					$this->render_time();
				}

				if ( in_array( 'comments', $settings ) ) {
					$this->render_comments();
				}

				if ( in_array( 'modified', $settings ) ) {
					$this->render_date_by_type( 'modified' );
				}

				if ( in_array( 'vamtam-categories', $settings ) ) {
					$this->render_categories();
				}
				?>
			</div>
			<?php
		}

		protected function render_categories() {
			?>
			<div class="vamtam-post__categories">
				<?php the_category( ', '); ?>
			</div>
			<?php
		}

		protected function render_post() {
			$this->render_post_header();
			$this->render_thumbnail();
			$this->render_meta_data();
			$this->render_text_header();
			$this->render_title();
			$this->render_excerpt();
			$this->render_read_more();
			$this->render_text_footer();
			$this->render_post_footer();
		}
	}

	// Posts
	class Skin_Vamtam_Posts_Classic extends Elementor_Posts_Classic_Skin {
		use Vamtam_PostsBase_Classic_Skin_Overrides;
	}
	// Archive Posts
	class Skin_Vamtam_Archive_Posts_Classic extends Elementor_Archive_Posts_Classic_Skin {
		use Vamtam_PostsBase_Classic_Skin_Overrides;
	}

	function update_meta_data_control_for_vamtam_classic_skin( $controls_manager, $widget ) {
		// Meta Data.
		\Vamtam_Elementor_Utils::add_control_options( $controls_manager, $widget, 'vamtam_classic_meta_data', [
			'options' => [
				'vamtam-categories' => esc_html__( 'Categories', 'vamtam-elementor-integration' ),
			],
		] );
    }

	function update_content_padding_control_for_vamtam_classic_skin( $controls_manager, $widget ) {
		// Content Padding.
		\Vamtam_Elementor_Utils::add_control_options( $controls_manager, $widget, 'vamtam_classic_content_padding', [
			'selectors' => [
				'{{WRAPPER}}' => '--vamtam-content-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
			],
		] );
    }

    // Content - Layout Section.
    function section_layout_before_section_end( $widget, $args ) {
        $controls_manager = \Elementor\Plugin::instance()->controls_manager;
        update_meta_data_control_for_vamtam_classic_skin( $controls_manager, $widget );
    }

	// Style - Box Section.
    function section_design_box_before_section_end( $widget, $args ) {
        $controls_manager = \Elementor\Plugin::instance()->controls_manager;
        update_content_padding_control_for_vamtam_classic_skin( $controls_manager, $widget );
    }

	// Theme Settings.
    if ( \Vamtam_Elementor_Utils::is_widget_mod_active( 'posts' ) ) {
		add_action( 'elementor/element/posts/section_layout/before_section_end', __NAMESPACE__ . '\section_layout_before_section_end', 11, 2 );
		add_action( 'elementor/element/posts/vamtam_classic_section_design_box/before_section_end', __NAMESPACE__ . '\section_design_box_before_section_end', 11, 2 );
	}
    // Theme Settings.
    if ( \Vamtam_Elementor_Utils::is_widget_mod_active( 'archive-posts' ) ) {
		add_action( 'elementor/element/archive-posts/section_layout/before_section_end', __NAMESPACE__ . '\section_layout_before_section_end', 11, 2 );
		add_action( 'elementor/element/archive-posts/vamtam_classic_section_design_box/before_section_end', __NAMESPACE__ . '\section_design_box_before_section_end', 11, 2 );
	}
}

// TODO: Temporary fix, remove when fixed: https://github.com/elementor/elementor/issues/12126
if ( vamtam_theme_supports( 'posts-base--404-handling-fix' ) ) {
	function vamtam_bypass_404_handling_on_posts_base_fetch( $bypass, $wp_query ) {
		$is_posts_base_fetch_req = isset( $_GET[ 'vamtam_posts_fetch' ] ) && $_GET[ 'vamtam_posts_fetch' ];
		$is_paged_req            = ( isset( $wp_query->query[ 'page' ] ) && $wp_query->query[ 'page' ] ); // on pages where 'paged' query_arg is used, this shouldn't be an issue. If it is we can just add a check fpr 'paged' as well.

		if (  $is_paged_req && $is_posts_base_fetch_req ) {
			// Bypass 404 handling for posts_base fetch requests (paged urls + vamtam_posts_fetch query_var), so there's no redirection that leads to invalid query results (always getting 1st page results).
			$bypass = true;
		}

		return $bypass;
	}
	// Theme Settings.
	if ( \Vamtam_Elementor_Utils::is_widget_mod_active( 'posts' ) || \Vamtam_Elementor_Utils::is_widget_mod_active( 'archive-posts' ) ) {
		add_filter( 'pre_handle_404', __NAMESPACE__ . '\vamtam_bypass_404_handling_on_posts_base_fetch', 10, 2 );
	}
}

// Fixes an issue where for queries with "Source" set to "Manual Selection", sticky posts are always included in the results.
function vamtam_ignore_sticky_posts_for_manual_selection_fix( $query_args, $widget ) {
	if ( ! $query_args[ 'ignore_sticky_posts' ] ) {
		$posts_source         = $widget->get_settings('posts_post_type');
		$exclude_sticky_posts = $posts_source === 'by_id' && isset( $query_args['post__in'] );

		if ( $exclude_sticky_posts ) {
			$query_args[ 'ignore_sticky_posts' ] = true;
		}
	}

	return $query_args;
}
add_action( 'elementor/query/query_args', __NAMESPACE__ . '\vamtam_ignore_sticky_posts_for_manual_selection_fix', 11, 2 );
