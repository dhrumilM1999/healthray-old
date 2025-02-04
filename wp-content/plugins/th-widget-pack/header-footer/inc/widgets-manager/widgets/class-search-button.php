<?php
/**
 * Elementor Classes.
 *
 * @package header-footer-elementor
 */

namespace THHF\WidgetsManager\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Border;
use \Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;   // Exit if accessed directly.
}

/**
 * HFE Search Button.
 *
 * HFE widget for Search Button.
 *
 * @since 1.5.0
 */
class Search_Button extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.5.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'thhf-search-button';
	}
 
        /**
        * get Plugin help URL
        * @return string help url
        */
        public function get_custom_help_url() {
            return 'https://help.themovation.com/' . $this->get_name();
        }
         
	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.5.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Search', 'header-footer-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.5.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'th-editor-icon-search';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.5.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'themo-site' ];
	}

	/**
	 * Retrieve the list of scripts the navigation menu depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.5.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'thhf-frontend-js' ];
	}

	/**
	 * Register Search Button controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->register_general_content_controls();
		$this->register_search_style_controls();
	}
	/**
	 * Register Search General Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_general_content_controls() {
		$this->start_controls_section(
			'section_general_fields',
			[
				'label' => __( 'Search Box', 'header-footer-elementor' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'        => __( 'Layout', 'header-footer-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'text',
				'options'      => [
					'text'      => __( 'Input Box', 'header-footer-elementor' ),
					'icon'      => __( 'Icon', 'header-footer-elementor' ),
					'icon_text' => __( 'Input Box With Button', 'header-footer-elementor' ),
				],
				'prefix_class' => 'hfe-search-layout-',
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'search_icon',
			[
				'label' => __( 'Icon', 'header-footer-elementor' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-search',
					'library' => 'solid',
				],
				'condition'    => [
					'layout' => 'icon',
				],
			]
		);

		$this->add_control(
			'placeholder',
			[
				'label'     => __( 'Placeholder', 'header-footer-elementor' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Type & Hit Enter', 'header-footer-elementor' ) . '...',
			]
		);

		$this->add_responsive_control(
			'size',
			[
				'label'       => __( 'Size', 'header-footer-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 50,
				],
				'selectors'   => [
					'{{WRAPPER}} .hfe-search-form__container' => 'min-height: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .hfe-search-submit'      => 'min-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .thhf-search-form__input' => 'padding-left: calc({{SIZE}}{{UNIT}} / 5); padding-right: calc({{SIZE}}{{UNIT}} / 5)',
				],
				'condition'   => [
					'layout!' => 'icon',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();
	}
	/**
	 * Register Search Style Controls.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function register_search_style_controls() {
		$this->start_controls_section(
			'section_input_style',
			[
				'label' => __( 'Input', 'header-footer-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'input_typography',
				'selector' => '{{WRAPPER}} input[type="search"].thhf-search-form__input,{{WRAPPER}} .thhf-search-icon-toggle',
			]
		);

		$this->add_responsive_control(
			'input_icon_size',
			[
				'label'     => __( 'Width', 'header-footer-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 250,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .hfe-input-focus .thhf-search-icon-toggle input[type=search]' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'layout' => 'iconx',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_input_colors' );

		$this->start_controls_tab(
			'tab_input_normal',
			[
				'label'     => __( 'Normal', 'header-footer-elementor' ),
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'     => __( 'Text Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .thhf-search-form__input' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => __( 'Placeholder Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .thhf-search-form__input::placeholder' => 'color: {{VALUE}}',
				],
				'default'   => '#7A7A7A6B',
			]
		);

        $this->add_control(
            'input_text_color_icon',
            [
                'label'     => __( 'Text Color', 'header-footer-elementor' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .thhf-search-icon-toggle .thhf-search-form__input' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .thhf-search-button-wrapper .thhf-search-form-wrapper.active input[type=search]' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'layout' => 'icon',
                ],
            ]
        );
		$this->add_control(
			'input_background_color',
			[
				'label'     => __( 'Background Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ededed',
				'selectors' => [
					'{{WRAPPER}} .thhf-search-form__input, {{WRAPPER}} .hfe-input-focus .thhf-search-icon-toggle .thhf-search-form__input' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .thhf-search-icon-toggle .thhf-search-form__input' => 'background-color: transparent;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'input_box_shadow',
				'selector'  => '{{WRAPPER}} .hfe-search-form__container,{{WRAPPER}} input.thhf-search-form__input',
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);
		$this->add_control(
			'border_style',
			[
				'label'       => __( 'Border Style', 'header-footer-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'none',
				'label_block' => false,
				'options'     => [
					'none'   => __( 'None', 'header-footer-elementor' ),
					'solid'  => __( 'Solid', 'header-footer-elementor' ),
					'double' => __( 'Double', 'header-footer-elementor' ),
					'dotted' => __( 'Dotted', 'header-footer-elementor' ),
					'dashed' => __( 'Dashed', 'header-footer-elementor' ),
				],
				'selectors'   => [
					'{{WRAPPER}} .hfe-search-form__container ,{{WRAPPER}} .thhf-search-icon-toggle .thhf-search-form__input,{{WRAPPER}} .hfe-input-focus .thhf-search-icon-toggle .thhf-search-form__input' => 'border-style: {{VALUE}};',
				],
				'condition'   => [
					'layout!' => 'icon',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => __( 'Border Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'border_style!' => 'none',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .hfe-search-form__container, {{WRAPPER}} .thhf-search-icon-toggle .thhf-search-form__input,{{WRAPPER}} .hfe-input-focus .thhf-search-icon-toggle .thhf-search-form__input' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label'      => __( 'Border Width', 'header-footer-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top'    => '1',
					'bottom' => '1',
					'left'   => '1',
					'right'  => '1',
					'unit'   => 'px',
				],
				'condition'  => [
					'border_style!' => 'none',
				],
				'selectors'  => [
					'{{WRAPPER}} .hfe-search-form__container, {{WRAPPER}} .thhf-search-icon-toggle .thhf-search-form__input,{{WRAPPER}} .hfe-input-focus .thhf-search-icon-toggle .thhf-search-form__input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'layout!' => 'icon',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label'     => __( 'Border Radius', 'header-footer-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default'   => [
					'size' => 3,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .hfe-search-form__container, {{WRAPPER}} .thhf-search-icon-toggle .thhf-search-form__input,{{WRAPPER}} .hfe-input-focus .thhf-search-icon-toggle .thhf-search-form__input' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_focus',
			[
				'label'     => __( 'Focus', 'header-footer-elementor' ),
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);

		$this->add_control(
			'input_text_color_focus',
			[
				'label'     => __( 'Text Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hfe-input-focus .thhf-search-form__input:focus',
					'{{WRAPPER}} .thhf-search-button-wrapper input[type=search]:focus' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);

		$this->add_control(
			'input_placeholder_hover_color',
			[
				'label'     => __( 'Placeholder Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				
				'selectors' => [
					'{{WRAPPER}} .thhf-search-form__input:focus::placeholder' => 'color: {{VALUE}}',
				],
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);

		/*$this->add_control(
			'input_background_color_focus',
			[
				'label'     => __( 'Background Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hfe-input-focus .thhf-search-form__input:focus,
					{{WRAPPER}}.hfe-search-layout-icon .thhf-search-icon-toggle .thhf-search-form__input' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'input_box_shadow_focus',
				'selector'       =>
				'{{WRAPPER}} .thhf-search-button-wrapper.hfe-input-focus .hfe-search-form__container,
				 {{WRAPPER}} .thhf-search-button-wrapper.hfe-input-focus input.thhf-search-form__input',
				'fields_options' => [
					'box_shadow_type' => [
						'separator' => 'default',
					],
				],
				'condition'      => [
					'layout!' => 'icon',
				],
			]
		);

		$this->add_control(
			'input_border_color_focus',
			[
				'label'     => __( 'Border Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hfe-input-focus .hfe-search-form__container,
					 {{WRAPPER}} .hfe-input-focus .thhf-search-icon-toggle .thhf-search-form__input' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'layout!' => 'icon',
				],
			]
		);*/

		$this->end_controls_tab();

		$this->end_controls_tabs();
        /*
                $this->add_control(
                    'icon_text_color_focus',
                    [
                        'label'     => __( 'Focus Text Color', 'header-footer-elementor' ),
                        'type'      => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} .thhf-search-button-wrapper .thhf-search-form__input:focus' => 'color: {{VALUE}}',
                            //'{{WRAPPER}} .thhf-search-button-wrapper input[type=search]' => 'color: {{VALUE}}'
                        ],
                        'condition' => [
                            'layout' => 'icon',
                        ],
                        'separator' => 'before',
                    ]
                );

                        $this->add_control(
                            'icon_text_background_color_focus',
                            [
                                'label'     => __( 'Focus Background Color', 'header-footer-elementor' ),
                                'type'      => Controls_Manager::COLOR,
                                'default'   => '#ededed',
                                'selectors' => [
                                    '{{WRAPPER}} .thhf-search-form__input:focus' => 'background-color: {{VALUE}}',
                                ],
                                'condition' => [
                                    'layout' => 'icon',
                                ],
                            ]
                        );

                        $this->add_group_control(
                            Group_Control_Box_Shadow::get_type(),
                            [
                                'label'     => __( 'Focus Box Shadow', 'header-footer-elementor' ),
                                'name'           => 'icon_box_shadow_focus',
                                'selector'       =>
                                '{{WRAPPER}} .thhf-search-button-wrapper .thhf-search-form-wrapper.active input[type=search].thhf-search-form__input:focus',
                                'fields_options' => [
                                    'box_shadow_type' => [
                                        'separator' => 'default',
                                    ],
                                ],
                                'condition'      => [
                                    'layout' => 'icon',
                                ],
                            ]
                        );

                        $this->add_control(
                            'icon_border_style',
                            [
                                'label'       => __( 'Focus Border Style', 'header-footer-elementor' ),
                                'type'        => Controls_Manager::SELECT,
                                'default'     => 'none',
                                'label_block' => false,
                                'options'     => [
                                    'none'   => __( 'None', 'header-footer-elementor' ),
                                    'solid'  => __( 'Solid', 'header-footer-elementor' ),
                                    'double' => __( 'Double', 'header-footer-elementor' ),
                                    'dotted' => __( 'Dotted', 'header-footer-elementor' ),
                                    'dashed' => __( 'Dashed', 'header-footer-elementor' ),
                                ],
                                'selectors'   => [
                                    '{{WRAPPER}} .thhf-search-button-wrapper .thhf-search-form-wrapper.active input[type=search].thhf-search-form__input:focus' => 'border-style: {{VALUE}};',
                                ],
                                'condition'   => [
                                    'layout' => 'icon',
                                ],
                            ]
                        );

                        $this->add_control(
                            'icon_border_color_focus',
                            [
                                'label'     => __( 'Focus Border Color', 'header-footer-elementor' ),
                                'type'      => Controls_Manager::COLOR,
                                'selectors' => [
                                    '{{WRAPPER}} .thhf-search-button-wrapper .thhf-search-form-wrapper.active input[type=search].thhf-search-form__input:focus' => 'border-color: {{VALUE}};',
                                ],
                                'condition' => [
                                    'layout'             => 'icon',
                                    'icon_border_style!' => 'none',
                                ],
                            ]
                        );

                        $this->add_control(
                            'icon_border_width',
                            [
                                'label'      => __( 'Focus Border Width', 'header-footer-elementor' ),
                                'type'       => Controls_Manager::DIMENSIONS,
                                'size_units' => [ 'px' ],
                                'default'    => [
                                    'top'    => '1',
                                    'bottom' => '1',
                                    'left'   => '1',
                                    'right'  => '1',
                                    'unit'   => 'px',
                                ],
                                'condition'  => [
                                    'icon_border_style!' => 'none',
                                    'layout'             => 'icon',
                                ],
                                'selectors'  => [
                                    '{{WRAPPER}} .thhf-search-button-wrapper .thhf-search-form-wrapper.active input[type=search].thhf-search-form__input:focus' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                ],
                            ]
                        );

                        $this->add_control(
                            'icon_focus_border_radius',
                            [
                                'label'     => __( 'Border Radius', 'header-footer-elementor' ),
                                'type'      => Controls_Manager::SLIDER,
                                'range'     => [
                                    'px' => [
                                        'min' => 0,
                                        'max' => 200,
                                    ],
                                ],
                                'default'   => [
                                    'size' => 3,
                                    'unit' => 'px',
                                ],
                                'selectors' => [
                                    '{{WRAPPER}} .thhf-search-button-wrapper .thhf-search-form-wrapper.active input[type=search].thhf-search-form__input' => 'border-radius: {{SIZE}}{{UNIT}}',
                                ],
                                'condition' => [
                                    'layout' => 'icon',
                                ],
                                'separator' => 'before',
                            ]
                        );*/

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			[
				'label'     => __( 'Button', 'header-footer-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'icon_text',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_colors' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'header-footer-elementor' ),
			]
		);

		$this->add_control(
			'button_icon_color',
			[
				'label'     => __( 'Icon Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} button.hfe-search-submit' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#818a91',
				'selectors' => [
					'{{WRAPPER}} .hfe-search-submit' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'header-footer-elementor' ),
			]
		);

		$this->add_control(
			'button_text_color_hover',
			[
				'label'     => __( 'Text Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hfe-search-submit:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'button_background_color_hover',
			[
				'label'     => __( 'Background Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hfe-search-submit:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'icon_size',
			[
				'label'       => __( 'Icon Size', 'header-footer-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'     => [
					'size' => '16',
					'unit' => 'px',
				],
				'selectors'   => [
					'{{WRAPPER}} .hfe-search-submit' => 'font-size: {{SIZE}}{{UNIT}}'
				],
				'condition'   => [
					'layout!' => 'icon',
				],
				'separator'   => 'before',
				'render_type' => 'template',
			]
		);

		$this->add_responsive_control(
			'button_width',
			[
				'label'       => __( 'Width', 'header-footer-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'range'       => [
					'px' => [
						'max'  => 500,
						'step' => 5,
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .hfe-search-form__container .hfe-search-submit' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .hfe-close-icon-yes button#clear_with_button' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition'   => [
					'layout' => 'icon_text',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_toggle_style',
			[
				'label'     => __( 'Icon', 'header-footer-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'icon',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_toggle_color' );

		$this->start_controls_tab(
			'tab_toggle_normal',
			[
				'label' => __( 'Normal', 'header-footer-elementor' ),
			]
		);

		$this->add_control(
			'toggle_color',
			[
				'label'     => __( 'Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thhf-search-icon-toggle i' => 'color: {{VALUE}}; border-color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .thhf-search-icon-toggle svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_toggle_hover',
			[
				'label' => __( 'Hover', 'header-footer-elementor' ),
			]
		);

		$this->add_control(
			'toggle_color_hover',
			[
				'label'     => __( 'Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .thhf-search-icon-toggle i:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
                    '{{WRAPPER}} .thhf-search-icon-toggle svg:hover' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'toggle_icon_size',
			[
				'label'       => __( 'Icon Size', 'header-footer-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => [
					'size' => 15,
				],
				'selectors'   => [
					'{{WRAPPER}} .thhf-search-icon-toggle i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .thhf-search-icon-toggle' => 'width: {{SIZE}}{{UNIT}}',

				],
				'condition'   => [
					'layout' => 'icon',
				],
				'separator'   => 'before',
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		/*$this->start_controls_section(
			'section_close_icon',
			[
				'label'     => __( 'Close Icon', 'header-footer-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'icon',
				],
			]
		);

		$this->add_responsive_control(
			'close_icon_size',
			[
				'label'     => __( 'Size', 'header-footer-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'   => [
					'size' => '20',
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .hfe-search-form__container button#clear i:before,
					{{WRAPPER}} .thhf-search-icon-toggle button#clear i:before,
				{{WRAPPER}} .hfe-search-form__container button#clear-with-button i:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],

			]
		);

		$this->start_controls_tabs( 'close_icon_normal' );

		$this->start_controls_tab(
			'normal_close_button',
			[
				'label' => __( 'Normal', 'header-footer-elementor' ),
			]
		);
		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				
				'default'   => '#7a7a7a',
				'selectors' => [
					'{{WRAPPER}} .hfe-search-form__container button#clear-with-button,
					{{WRAPPER}} .hfe-search-form__container button#clear,
					{{WRAPPER}} .thhf-search-icon-toggle button#clear' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover_close_icon',
			[
				'label' => __( 'Hover', 'header-footer-elementor' ),
			]
		);

		$this->add_control(
			'hover_close_icon_text',
			[
				'label'     => __( 'Color', 'header-footer-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hfe-search-form__container button#clear-with-button:hover,
					{{WRAPPER}} .hfe-search-form__container button#clear:hover,
					{{WRAPPER}} .thhf-search-icon-toggle button#clear:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();*/

	}
	/**
	 * Render Search button output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.5.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'input',
			[
				'placeholder' => $settings['placeholder'],
				'class'       => 'thhf-search-form__input',
				'type'        => 'search',
				'name'        => 's',
				'title'       => __( 'Search', 'header-footer-elementor' ),
				'value'       => get_search_query(),

			]
		);

		$this->add_render_attribute(
			'container',
			[
				'class' => [ 'hfe-search-form__container' ],
				'role'  => 'tablist',
			]
		);
		?>
			<form class="thhf-search-button-wrapper" role="search" action="<?php echo home_url(); ?>" method="get">
				<?php if ( 'icon' === $settings['layout'] ) { ?>
					<div class="thhf-search-icon-toggle">
						<?php Icons_Manager::render_icon( $settings['search_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</div>
					<div class="thhf-search-form-wrapper">
						<input <?php echo $this->get_render_attribute_string( 'input' ); ?>>
						<div class="thhf-search-overlay-close"><?php esc_html_e( 'Close', 'header-footer-elementor' );?></div>
					</div>
				<?php } else { ?>
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container' ) ); ?>>
					<?php if ( 'text' === $settings['layout'] ) { ?>
						<input <?php echo $this->get_render_attribute_string( 'input' ); ?>>
							<button id="clear" type="reset">
								<i class="fas fa-times clearable__clear" aria-hidden="true"></i>
							</button>
					<?php } else { ?>
						<input <?php echo $this->get_render_attribute_string( 'input' ); ?>>
						<button id="clear-with-button" type="reset">
							<i class="fas fa-times" aria-hidden="true"></i>
						</button>
						<button class="hfe-search-submit" type="submit">
							<i class="fas fa-search" aria-hidden="true"></i>
						</button>
					<?php } ?>
				</div>
			<?php } ?>
			</form>
		<?php
	}
}
