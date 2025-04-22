@extends('layouts.app')

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7 justify-content-center">
		<div class="page-leftheader text-center">
			<h4 class="page-title mb-0">{{ __('API Credit Management') }}</h4>
			<p class="fs-12 text-muted mb-2">{{__('Adjust the multiplier value accordingly if you wish to increase the charges associated with API consumption')}}</p>
			<ol class="breadcrumb mb-2 justify-content-center">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-microchip-ai mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.davinci.dashboard') }}"> {{ __('AI Management') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.davinci.configs') }}"> {{ __('AI Settings') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> {{ __('API Credit Management') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')						
	<div class="row justify-content-center">
		<div class="col-lg-8 col-md-12 col-sm-12">
			<div class="card border-0">
				<div class="card-body pt-6">									
					<form id="" action="{{ route('admin.davinci.configs.api.credit.store') }}" method="post" enctype="multipart/form-data">
						@csrf

						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6>{{ __('Credit Calculation Method') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<select id="model_charge_type" name="model_charge_type" class="form-select">			
										<option value="both" @if ( $config->model_charge_type  == 'both') selected @endif>{{ __('Count both Input and Output Tokens in the final cost') }}</option>
										<option value="input" @if ( $config->model_charge_type  == 'input') selected @endif>{{ __('Count only Input Tokens') }}</option>
										<option value="output" @if ( $config->model_charge_type  == 'output') selected @endif>{{ __('Count only Output Tokens') }}</option>
									</select>
								</div>								
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="input-box">	
									<h6>{{ __('Model Credits Naming') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<select id="model_credit_name" name="model_credit_name" class="form-select">			
										<option value="words" @if ( $config->model_credit_name  == 'words') selected @endif>{{ __('Use Words as model credits name') }}</option>
										<option value="tokens" @if ( $config->model_credit_name  == 'tokens') selected @endif>{{ __('Use Tokens as model credits name') }}</option>										
									</select>
								</div>	
							</div>

							@if (App\Services\HelperService::extensionCheckSaaS())
								<div class="col-lg-6 col-md-6 col-sm-12">
									<div class="input-box">	
										<h6>{{ __('Show Disabled Models in AI Chat') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
										<select id="model_disabled_vendors" name="model_disabled_vendors" class="form-select">			
											<option value="hide" @if ( $config->model_disabled_vendors  == 'hide') selected @endif>{{ __('Hide') }}</option>
											<option value="show" @if ( $config->model_disabled_vendors  == 'show') selected @endif>{{ __('Show') }}</option>										
										</select>
									</div>	
								</div>
							@endif
						</div>

						<hr>

						<h6 class="font-weight-bold text-center mb-6 mt-6 fs-14">{{ __('OpenAI Models') }}</h6>

						<div class="row pl-5 pr-5">							
							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('o3 mini') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>					
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="o3_mini_title" value="{{$credits->o3_mini_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="o3_mini_description" value="{{$credits->o3_mini_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('o3 mini') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="o3_mini_input_token" value="{{$credits->o3_mini_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('o3 mini') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="o3_mini_output_token" value="{{$credits->o3_mini_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="o3_mini_new" class="custom-switch-input" @if ($credits->o3_mini_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>		
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('o1') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="o1_title" value="{{$credits->o1_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="o1_description" value="{{$credits->o1_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('o1') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="o1_input_token" value="{{$credits->o1_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('o1') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="o1_output_token" value="{{$credits->o1_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="o1_new" class="custom-switch-input" @if ($credits->o1_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>		
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('o1 mini') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="o1_mini_title" value="{{$credits->o1_mini_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="o1_mini_description" value="{{$credits->o1_mini_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('o1 mini') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="o1_mini_input_token" value="{{$credits->o1_mini_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('o1 mini') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="o1_mini_output_token" value="{{$credits->o1_mini_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="o1_mini_new" class="custom-switch-input" @if ($credits->o1_mini_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>			
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('GPT 4.5') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_45_title" value="{{$credits->gpt_45_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_45_description" value="{{$credits->gpt_45_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4.5') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_45_input_token" value="{{$credits->gpt_45_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4.5') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_45_output_token" value="{{$credits->gpt_45_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gpt_45_new" class="custom-switch-input" @if ($credits->gpt_45_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>		
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('GPT 4') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4_title" value="{{$credits->gpt_4_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4_description" value="{{$credits->gpt_4_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4_input_token" value="{{$credits->gpt_4_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4_output_token" value="{{$credits->gpt_4_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gpt_4_new" class="custom-switch-input" @if ($credits->gpt_4_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>		
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('GPT 4 Turbo') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4_turbo_title" value="{{$credits->gpt_4_turbo_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4_turbo_description" value="{{$credits->gpt_4_turbo_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4 Turbo') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4_turbo_input_token" value="{{$credits->gpt_4_turbo_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4 Turbo') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4_turbo_output_token" value="{{$credits->gpt_4_turbo_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gpt_4_turbo_new" class="custom-switch-input" @if ($credits->gpt_4_turbo_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('GPT 4o') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4o_title" value="{{$credits->gpt_4o_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4o_description" value="{{$credits->gpt_4o_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4o') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4o_input_token" value="{{$credits->gpt_4o_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4o') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4o_output_token" value="{{$credits->gpt_4o_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gpt_4o_new" class="custom-switch-input" @if ($credits->gpt_4o_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('GPT 4o mini') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4o_mini_title" value="{{$credits->gpt_4o_mini_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4o_mini_description" value="{{$credits->gpt_4o_mini_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4o mini') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4o_mini_input_token" value="{{$credits->gpt_4o_mini_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4o mini') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4o_mini_output_token" value="{{$credits->gpt_4o_mini_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gpt_4o_mini_new" class="custom-switch-input" @if ($credits->gpt_4o_mini_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('GPT 4o Realtime') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4o_realtime_title" value="{{$credits->gpt_4o_realtime_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4o_realtime_description" value="{{$credits->gpt_4o_realtime_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4o Realtime') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4o_realtime_input_token" value="{{$credits->gpt_4o_realtime_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4o Realtime') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4o_realtime_output_token" value="{{$credits->gpt_4o_realtime_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gpt_4o_realtime_new" class="custom-switch-input" @if ($credits->gpt_4o_realtime_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('GPT 4o mini Realtime') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4o_mini_realtime_title" value="{{$credits->gpt_4o_mini_realtime_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_4o_mini_realtime_description" value="{{$credits->gpt_4o_mini_realtime_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4o mini Realtime') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4o_mini_realtime_input_token" value="{{$credits->gpt_4o_mini_realtime_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 4o mini Realtime') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_4o_mini_realtime_output_token" value="{{$credits->gpt_4o_mini_realtime_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gpt_4o_mini_realtime_new" class="custom-switch-input" @if ($credits->gpt_4o_mini_realtime_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('GPT 3.5 Turbo') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_35_turbo_title" value="{{$credits->gpt_35_turbo_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gpt_35_turbo_description" value="{{$credits->gpt_35_turbo_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 3.5 Turbo') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_35_turbo_input_token" value="{{$credits->gpt_35_turbo_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('GPT 3.5 Turbo') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gpt_35_turbo_output_token" value="{{$credits->gpt_35_turbo_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gpt_35_turbo_new" class="custom-switch-input" @if ($credits->gpt_35_turbo_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>
						</div>

						<hr>

						<h6 class="font-weight-bold text-center mb-6 mt-6 fs-14">{{ __('Anthropic Claude Models') }}</h6>

						<div class="row pl-5 pr-5">							
							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Claude 3 Opus') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="claude_3_opus_title" value="{{$credits->claude_3_opus_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="claude_3_opus_description" value="{{$credits->claude_3_opus_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Claude 3 Opus') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="claude_3_opus_input_token" value="{{$credits->claude_3_opus_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Claude 3 Opus') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="claude_3_opus_output_token" value="{{$credits->claude_3_opus_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="claude_3_opus_new" class="custom-switch-input" @if ($credits->claude_3_opus_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Claude 3.7 Sonnet') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="claude_37_sonnet_title" value="{{$credits->claude_37_sonnet_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="claude_37_sonnet_description" value="{{$credits->claude_37_sonnet_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Claude 3.7 Sonnet') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="claude_37_sonnet_input_token" value="{{$credits->claude_37_sonnet_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Claude 3.7 Sonnet') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="claude_37_sonnet_output_token" value="{{$credits->claude_37_sonnet_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="claude_37_sonnet_new" class="custom-switch-input" @if ($credits->claude_37_sonnet_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>		
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Claude 3.5v2 Sonnet') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="claude_35_sonnet_title" value="{{$credits->claude_35_sonnet_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="claude_35_sonnet_description" value="{{$credits->claude_35_sonnet_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Claude 3.5v2 Sonnet') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="claude_35_sonnet_input_token" value="{{$credits->claude_35_sonnet_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Claude 3.5v2 Sonnet') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="claude_35_sonnet_output_token" value="{{$credits->claude_35_sonnet_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="claude_35_sonnet_new" class="custom-switch-input" @if ($credits->claude_35_sonnet_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>		
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Claude 3.5 Haiku') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="claude_35_haiku_title" value="{{$credits->claude_35_haiku_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="claude_35_haiku_description" value="{{$credits->claude_35_haiku_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Claude 3.5 Haiku') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="claude_35_haiku_input_token" value="{{$credits->claude_35_haiku_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Claude 3.5 Haiku') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="claude_35_haiku_output_token" value="{{$credits->claude_35_haiku_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="claude_35_haiku_new" class="custom-switch-input" @if ($credits->claude_35_haiku_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>			
								</div>											
							</div>
						</div>

						<hr>

						<h6 class="font-weight-bold text-center mb-6 mt-6 fs-14">{{ __('Google Gemini Models') }}</h6>

						<div class="row pl-5 pr-5">							
							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Gemini 2.0 Flash') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gemini_20_flash_title" value="{{$credits->gemini_20_flash_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gemini_20_flash_description" value="{{$credits->gemini_20_flash_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Gemini 2.0 Flash') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gemini_20_flash_input_token" value="{{$credits->gemini_20_flash_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Gemini 2.0 Flash') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gemini_20_flash_output_token" value="{{$credits->gemini_20_flash_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 		
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gemini_20_flash_new" class="custom-switch-input" @if ($credits->gemini_20_flash_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Gemini 1.5 Flash') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gemini_15_flash_title" value="{{$credits->gemini_15_flash_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gemini_15_flash_description" value="{{$credits->gemini_15_flash_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Gemini 1.5 Flash') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gemini_15_flash_input_token" value="{{$credits->gemini_15_flash_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Gemini 1.5 Flash') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gemini_15_flash_output_token" value="{{$credits->gemini_15_flash_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box mb-2">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gemini_15_flash_new" class="custom-switch-input" @if ($credits->gemini_15_flash_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Gemini 1.5 Pro') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gemini_15_pro_title" value="{{$credits->gemini_15_pro_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="gemini_15_pro_description" value="{{$credits->gemini_15_pro_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Gemini 1.5 Pro') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gemini_15_pro_input_token" value="{{$credits->gemini_15_pro_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Gemini 1.5 Pro') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="gemini_15_pro_output_token" value="{{$credits->gemini_15_pro_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="gemini_15_pro_new" class="custom-switch-input" @if ($credits->gemini_15_pro_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>		
								</div>											
							</div>
						</div>

						<hr>

						<h6 class="font-weight-bold text-center mb-6 mt-6 fs-14">{{ __('DeepSeek Models') }}</h6>

						<div class="row pl-5 pr-5">							
							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('DeekSeek R1') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="deepseek_r1_title" value="{{$credits->deepseek_r1_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="deepseek_r1_description" value="{{$credits->deepseek_r1_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('DeekSeek R1') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="deepseek_r1_input_token" value="{{$credits->deepseek_r1_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('DeekSeek R1') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="deepseek_r1_output_token" value="{{$credits->deepseek_r1_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="deepseek_r1_new" class="custom-switch-input" @if ($credits->deepseek_r1_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('DeekSeek V3') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="deepseek_v3_title" value="{{$credits->deepseek_v3_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="deepseek_v3_description" value="{{$credits->deepseek_v3_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('DeekSeek V3') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="deepseek_v3_input_token" value="{{$credits->deepseek_v3_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('DeekSeek V3') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="deepseek_v3_output_token" value="{{$credits->deepseek_v3_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="deepseek_v3_new" class="custom-switch-input" @if ($credits->deepseek_v3_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>		
								</div>											
							</div>
						</div>

						<hr>

						<h6 class="font-weight-bold text-center mb-6 mt-6 fs-14">{{ __('xAI Models') }}</h6>

						<div class="row pl-5 pr-5">							
							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Grok 2') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="grok_2_title" value="{{$credits->grok_2_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="grok_2_description" value="{{$credits->grok_2_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Grok 2') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="grok_2_input_token" value="{{$credits->grok_2_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Grok 2') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="grok_2_output_token" value="{{$credits->grok_2_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box mb-2">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="grok_2_new" class="custom-switch-input" @if ($credits->grok_2_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Grok 2 Vision') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="grok_2_vision_title" value="{{$credits->grok_2_vision_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="grok_2_vision_description" value="{{$credits->grok_2_vision_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Grok 2 Vision') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="grok_2_vision_input_token" value="{{$credits->grok_2_vision_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Grok 2 Vision') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="grok_2_vision_output_token" value="{{$credits->grok_2_vision_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="grok_2_vision_new" class="custom-switch-input" @if ($credits->grok_2_vision_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>
						</div>

						<hr>

						<h6 class="font-weight-bold text-center mb-6 mt-6 fs-14">{{ __('Perplexity Models') }}</h6>

						<div class="row pl-5 pr-5">							
							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Sonar Reasoning Pro') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="sonar_reasoning_pro_title" value="{{$credits->sonar_reasoning_pro_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="sonar_reasoning_pro_description" value="{{$credits->sonar_reasoning_pro_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Sonar Reasoning Pro') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="sonar_reasoning_pro_input_token" value="{{$credits->sonar_reasoning_pro_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Sonar Reasoning Pro') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="sonar_reasoning_pro_output_token" value="{{$credits->sonar_reasoning_pro_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="sonar_reasoning_pro_new" class="custom-switch-input" @if ($credits->sonar_reasoning_pro_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Sonar Reasoning') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="sonar_reasoning_title" value="{{$credits->sonar_reasoning_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="sonar_reasoning_description" value="{{$credits->sonar_reasoning_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Sonar Reasoning') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="sonar_reasoning_input_token" value="{{$credits->sonar_reasoning_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Sonar Reasoning') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="sonar_reasoning_output_token" value="{{$credits->sonar_reasoning_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="sonar_reasoning_new" class="custom-switch-input" @if ($credits->sonar_reasoning_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Sonar Pro') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="sonar_pro_title" value="{{$credits->sonar_pro_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="sonar_pro_description" value="{{$credits->sonar_pro_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Sonar Pro') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="sonar_pro_input_token" value="{{$credits->sonar_pro_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Sonar Pro') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="sonar_pro_output_token" value="{{$credits->sonar_pro_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="sonar_pro_new" class="custom-switch-input" @if ($credits->sonar_pro_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Sonar') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="sonar_title" value="{{$credits->sonar_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="sonar_description" value="{{$credits->sonar_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Sonar') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="sonar_input_token" value="{{$credits->sonar_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Sonar') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="sonar_output_token" value="{{$credits->sonar_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="sonar_new" class="custom-switch-input" @if ($credits->sonar_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>
						</div>

						<hr>

						<h6 class="font-weight-bold text-center mb-6 mt-6 fs-14">{{ __('Amazon Nova Models') }}</h6>

						<div class="row pl-5 pr-5">							
							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Nova Pro') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="nova_pro_title" value="{{$credits->nova_pro_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="nova_pro_description" value="{{$credits->nova_pro_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Nova Pro') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="nova_pro_input_token" value="{{$credits->nova_pro_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Nova Pro') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="nova_pro_output_token" value="{{$credits->nova_pro_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box mb-2">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="nova_pro_new" class="custom-switch-input" @if ($credits->nova_pro_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Nova Lite') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="nova_lite_title" value="{{$credits->nova_lite_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="nova_lite_description" value="{{$credits->nova_lite_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Nova Lite') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="nova_lite_input_token" value="{{$credits->nova_lite_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Nova Lite') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="nova_lite_output_token" value="{{$credits->nova_lite_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box mb-2">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="nova_lite_new" class="custom-switch-input" @if ($credits->nova_lite_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>

							<div class="col-lg-12 col-md-12 col-sm-12 no-gutters mt-5">
								<div class="row">	
									<h6 class="font-weight-bold fs-12">{{ __('Nova Micro') }} <span class="text-required"><i class="fa-solid fa-asterisk ml-1"></i></span></h6>
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="nova_micro_title" value="{{$credits->nova_micro_title}}" placeholder="Model Name">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box">			
											<div class="form-group">							    
												<input type="text" class="form-control" name="nova_micro_description" value="{{$credits->nova_micro_description}}" placeholder="Model Description">
											</div> 	
										</div>									
									</div> 
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Nova Micro') }} ({{__('Input Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="nova_micro_input_token" value="{{$credits->nova_micro_input_token}}" placeholder="Input Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-md-6 col-sm-12">						
										<div class="input-box mb-2">	
											<h6 class="text-muted">{{ __('Nova Micro') }} ({{__('Output Tokens')}})</h6>		
											<div class="form-group">							    
												<input type="number" min="0.001" step="0.001" class="form-control" name="nova_micro_output_token" value="{{$credits->nova_micro_output_token}}" placeholder="Output Token Cost">
											</div> 	
										</div>									
									</div> 	
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="input-box mb-2">
											<div class="form-group mt-3">
												<label class="custom-switch">
													<input type="checkbox" name="nova_micro_new" class="custom-switch-input" @if ($credits->nova_micro_new) checked @endif>
													<span class="custom-switch-indicator"></span>
													<span class="custom-switch-label text-muted fs-12">{{__('Show as New Model')}}</span>
												</label>
											</div>
										</div>
									</div>	
								</div>											
							</div>
						</div>

						<!-- ACTION BUTTON -->
						<div class="border-0 text-center mb-2 mt-1">
							<button type="submit" class="btn ripple btn-primary pl-9 pr-9 pt-3 pb-3">{{ __('Save') }}</button>							
						</div>				

					</form>					
				</div>
			</div>
		</div>
	</div>
@endsection

