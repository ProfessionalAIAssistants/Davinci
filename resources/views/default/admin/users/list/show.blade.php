@extends('layouts.app')

@section('page-header')
	<!-- PAGE HEADER -->
	<div class="page-header mt-5-7">
		<div class="page-leftheader">
			<h4 class="page-title mb-0">{{ __('User Information') }}</h4>
			<ol class="breadcrumb mb-2">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-id-badge mr-2 fs-12"></i>{{ __('Admin') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.user.dashboard') }}"> {{ __('User Management') }}</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="{{ route('admin.user.list') }}">{{ __('User List') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page"><a href="#"> {{ __('View User Information') }}</a></li>
			</ol>
		</div>
	</div>
	<!-- END PAGE HEADER -->
@endsection

@section('content')
	<!-- USER PROFILE PAGE -->
	<div class="row">
		<div class="col-xl-3 col-lg-3 col-md-12">
			<div class="card border-0">
				<div class="card-header">
					<h3 class="card-title">{{ __('Personal Information') }}</h3>
				</div>
				<div class="overflow-hidden p-0">
					<div class="row">
						<div class="col-sm-12 border-bottom">
							<div class="text-center p-2">	
								<div class="d-flex w-100">
									<div class="flex w-100">
										<h4 class="mb-3 mt-3 font-weight-bold fs-14">@if ($user->tokens == -1) {{ __('Unlimited') }} @else {{ number_format($user->tokens + $user->tokens_prepaid) }} @endif</h4>
										<h6 class="fs-11 mb-3 text-muted">@if ($settings->model_credit_name == 'words') {{ __('Words Left') }} @else {{ __('Tokens Left') }} @endif</h6>
									</div>			
									<div class="flex w-100">
										<h4 class="mb-3 mt-3 font-weight-bold fs-14">@if ($user->images == -1) {{ __('Unlimited') }} @else {{ number_format($user->images + $user->images_prepaid) }} @endif</h4>
										<h6 class="fs-11 mb-3 text-muted">{{ __('Media Credits Left') }}</h6>
									</div>	
								</div>							
								<div class="d-flex w-100">
									<div class="flex w-100">
										<h4 class="mb-3 mt-3 font-weight-bold fs-14">@if ($user->characters == -1) {{ __('Unlimited') }} @else {{ number_format($user->characters + $user->characters_prepaid) }} @endif</h4>
										<h6 class="fs-11 mb-3 text-muted">{{ __('Characters Left') }}</h6>
									</div>			
									<div class="flex w-100">
										<h4 class="mb-3 mt-3 font-weight-bold fs-14">@if ($user->minutes == -1) {{ __('Unlimited') }} @else {{ number_format($user->minutes + $user->minutes_prepaid) }} @endif</h4>
										<h6 class="fs-11 mb-3 text-muted">{{ __('Minutes Left') }}</h6>
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="widget-user-image overflow-hidden mx-auto mt-5"><img alt="User Avatar" class="rounded-circle" src="@if($user->profile_photo_path) {{ $user->profile_photo_path }} @else {{ theme_url('img/users/avatar.jpg') }} @endif"></div>
				<div class="card-body text-center">				
					<div>
						<h4 class="mb-1 mt-1 font-weight-bold fs-16">{{ $user->name }}</h4>
						<h6 class="text-muted fs-12">{{ $user->job_role }}</h6>
						<a href="{{ route('admin.user.edit', [$user->id]) }}" class="btn btn-primary mt-3 mb-2 mr-2"><i class="fa-solid fa-pencil mr-1"></i> {{ __('Update Profile') }}</a>
						<a href="{{ route('admin.user.credit', [$user->id]) }}" class="btn btn-primary mt-3 mb-2"><i class="fa-solid fa-scroll-old mr-1"></i>{{ __('Update Credits') }}</a>
						@if (App\Services\HelperService::extensionSaaS())
							<a href="{{ route('admin.user.subscription', [$user->id]) }}" class="btn btn-primary mt-3 mb-2"><i class="fa-solid fa-box-circle-check mr-1"></i>{{ __('Add Subscription') }}</a>
						@endif
					</div>
				</div>
				
				<div class="card-body pt-0">
					<div class="table-responsive">
						<table class="table mb-0">
							<tbody>
								<tr>
									<td class="py-2 px-0 border-top-0">
										<span class="font-weight-semibold w-50">{{ __('Full Name') }} </span>
									</td>
									<td class="py-2 px-0 border-top-0">{{ $user->name }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Email') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->email }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('User Status') }} </span>
									</td>
									<td class="py-2 px-0">{{ ucfirst($user->status) }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('User Group') }} </span>
									</td>
									<td class="py-2 px-0">{{ ucfirst($user->group) }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Referral ID') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->referral_id }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Registered On') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->created_at }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Last Updated On') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->updated_at }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Job Role') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->job_role }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Company') }}</span>
									</td>
									<td class="py-2 px-0">{{ $user->company }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Website') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->website }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Address') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->address }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Postal Code') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->postal_code }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('City') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->city }}</td>
								</tr>
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Country') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->country }}</td>
								</tr>								
								<tr>
									<td class="py-2 px-0">
										<span class="font-weight-semibold w-50">{{ __('Phone') }} </span>
									</td>
									<td class="py-2 px-0">{{ $user->phone_number }}</td>
								</tr>
							</tbody>
						</table>
						<div class="border-0 text-right mb-2 mt-2">
							<a href="{{ route('admin.user.list') }}" class="btn btn-primary">{{ __('Return') }}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12">
			<div class="row">

				<div class="row">

					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="row">
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="card overflow-hidden border-0">
									<div class="card-body d-flex">
										<div class="usage-info w-100">
											<p class=" mb-3 fs-12 font-weight-bold">{{ __('Words Generated') }}</p>
											<h2 class="mb-2 number-font fs-20">{{ number_format($data['words']) }} <span class="text-muted fs-18">{{ __('words') }}</span></h2>
										</div>
										<div class="usage-icon w-100 text-right">
											<i class="fa-solid fa-scroll-old"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="card overflow-hidden border-0">
									<div class="card-body d-flex">
										<div class="usage-info w-100">
											<p class=" mb-3 fs-12 font-weight-bold">{{ __('Images Created') }}</p>
											<h2 class="mb-2 number-font fs-20">{{ number_format($data['images']) }} <span class="text-muted fs-18">{{ __('images') }}</span></h2>
										</div>
										<div class="usage-icon w-100 text-right">
											<i class="fa-solid fa-image-landscape"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="card overflow-hidden border-0">
									<div class="card-body d-flex">
										<div class="usage-info w-100">
											<p class=" mb-3 fs-12 font-weight-bold">{{ __('Characters Synthesized') }}</p>
											<h2 class="mb-2 number-font fs-20">{{ number_format($data['characters']) }} <span class="text-muted fs-18">{{ __('characters') }}</span></h2>
										</div>
										<div class="usage-icon w-100 text-right">
											<i class="fa-solid fa-waveform-lines"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-12 col-sm-12">
								<div class="card overflow-hidden border-0">
									<div class="card-body d-flex">
										<div class="usage-info w-100">
											<p class=" mb-3 fs-12 font-weight-bold">{{ __('Minutes Transcribed') }}</p>
											<h2 class="mb-2 number-font fs-20">{{ number_format((float)$data['minutes']/60, 2) }} <span class="text-muted fs-18">{{ __('minutes') }}</span></h2>
										</div>
										<div class="usage-icon w-100 text-right">
											<i class="fa-solid fa-folder-music"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="card mb-5 border-0">
						<div class="card-header d-inline border-0">
							<div class="d-flex">
								<div class="w-100">
									<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-box-open mr-4 text-info"></i>{{ __('Subscription') }}</h3>
								</div>
								@if (App\Services\HelperService::extensionSaaS())
									<div class="w-30">
										<div class="form-group mt-3">
											<label class="custom-switch">
												<input type="checkbox" name="hidden-plans" class="custom-switch-input" id="hidden-plans" onchange="toggleHidden()" @if ( $user->hidden_plan) checked @endif>
												<span class="custom-switch-indicator"></span>
												<span class="custom-switch-description">{{ __('Show Hidden Plans to this User') }}</span>
											</label>
										</div>
									</div>
								@endif
							</div>
							@if (is_null($user_subscription) || $user_subscription == '')
								<div>
									<h3 class="card-title fs-24 font-weight-800">{{ __('Free Trial') }}</h3>
								</div>
								<div class="mb-1">
									<span class="fs-12 text-muted">{{ __('No Subscription ') }} / {!! config('payment.default_system_currency_symbol') !!}0.00 {{ __('Per Month') }}</span>
								</div>
							@else
								<div>
									<h3 class="card-title fs-24 font-weight-800">@if ($user_subscription->payment_frequency == 'monthly') {{ __('Monthly Subscription') }} @elseif($user_subscription->payment_frequency == 'yearly') {{ __('Yearly Subscription') }} @else {{ __('Lifetime Subscription') }} @endif</h3>
								</div>
								<div class="mb-1">
									<span class="fs-12 text-muted">{{ $user_subscription->plan_name }} {{ __('Plan') }} / {!! config('payment.default_system_currency_symbol') !!}{{ $user_subscription->price }} @if ($user_subscription->payment_frequency == 'monthly') {{ __('Per Month') }} @elseif ($user_subscription->payment_frequency == 'yearly') {{ __('Per Year') }} @else {{ __('One Time Payment') }} @endif</span>
								</div>
							@endif
						</div>
						<div class="card-body">
							<div class="mb-3">
								<span class="fs-12 text-muted">{{ __('Total words available via subscription plan') }}: @if ($user->tokens == -1) {{ __('Unlimited') }} @else {{ number_format($user->tokens) }} @endif.</span> <span class="fs-12 text-muted">{{ __('Total prepaid words available ') }}: {{ number_format($user->tokens_prepaid) }}. </span>
							</div>
							<div class="progress mb-4">
								<div class="progress-bar progress-bar-striped progress-bar-animated bg-warning subscription-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progress['words'] }}%"></div>
							</div>
							@if ($subscription) 
							<div class="mb-3">
								@if ($user_subscription->payment_frequency == 'lifetime')
									<span class="fs-12 text-muted">{{ __('Subscription renewal date') }}: {{ __('Never') }}</span>
								@else
									<span class="fs-12 text-muted">{{ __('Subscription renewal date') }}: {{ $subscription->active_until }} </span>
								@endif									
							</div>
							@endif
						</div>
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="card border-0">
						<div class="card-header d-inline border-0">
							<div>
								<h3 class="card-title fs-16 mt-3 mb-4"><i class="fa-solid fa-scroll-old mr-4 text-info"></i>{{ __('Words & Images Generated') }} <span class="text-muted">({{ __('Current Year') }})</span></h3>
							</div>
						</div>
						<div class="card-body">
							<div class="chartjs-wrapper-demo">
								<canvas id="chart-user-usage" class="h-330"></canvas>
							</div>
						</div>
					</div>
				</div>				
			</div>			
		</div>
	</div>
	<!-- END USER PROFILE PAGE -->
