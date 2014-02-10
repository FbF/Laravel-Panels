<?php

return array(

	/**
	 * Model title
	 *
	 * @type string
	 */
	'title' => 'Homepage Accordion',

	/**
	 * The singular name of your model
	 *
	 * @type string
	 */
	'single' => 'panel',

	/**
	 * The class name of the Eloquent model that this config represents
	 *
	 * @type string
	 */
	'model' => 'Fbf\LaravelPanels\Panel',

	/**
	 * The columns array
	 *
	 * @type array
	 */
	'columns' => array(
		'title' => array(
			'title' => 'Title',
			'sortable' => false,
		),
		'order' => array(
			'title' => 'Panel order',
		),
		'status' => array(
			'title' => 'Status',
			'select' => "CASE (:table).status WHEN '".Fbf\LaravelPanels\Panel::APPROVED."' THEN 'Approved' WHEN '".Fbf\LaravelPanels\Panel::DRAFT."' THEN 'Draft' END",
			'sortable' => false,
		),
		'published_date' => array(
			'title' => 'Published',
			'sortable' => false,
		),
		'updated_at' => array(
			'title' => 'Last Updated',
			'sortable' => false,
		),
	),

	/**
	 * The query filter option lets you modify the query parameters before Administrator begins to construct the query. For example, if you want
	 * to have one page show only deleted items and another page show all of the items that aren't deleted, you can use the query filter to do
	 * that.
	 *
	 * @type closure
	 */
	'query_filter'=> function($query)
		{
			$query->where('type','=','HOMEPAGE_ACCORDION');
		},

	/**
	 * The edit fields array
	 *
	 * @type array
	 */
	'edit_fields' => array(
		'type' => array(
			'value' => 'HOMEPAGE_ACCORDION',
			'visible' => false,
		),
		'title' => array(
			'title' => 'Title',
			'type' => 'text',
		),
		'summary' => array(
			'title' => 'Summary',
			'type' => 'textarea',
		),
		'link_text' => array(
			'title' => 'Link text',
			'type' => 'text',
		),
		'link_url' => array(
			'title' => 'Link URL (enter the relative URL, i.e. the bit after the domain, e.g. "/about", for a page on your site, or for external links, enter the full URL, including the "http://" part)',
			'type' => 'text',
		),
		'image_1' => array(
			'title' => 'Panel Image',
			'type' => 'image',
			'naming' => 'random',
			'location' => public_path(Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_1.original.dir')),
			'size_limit' => 5,
			'sizes' => array(
				array(
					Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_1.sizes.resized.width'),
					Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_1.sizes.resized.height'),
					'crop',
					public_path(Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_1.sizes.resized.dir')),
					100
				),
			),
			'visible' => Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_1.show'),
		),
		'image_2' => array(
			'title' => 'Icon Image',
			'type' => 'image',
			'naming' => 'random',
			'location' => public_path(Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_2.original.dir')),
			'size_limit' => 5,
			'sizes' => array(
				array(
					Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_2.sizes.resized.width'),
					Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_2.sizes.resized.height'),
					'crop',
					public_path(Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_2.sizes.resized.dir')),
					100
				),
			),
			'visible' => Config::get('laravel-panels::types.HOMEPAGE_ACCORDION.images.image_2.show'),
		),
		'status' => array(
			'type' => 'enum',
			'title' => 'Status',
			'options' => array(
				Fbf\LaravelPanels\Panel::DRAFT => 'Draft',
				Fbf\LaravelPanels\Panel::APPROVED => 'Approved',
			),
		),
		'published_date' => array(
			'title' => 'Published Date',
			'type' => 'datetime',
			'date_format' => 'yy-mm-dd', //optional, will default to this value
			'time_format' => 'HH:mm',    //optional, will default to this value
		),
		'created_at' => array(
			'title' => 'Created',
			'type' => 'datetime',
			'editable' => false,
		),
		'updated_at' => array(
			'title' => 'Updated',
			'type' => 'datetime',
			'editable' => false,
		),
	),

	/**
	 * This is where you can define the model's custom actions
	 */
	'actions' => array(
		// Ordering an item left
		'order_up' => array(
			'title' => 'Order Up / Left',
			'messages' => array(
				'active' => 'Reordering...',
				'success' => 'Reordered',
				'error' => 'There was an error while reordering',
			),
			'permission' => function($model)
				{
					// Get the ID of the record
					if (!Request::segment(3))
					{
						return true;
					}
					$id = Request::segment(3);
					// If there any siblings to the left of this panel, show the 'Order Up / Left' button
					return $model::hasLeftSibling($id);
				},
			//the model is passed to the closure
			'action' => function($model)
				{
					return $model->moveLeft();
				}
		),
		// Ordering an item down / right
		'order_down' => array(
			'title' => 'Order Down / Right',
			'messages' => array(
				'active' => 'Reordering...',
				'success' => 'Reordered',
				'error' => 'There was an error while reordering',
			),
			'permission' => function($model)
				{
					// Get the ID of the record
					if (!Request::segment(3))
					{
						return true;
					}
					$id = Request::segment(3);
					// If there any siblings to the right of this panel, show the 'Order Down / Right' button
					return $model::hasRightSibling($id);
				},
			//the model is passed to the closure
			'action' => function($model)
				{
					return $model->moveRight();
				}
		),

	),

	/**
	 * The validation rules for the form, based on the Laravel validation class
	 *
	 * @type array
	 */
	'rules' => array(
		'title' => 'required|max:25',
		'summary' => 'required|max:200',
		'link_text' => 'required|max:20',
		'link_url' => 'required|max:255',
		'image_1' => '',
		'image_2' => '',
		'css_class' => 'max:255',
		'status' => 'required',
		'published_date' => 'required',
	),

	/**
	 * The sort options for a model
	 *
	 * @type array
	 */
	'sort' => array(
		'field' => 'order',
		'direction' => 'asc',
	),

	/**
	 * If provided, this is run to construct the front-end link for your model
	 *
	 * @type function
	 */
	'link' => function($model)
		{
			return $model->link_url;
		},

);