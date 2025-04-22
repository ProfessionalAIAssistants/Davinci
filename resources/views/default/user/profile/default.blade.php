@extends('layouts.app')

@section('css')
	<!-- Telephone Input CSS -->
	<link href="{{URL::asset('plugins/telephoneinput/telephoneinput.css')}}" rel="stylesheet" >
@endsection

@section('page-header')
	<!-- EDIT PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('Set Defaults') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{route('user.dashboard')}}"><i class="fa-solid fa-id-badge mr-2 fs-12"></i>{{ __('User') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{route('user.profile')}}"> {{ __('My Profile') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="{{url('#')}}"> {{ __('Set Defaults') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')
	<!-- EDIT USER PROFILE PAGE -->
	<div class="row">
		<div class="col-xl-3 col-lg-4 col-sm-12">
			<div class="card border-0" id="dashboard-background">
				<div class="widget-user-image overflow-hidden mx-auto mt-5"><img alt="User Avatar" class="rounded-circle" src="@if(auth()->user()->profile_photo_path){{ asset(auth()->user()->profile_photo_path) }} @else {{ theme_url('img/users/avatar.jpg') }} @endif"></div>
				<div class="card-body text-center">
					<div>
						<h4 class="mb-1 mt-1 font-weight-bold text-primary fs-16">{{ auth()->user()->name }}</h4>
						<h6 class="font-weight-bold fs-12">{{ auth()->user()->job_role }}</h6>
					</div>
				</div>
				
				<x-user-credits />

				<div class="card-footer p-0">
					<div class="row" id="profile-pages">
						<div class="col-sm-12">
							<div class="text-center pt-4">
								<a href="{{ route('user.profile') }}" class="fs-13"><i class="fa fa-user-shield mr-1"></i> {{ __('View Profile') }}</a>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="text-center pt-3">
								<a href="{{ route('user.profile.defaults') }}" class="fs-13 text-primary"><i class="   fa-solid fa-sliders mr-1"></i> {{ __('Set Defaults') }}</a>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="text-center p-3 ">
								<a href="{{ route('user.security') }}" class="fs-13"><i class="fa fa-lock-hashtag mr-1"></i> {{ __('Change Password') }}</a>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="text-center pb-4">
								<a href="{{ route('user.security.2fa') }}" class="fs-13"><i class="fa fa-shield-check mr-1"></i> {{ __('2FA Authentication') }}</a>
							</div>
						</div>
						@if (auth()->user()->group == 'user')
							@if (config('settings.personal_openai_api') == 'allow' || config('settings.personal_sd_api') == 'allow' || config('settings.personal_gemini_api') == 'allow' || config('settings.personal_claude_api') == 'allow')
								<div class="col-sm-12">
									<div class="text-center pb-3">
										<a href="{{ route('user.profile.api') }}" class="fs-13"><i class="fa-solid fa-key mr-1"></i> {{ __('Personal API Keys') }}</a>
									</div>
								</div>
							@endif
						@elseif (!is_null(auth()->user()->plan_id))
							@if ($check_api_feature->personal_openai_api || $check_api_feature->personal_sd_api || $check_api_feature->personal_gemini_api || $check_api_feature->personal_claude_api)
								<div class="col-sm-12">
									<div class="text-center pb-3">
										<a href="{{ route('user.profile.api') }}" class="fs-13"><i class="fa-solid fa-key mr-1"></i> {{ __('Personal API Keys') }}</a>
									</div>
								</div>
							@endif
						@elseif (auth()->user()->group == 'admin')
							@if (config('settings.personal_openai_api') == 'allow' || config('settings.personal_sd_api') == 'allow' || config('settings.personal_gemini_api') == 'allow' || config('settings.personal_claude_api') == 'allow')
								<div class="col-sm-12">
									<div class="text-center pb-3">
										<a href="{{ route('user.profile.api') }}" class="fs-13"><i class="fa-solid fa-key mr-1"></i> {{ __('Personal API Keys') }}</a>
									</div>
								</div>
							@endif
						@endif			
						<div class="col-sm-12">
							<div class="text-center pb-4">
								<a href="{{ route('user.profile.delete') }}" class="fs-13"><i class="fa fa-user-xmark mr-1"></i> {{ __('Delete Account') }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-9 col-lg-8 col-sm-12">
			<form method="POST" class="w-100" action="{{ route('user.profile.update.defaults') }}" enctype="multipart/form-data">
				@method('PUT')
				@csrf

				<div class="card border-0">
					<div class="card-header">
						<h3 class="card-title"><i class="   fa-solid fa-sliders mr-2 text-primary"></i>{{ __('Set Defaults') }}</h3>
					</div>
					<div class="card-body pb-0">					
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<!-- LANGUAGE -->
								<div class="input-box">	
									<h6>{{ __('Default AI Voiceover Studio Language') }}</h6>
									<select id="languages" name="default_voiceover_language" class="form-select" data-placeholder="{{ __('Select AI Voiceover Default Language') }}" data-callback="language_select">			
										@foreach ($languages as $language)
											<option value="{{ $language->language_code }}" data-img="{{ theme_url($language->language_flag) }}" @if (auth()->user()->default_voiceover_language == $language->language_code) selected @endif> {{ __($language->language) }}</option>
										@endforeach
									</select>
								</div> <!-- END LANGUAGE -->
							</div>

							<div class="col-md-6 col-sm-12">
								<!-- VOICE -->
								<div class="input-box">	
									<h6>{{ __('Default AI Voiceover Studio Voice') }}</h6>
									<select id="voices" name="default_voiceover_voice" class="form-select" data-placeholder="{{ __('Select Default Voice') }}">			
										@foreach ($voices as $voice)
											<option value="{{ $voice->voice_id }}" 		
												data-img="{{ theme_url($voice->avatar_url) }}"										
												data-id="{{ $voice->voice_id }}" 
												data-lang="{{ $voice->language_code }}" 
												data-type="{{ $voice->voice_type }}"
												data-gender="{{ $voice->gender }}"																						
												@if (auth()->user()->default_voiceover_voice == $voice->voice_id) selected @endif
												data-class="@if (auth()->user()->default_voiceover_language != $voice->language_code) remove-voice @endif"> 
												{{ $voice->voice }}  														
											</option>
										@endforeach
									</select>
								</div> <!-- END VOICE -->
							</div>

							<div class="col-md-6 col-sm-12">
								<div class="input-box">	
									<h6>{{ __('Default Language for Templates') }}</h6>								
									<select id="language" name="default_template_language" class="form-select" data-placeholder="{{ __('Select default language for templates') }}">		
										@foreach ($template_languages as $language)
											<option value="{{ $language->language_code }}" data-img="{{ theme_url($language->language_flag) }}" @if (auth()->user()->default_template_language == $language->language_code) selected @endif> {{ __($language->language) }}</option>
										@endforeach									
									</select>
								</div>
							</div>

							<div class="col-md-6 col-sm-12">
								<div class="form-group">	
									<h6 class="fs-11 mb-2 font-weight-semibold">{{ __('Default AI Model for Templates') }}</h6>								
									<select id="model" name="default_model_template" class="form-select" >		
										@foreach ($models as $model)
											@if (trim($model) == 'gpt-3.5-turbo-0125')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('GPT 3.5 Turbo') }}</option>
											@elseif (trim($model) == 'gpt-4')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('GPT 4') }}</option>
											@elseif (trim($model) == 'gpt-4o')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('GPT 4o') }}</option>
											@elseif (trim($model) == 'gpt-4o-mini')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('GPT 4o mini') }}</option>
											@elseif (trim($model) == 'gpt-4-0125-preview')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('GPT 4 Turbo') }}</option>
											@elseif (trim($model) == 'o1')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('o1') }}</option>
											@elseif (trim($model) == 'o1-mini')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('o1 mini') }}</option>
											@elseif (trim($model) == 'o3-mini')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('o3 mini') }}</option>
											@elseif (trim($model) == 'claude-3-opus-20240229')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('Claude 3 Opus') }}</option>
											@elseif (trim($model) == 'claude-3-7-sonnet-20250219')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('Claude 3.7 Sonnet') }}</option>
											@elseif (trim($model) == 'claude-3-5-sonnet-20241022')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('Claude 3.5v2 Sonnet') }}</option>
											@elseif (trim($model) == 'claude-3-5-haiku-20241022')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('Claude 3.5 Haiku') }}</option>
											@elseif (trim($model) == 'gemini-1.5-pro')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('Gemini 1.5 Pro') }}</option>
											@elseif (trim($model) == 'gemini-1.5-flash')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('Gemini 1.5 Flash') }}</option>
											@elseif (trim($model) == 'gemini-2.0-flash')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('Gemini 2.0 Flash') }}</option>
											@elseif (trim($model) == 'deepseek-chat')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('DeekSeek V3') }}</option>
											@elseif (trim($model) == 'deepseek-reasoner')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('DeepSeek R1') }}</option>
											@elseif (trim($model) == 'grok-2-1212')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('Grok 2') }}</option>
											@elseif (trim($model) == 'grok-2-vision-1212')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_template) selected @endif>{{ __('Grok 2 Vision') }}</option>
											@endif	
										@endforeach									
									</select>	
								</div>
							</div>

							<div class="col-md-6 col-sm-12">
								<div class="form-group">	
									<h6 class="fs-11 mb-2 font-weight-semibold">{{ __('Default AI Model for Chatbots') }}</h6>								
									<select id="model" name="default_model_chat" class="form-select" >		
										@foreach ($models as $model)
											@if (trim($model) == 'gpt-3.5-turbo-0125')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('GPT 3.5 Turbo') }}</option>
											@elseif (trim($model) == 'gpt-4')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('GPT 4') }}</option>
											@elseif (trim($model) == 'gpt-4o')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('GPT 4o') }}</option>
											@elseif (trim($model) == 'gpt-4o-mini')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('GPT 4o mini') }}</option>
											@elseif (trim($model) == 'gpt-4-0125-preview')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('GPT 4 Turbo') }}</option>
											@elseif (trim($model) == 'o1')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('o1') }}</option>
											@elseif (trim($model) == 'o1-mini')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('o1 mini') }}</option>
											@elseif (trim($model) == 'o3-mini')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('o3 mini') }}</option>
											@elseif (trim($model) == 'claude-3-opus-20240229')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('Claude 3 Opus') }}</option>
											@elseif (trim($model) == 'claude-3-7-sonnet-20250219')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('Claude 3.7 Sonnet') }}</option>
											@elseif (trim($model) == 'claude-3-5-sonnet-20241022')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('Claude 3.5v2 Sonnet') }}</option>
											@elseif (trim($model) == 'claude-3-5-haiku-20241022')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('Claude 3.5 Haiku') }}</option>
											@elseif (trim($model) == 'gemini-1.5-pro')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('Gemini 1.5 Pro') }}</option>
											@elseif (trim($model) == 'gemini-1.5-flash')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('Gemini 1.5 Flash') }}</option>
											@elseif (trim($model) == 'gemini-2.0-flash')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('Gemini 2.0 Flash') }}</option>
											@elseif (trim($model) == 'deepseek-chat')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('DeekSeek V3') }}</option>
											@elseif (trim($model) == 'deepseek-reasoner')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('DeepSeek R1') }}</option>
											@elseif (trim($model) == 'grok-2-1212')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('Grok 2') }}</option>
											@elseif (trim($model) == 'grok-2-vision-1212')
												<option value="{{ trim($model) }}" @if (trim($model) == auth()->user()->default_model_chat) selected @endif>{{ __('Grok 2 Vision') }}</option>
											@endif											
										@endforeach									
									</select>	
								</div>
							</div>
						</div>
						<div class="card-footer border-0 text-right mb-2 pr-0">
							<button type="submit" class="btn btn-primary">{{ __('Save') }}</button>							
						</div>					
					</div>				
				</div>
			</form>
		</div>
	</div>
	<!-- EDIT USER PROFILE PAGE --> 
@endsection

@section('js')
	<script src="{{theme_url('js/admin-config.js')}}"></script>
@endsection