@endsection

@section('js')
	<!-- Chart JS -->
	<script src="{{URL::asset('plugins/chart/chart.min.js')}}"></script>
	<script type="text/javascript">
		$(function() {
	
			'use strict';

			let usageData = JSON.parse(`<?php echo $chart_data['word_usage']; ?>`);
			let usageDataset = Object.values(usageData);
			let delayed;

			let ctx = document.getElementById('chart-user-usage');
			new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ['{{ __('Jan') }}', '{{ __('Feb') }}', '{{ __('Mar') }}', '{{ __('Apr') }}', '{{ __('May') }}', '{{ __('Jun') }}', '{{ __('Jul') }}', '{{ __('Aug') }}', '{{ __('Sep') }}', '{{ __('Oct') }}', '{{ __('Nov') }}', '{{ __('Dec') }}'],
					datasets: [{
						label: '{{ __('Words Generated') }}',
						data: usageDataset,
						backgroundColor: '#007bff',
						borderWidth: 1,
						borderRadius: 20,
						barPercentage: 0.5,
						fill: true
					}]
				},
				options: {
					maintainAspectRatio: false,
					legend: {
						display: false,
						labels: {
							display: false
						}
					},
					responsive: true,
					animation: {
						onComplete: () => {
							delayed = true;
						},
						delay: (context) => {
							let delay = 0;
							if (context.type === 'data' && context.mode === 'default' && !delayed) {
								delay = context.dataIndex * 50 + context.datasetIndex * 5;
							}
							return delay;
						},
					},
					scales: {
						y: {
							stacked: true,
							ticks: {
								beginAtZero: true,
								font: {
									size: 10
								},
								stepSize: 2000,
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
						x: {
							stacked: true,
							ticks: {
								font: {
									size: 10
								}
							},
							grid: {
								color: '#ebecf1',
								borderDash: [3, 2]                            
							}
						},
					},
					plugins: {
						tooltip: {
							cornerRadius: 10,
							xPadding: 10,
							yPadding: 10,
							backgroundColor: '#000000',
							titleColor: '#FF9D00',
							yAlign: 'bottom',
							xAlign: 'center',
						},
						legend: {
							position: 'bottom',
							labels: {
								boxWidth: 10,
								font: {
									size: 10
								}
							}
						}
					}
					
				}
			});

		});

		function toggleHidden() {

			var formData = new FormData();
			formData.append("status", $('#hidden-plans').is(':checked') );
			formData.append("user_id", {{ $user->id }});

			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				method: 'post',
				url: '/app/admin/users/plan',
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {
					if (data['status'] == 200) {
						toastr.success('Hidden subscription plans visibility updated');								
					} else {
						toastr.error('There was an issue setting hidden plan visibility status');
					}      
				},
				error: function(data) {
					toastr.error('There was an issue setting hidden plan visibility status');
				}
			})
		}
	</script>
@endsection
