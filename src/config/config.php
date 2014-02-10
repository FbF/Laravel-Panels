<?php

return array(

	'types' => array(

		'HOMEPAGE_CAROUSEL' => array(

			'title' => 'Homepage Carousel',

			'css_class' => array(

				'show' => true,

				'options' => array(
					'carousel-panel__latest-product' => 'Latest product',
					'carousel-panel__special-offer' => 'Special offer',
					'carousel-panel__news-article' => 'News article',
				),

			),

			'images' => array(

				'image_1' => array(

					'show' => true,

					'original' => array(

						'dir' => '/uploads/packages/fbf/laravel-panels/homepage_carousel/image_1/original/',

					),

					'sizes' => array(

						'resized' => array(

							'dir' => '/uploads/packages/fbf/laravel-panels/homepage_carousel/image_1/resized/',
							'width' => 800,
							'height' => 300,

						),

					),

				),

				'image_2' => array(

					'show' => true,

					'original' => array(

						'dir' => '/uploads/packages/fbf/laravel-panels/homepage_carousel/image_2/original/',

					),

					'sizes' => array(

						'resized' => array(

							'dir' => '/uploads/packages/fbf/laravel-panels/homepage_carousel/image_2/resized/',
							'width' => 80,
							'height' => 80,

						),

					),

				),

			),

		),

		'HOMEPAGE_ACCORDION' => array(

			'title' => 'Homepage Accordion',

			'css_class' => array(

				'show' => false,

			),

			'images' => array(

				'image_1' => array(

					'show' => true,

					'original' => array(

						'dir' => '/uploads/packages/fbf/laravel-panels/homepage_accordion/image_1/original/',

					),

					'sizes' => array(

						'resized' => array(

							'dir' => '/uploads/packages/fbf/laravel-panels/homepage_accordion/image_1/resized/',
							'width' => 150,
							'height' => 150,

						),

					),

				),

				'image_2' => array(

					'show' => false,

					'original' => array(

						'dir' => '/uploads/packages/fbf/laravel-panels/homepage_accordion/image_2/original/',

					),

					'sizes' => array(

						'resized' => array(

							'dir' => '/uploads/packages/fbf/laravel-panels/homepage_accordion/image_2/resized/',
							'width' => 150,
							'height' => 150,

						),

					),

				),

			),

		),

	),

	'seed' => array(

		'replace' => true,

	),

);