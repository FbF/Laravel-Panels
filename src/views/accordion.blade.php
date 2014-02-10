<div class="js-accordion">
	<div class="js-accordion--inner">
		<ul class="js-accordion--list">
			@foreach ($panels as $panel)
			<li class="js-accordion--item{{ !empty($panel->css_class) ? ' js-accordion--item__' . $panel->css_class : '' }}">
				<h4 class="js-accordion--item--header js-accordion--item--button">{{ $panel->title }}</h4>
				<div class="js-accordion--item--content">
					<img class="js-accordion--item--content--img" width="{{ $panel->image_1_width }}" height="{{ $panel->image_1_height }}" alt="{{ $panel->title }}" src="{{ $panel->image_1_src }}" />
					<p class="js-accordion--item--content--intro">{{ $panel->description }}</p>
					<a class="js-accordion--item--content--link btn btn__arrow" href="{{ $panel->link_url }}" title="{{ $panel->title }}">{{ $panel->link_text }}</a>
				</div>
			</li>
			@endforeach
		</ul>
	</div>
</div>