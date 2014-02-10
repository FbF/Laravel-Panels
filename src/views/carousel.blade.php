<div class="carousel">
	<div class="carousel--inner">
		<ul class="carousel--list">
			@foreach ($panels as $panel)
			<li class="carousel--panel{{ !empty($panel->css_class) ? ' carousel--panel__' . $panel->css_class : '' }}">
				<div class="carousel--panel--img-cont" style="background-image: url({{ $panel->image_1_src }})">
					<img src="{{ $panel->image_1_src }}" class="carousel--panel--img" width="{{ $panel->image_1_width }}" height="{{ $panel->image_1_height }}" alt="{{ $panel->title }}" />
				</div>
				<div class="carousel--panel--text">
					<h3>{{ $panel->title }}</h3>
					<p>{{ $panel->description }}</p>
					<a href="{{ $panel->link_url }}" title="{{ $panel->title }}" class="btn btn__arrow">{{ $panel->link_text }}</a>
				</div>
			</li>
			@endforeach
		</ul>
	</div>

	@if (Fbf\LaravelCarousel\Panel::getImageConfig('image_2', null, 'show'))
	<ul class="carousel--nav">
		@foreach ($panels as $panel)
		<li class="carousel--nav--item{{ !empty($panel->css_class) ? ' carousel--nav--item__' . $panel->css_class : '' }}">
			<a href="{{ $panel->link_url }}" title="{{ $panel->title }}">
				<img src="{{ $panel->image_2_src }}" class="carousel--nav--img" width="{{ $panel->image_2_width }}" height="{{ $panel->image_2_height }}" alt="{{ $panel->title }}" />
				<span>{{ $panel->title }}</span>
			</a>
		</li>
		@endforeach
	</ul>
	@endif
</div>