<nav class="top-toolbar navbar navbar-mobile navbar-tablet">
	<ul class="navbar-nav nav-left">
		<li class="nav-item">
			<a href="javascript:void(0)" data-toggle-state="aside-left-open">
				<i class="icon dripicons-align-left"></i>
			</a>
		</li>
	</ul>
	<ul class="navbar-nav nav-center site-logo">
		<li>
			<a href="{{ url('/') }}">
				<span class="brand-text">SwingSpace</span>
			</a>
		</li>
	</ul>
	<ul class="navbar-nav nav-right">
		<li class="nav-item">
			<a href="javascript:void(0)" data-toggle-state="mobile-topbar-toggle">
				<i class="icon dripicons-dots-3 rotate-90"></i>
			</a>
		</li>
	</ul>
</nav>

<nav class="top-toolbar navbar navbar-desktop flex-nowrap">
	@guest
	@else
		<ul class="navbar-nav nav-left">
			<li class="nav-item nav-text dropdown dropdown-menu-md">
				<a href="javascript:void(0)">
					<span>
						{{ Auth::user()->user_type }}
					</span>
				</a>
			</li>
		</ul>
		<ul class="navbar-nav nav-right">
			<li class="nav-item dropdown">
				<a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<img src="{{ asset('img/default-profile.png') }}" class="w-35 rounded-circle" alt="{{ Auth::user()->firstname.' '.Auth::user()->lastname }}"> {{ Auth::user()->firstname.' '.Auth::user()->lastname }}
				</a>
				<div class="dropdown-menu dropdown-menu-right dropdown-menu-accout">
					<div class="dropdown-header pb-3">
						<div class="media d-user">
							<img class="align-self-center mr-3 w-40 rounded-circle" src="{{ asset(Auth::user()->photo) }}" alt="{{ Auth::user()->firstname.' '.Auth::user()->lastname }}">
							<div class="media-body">
								<h5 class="mt-0 mb-0">{{ Auth::user()->firstname.' '.Auth::user()->lastname }}</h5>
								<span>{{ Auth::user()->email }}</span>
							</div>
						</div>
					</div>
					<a class="dropdown-item" href="{{ url('profile') }}">
						<i class="icon dripicons-user"></i> <span data-localize="header.profile">@lang('header.profile')</span>
					</a>
					<a class="dropdown-item" id="translate_language" href="javascript:;" data-language="@if(Auth::user()->language == 'en') {{'ch'}} @else {{'en'}} @endif">
						<i class="icon dripicons-conversation"></i> 
							@if(Auth::user()->language == 'en')
								{{ 'Translate to Chinese' }} 
							@else
								{{ '翻译成英文' }}
							@endif
					</a>
					<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                		document.getElementById('logout-form').submit();">
                		<i class="icon dripicons-lock-open"></i> <span data-localize="header.signout">@lang('header.signout')</span>
                	</a>
                	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
		                @csrf
		            </form>
				</div>
			</li>
		</ul>
	@endguest
</nav>