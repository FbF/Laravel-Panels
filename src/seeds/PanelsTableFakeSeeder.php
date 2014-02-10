<?php namespace Fbf\LaravelPanels;

class PanelsTableFakeSeeder extends \Seeder {

	public function run()
	{
		$replace = \Config::get('laravel-panels::seed.replace');
		if ($replace)
		{
			\DB::table('fbf_panels')->delete();
		}

		$faker = \Faker\Factory::create();

		$statuses = array(
			Panel::DRAFT,
			Panel::APPROVED
		);

		$types = \Config::get('laravel-panels::types');

		foreach ($types as $type => $options)
		{

			for ($i = 0; $i < 10; $i++)
			{
				$panel = new Panel();
				$panel->type = $type;
				$title = $faker->words(rand(2, 4), true);
				$panel->title = $title;
				$description = $faker->sentence(rand(10, 20));
				$panel->description = $description;
				$panel->link_text = 'Read more &raquo;';
				$panel->link_url = '#';
				foreach (range(1,2) as $imageNum)
				{
					$filename = null;
					$imageKey = 'image_' . $imageNum;
					$imageOptions = $options['images'][$imageKey];
					if ($imageOptions['show'])
					{
						foreach ($imageOptions['sizes'] as $size => $sizeOptions)
						{
							$image = $faker->image(
								public_path($sizeOptions['dir']),
								$sizeOptions['width'],
								$sizeOptions['height']
							);
							if (is_null($filename))
							{
								$filename = basename($image);
								copy($image, public_path($imageOptions['original']['dir']) . $filename);
							}
							else
							{
								rename($image, public_path($sizeOptions['dir']) . $filename);
							}
						}
						$panel->$imageKey = $filename;
					}
				}
				$panel->status = $faker->randomElement($statuses);
				$panel->published_date = $faker->dateTimeBetween('-1 year', '+1 month');
				$panel->save();
			}

		}
		echo 'Database seeded' . PHP_EOL;
	}
}