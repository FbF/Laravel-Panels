<?php namespace Fbf\LaravelPanels;

class Panel extends \Eloquent {

	/**
	 * Status values for the database
	 */
	const DRAFT = 'DRAFT';
	const APPROVED = 'APPROVED';

	/**
	 * Name of the table to use for this model
	 * @var string
	 */
	protected $table = 'fbf_panels';

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::creating(function(\Eloquent $model)
		{
			// Inserts panel at the end of the list for the given type
			$model->order = self::getOrderForNewRecord($model->type);
		});

		static::deleted(function($model)
		{
			// Moves right siblings left one space to fill the gap left by the deleted panel
			self::moveRightSiblingsLeft($model->order, $model->type);
		});
	}

	/**
	 * When inserting a new record, get the order value to be used for the given type
	 *
	 * @param $type
	 * @return mixed
	 */
	public static function getOrderForNewRecord($type)
	{
		return self::where('type', '=', $type)
			->count();
	}

	/**
	 * When deleting a record, the siblings of the deleted record's type, to the right of the deleted record should be
	 * moved left to fill the gap
	 *
	 * @param $order
	 * @param $type
	 * @return mixed
	 */
	public static function moveRightSiblingsLeft($order, $type)
	{
		return self::where('type', '=', $type)
			->where('order','>',$order)->decrement('order');
	}

	/**
	 * Returns true if the record with the given ID has any records, of the same type, to the left, or false if it is
	 * the leftmost record
	 *
	 * @param $id
	 * @return bool
	 */
	public static function hasLeftSibling($id)
	{
		$record = self::where('id','=',$id)
			->first();

		if (!$record)
		{
			return false;
		}

		$order = $record->order;

		return (bool)self::where('type', '=', $record->type)
			->where('order','<',$order)
			->count();
	}

	/**
	 * Moves the current record left one place, and the record that was there previously is moved right one place, i.e.
	 * the position of the current record is swapped with the record to it's left
	 * @return bool
	 */
	public function moveLeft()
	{
		try {
			// Moves the current panel left one
			$this->decrement('order');

			$newOrder = $this->order - 1;

			// Moves the panel that is now at the same 'order' as the panel we just moved, right one
			self::where('type', '=', $this->type)
				->where('order','=',$newOrder)
				->where('id','!=',$this->id)
				->increment('order');

			return true;

		} catch (\Exception $e) {
			return false;
		}

	}


	/**
	 * Returns true if the record with the given ID has any records, of the same type, to the right, or false if it is
	 * the rightmost record
	 * @param $id
	 * @return bool
	 */
	public static function hasRightSibling($id)
	{
		$record = self::where('id','=',$id)
			->first();

		if (!$record)
		{
			return false;
		}

		$order = $record->order;

		return (bool)self::where('type', '=', $record->type)
			->where('order','>',$order)
			->count();
	}

	/**
	 * Moves the current record right one place, and the record that was there previously is moved left one place, i.e.
	 * the position of the current record is swapped with the record to it's right
	 * @return bool
	 */
	public function moveRight()
	{
		try {
			// Moves the current panel right one
			$this->increment('order');

			$newOrder = $this->order + 1;

			// Moves the panel that is now at the same 'order' as the panel we just moved, right one
			self::where('type', '=', $this->type)
				->where('order','=',$newOrder)
				->where('id','!=',$this->id)
				->decrement('order');

			return true;

		} catch (\Exception $e) {
			return false;
		}

	}

	/**
	 * Returns a collection of Panel object for panels that are live, in the correct order, with the path, width and
	 * height of the images set on each panel.
	 *
	 * @param $type
	 * @return mixed
	 */
	public static function getData($type)
	{
		$panels = self::where('status','=',self::APPROVED)
			->where('published_date','<=',\Carbon\Carbon::now())
			->where('type', '=', $type)
			->orderBy('order', 'asc')
			->get();

		if (self::getImageConfig('image_1', null, 'show'))
		{
			$pathToImage1 = self::getImageConfig('image_1', 'resized', 'dir');
			$image1Width = self::getImageConfig('image_1', 'resized', 'width');
			$image1Height = self::getImageConfig('image_1', 'resized', 'height');
		}

		if (self::getImageConfig('image_2', null, 'show'))
		{
			$pathToImage2 = self::getImageConfig('image_2', 'resized', 'dir');
			$image2Width = self::getImageConfig('image_2', 'resized', 'width');
			$image2Height = self::getImageConfig('image_2', 'resized', 'height');
		}

		if (self::getImageConfig('image_1', null, 'show') || self::getImageConfig('image_2', null, 'show'))
		{
			foreach ($panels as $panel)
			{
				if (self::getImageConfig('image_1', null, 'show'))
				{
					$panel->image_1_src = $pathToImage1 . $panel->image_1;
					$panel->image_1_width = $image1Width;
					$panel->image_1_height = $image1Height;
				}
				if (self::getImageConfig('image_2', null, 'show'))
				{
					$panel->image_2_src = $pathToImage2 . $panel->image_2;
					$panel->image_2_width = $image2Width;
					$panel->image_2_height = $image2Height;
				}
			}
		}

		return $panels;
	}

	/**
	 * Returns the config setting for an image
	 *
	 * @param $type
	 * @param $size
	 * @param $property
	 * @return mixed
	 */
	public static function getImageConfig($type, $size, $property)
	{
		$config = 'laravel-carousel::images.' . $type . '.';
		if ($size == 'original')
		{
			$config .= 'original.';
		}
		elseif (!is_null($size))
		{
			$config .= 'sizes.' . $size . '.';
		}
		$config .= $property;
		return \Config::get($config);
	}

}
