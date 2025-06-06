<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 col-sm-12 text-center">
                <span class="text-muted fs-11">{{ __('Copyright') }} © {{ date("Y") }} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>. {{ __('All rights reserved') }}</span>
            </div>
            <div class="col-md-12 col-sm-12 text-center">
                <span class="fs-10 font-weight-bold text-info">{{ config('app.version') }}</span>
            </div>
        </div>
    </div>
</footer>
<!-- END FOOTER -->

<!-- Back to top -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- Jquery -->
<script src="{{URL::asset('plugins/jquery/jquery-3.6.0.min.js')}}"></script>

<!-- Bootstrap 5 -->
<script src="{{URL::asset('plugins/bootstrap-5.0.2/js/bootstrap.bundle.min.js')}}"></script>

<!-- Sidemenu -->
<script src="{{URL::asset('plugins/sidemenu/sidemenu.js')}}"></script>

<!-- P-scroll -->
<script src="{{URL::asset('plugins/p-scrollbar/p-scrollbar.js')}}"></script>
<script src="{{URL::asset('plugins/p-scrollbar/p-scroll.js')}}"></script>

@yield('js')

<!-- Awselect JS -->
<script src="{{URL::asset('plugins/awselect/awselect-custom.js')}}"></script>
<script src="{{theme_url('js/awselect.js')}}"></script>

<!-- Simplebar JS -->
<script src="{{URL::asset('plugins/simplebar/js/simplebar.min.js')}}"></script>

<!-- Tippy JS -->
<script src="{{URL::asset('plugins/tippy/popper.min.js')}}"></script>
<script src="{{URL::asset('plugins/tippy/tippy-bundle.umd.min.js')}}"></script>

<!-- Toastr JS -->
<script src="{{URL::asset('plugins/toastr/toastr.min.js')}}"></script>

<!-- Custom js-->
<script src="{{theme_url('js/custom.js')}}"></script>


<!-- Google Analytics -->
@if (config('services.google.analytics.enable') == 'on')
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.google.analytics.id') }}"></script>
    <script type="text/javascript">
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '{{ config('services.google.analytics.id') }}');
    </script>
@endif

<!-- Mark as Read JS-->
<script type="text/javascript">

    function sendMarkRequest(id = null) {
        return $.ajax("{{ route('user.notifications.mark') }}", {
            method: 'POST',
            data: {"_token": "{{ csrf_token() }}", id}
        });
    }

    function changeTemplate(value) {
		let url = '{{ theme_url('app/user/templates') }}/' + value;
		window.location.href=url;
	}

    var totalNotifications;
    var totalNotifications_a;
    var totalNotifications_b;

    $(function() {     

        $('.mark-as-read').on('click', function() {
            let request = sendMarkRequest($(this).data('id'));
            request.done(() => {
                $(this).parents('div.dropdown-item').remove();
            });

            document.getElementById("total-notifications").innerHTML = --totalNotifications;
            document.getElementById("total-notifications-a").innerHTML = --totalNotifications_a;
            document.getElementById("total-notifications-b").innerHTML = --totalNotifications_b;
        });

        $('#mark-all').on('click', function() {
            let request = sendMarkRequest();
            request.done(() => {
                $('div.notify-menu').remove();
            })

            document.getElementById("total-notifications").innerHTML = 0;
        });
    });        

    $(document).ready(function(){
       
        if (document.getElementById("total-notifications")) {
            totalNotifications = "{{ auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count() }}";
            document.getElementById("total-notifications").innerHTML = totalNotifications;
        }  
        if (document.getElementById("total-notifications-a")) {
            totalNotifications_a = "{{ auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count() }}";
            document.getElementById("total-notifications-a").innerHTML = totalNotifications_a;
        }
        if (document.getElementById("total-notifications-b")) {
            totalNotifications_b = "{{ auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count() }}";
            document.getElementById("total-notifications-b").innerHTML = totalNotifications_b;
        }                  
        
    });

    tippy('[data-tippy-content]', {
        animation: 'scale-extreme',
        theme: 'material',
    });

    const words_info = document.getElementById('nav-info-words');
    const images_info = document.getElementById('nav-info-images');
    const characters_info = document.getElementById('nav-info-characters');
    const minutes_info = document.getElementById('nav-info-minutes');
    
    tippy('[data-tippy-words]', {
        animation: 'scale-extreme',
        theme: 'material',
        content: words_info.innerHTML,
        allowHTML: true,
    });

    tippy('[data-tippy-images]', {
        animation: 'scale-extreme',
        theme: 'material',
        content: images_info.innerHTML,
        allowHTML: true,
    });

    tippy('[data-tippy-characters]', {
        animation: 'scale-extreme',
        theme: 'material',
        content: characters_info.innerHTML,
        allowHTML: true,
    });

    tippy('[data-tippy-minutes]', {
        animation: 'scale-extreme',
        theme: 'material',
        content: minutes_info.innerHTML,
        allowHTML: true,
    });

    toastr.options.showMethod = 'slideDown';
    toastr.options.hideMethod = 'slideUp';
    toastr.options.progressBar = true;


    document.querySelector(".btn-theme-toggle > span").classList.add("fa-moon-stars");
    var myCookie = (document.cookie.match(/^(?:.*;)?\s*theme\s*=\s*([^;]+)(?:.*)?$/)||[,null])[1];
    if (myCookie == 'dark') {
            document.querySelector(".btn-theme-toggle > span").classList.remove("fa-moon-stars");
            document.querySelector(".btn-theme-toggle > span").classList.add("fa-sun-bright");  
            var logo = document.querySelector(".desktop-lgo");
            logo.src = '{{ URL::asset($settings->logo_dashboard_dark) }}';
    }

    const btn = document.querySelector(".btn-theme-toggle");
    btn.addEventListener("click", function() {
        if (document.body.classList.contains('light-theme')) {
            document.body.classList.remove('light-mode');
            document.body.classList.add('dark-mode');
            document.querySelector(".btn-theme-toggle > span").classList.remove("fa-moon-stars");
            document.querySelector(".btn-theme-toggle > span").classList.add("fa-sun-bright");
            var logo = document.querySelector(".desktop-lgo");
            logo.src = '{{ URL::asset($settings->logo_dashboard) }}';
            var theme = "dark";
        } else if(document.body.classList.contains('dark-theme')) {
            document.body.classList.remove('dark-mode');
            document.body.classList.add('light-mode');
            document.querySelector(".btn-theme-toggle > span").classList.remove("fa-sun-bright");
            document.querySelector(".btn-theme-toggle > span").classList.add("fa-moon-stars");
            var logo = document.querySelector(".desktop-lgo");
            logo.src = '{{ URL::asset($settings->logo_dashboard_dark) }}';
            var theme = "light";
        } else {
            document.querySelector(".btn-theme-toggle > span").classList.remove("fa-moon-stars");
            document.querySelector(".btn-theme-toggle > span").classList.add("fa-sun-bright");
            document.body.classList.add('dark-mode');
            var logo = document.querySelector(".desktop-lgo");
            logo.src = '{{ URL::asset($settings->logo_dashboard_dark) }}';
            var theme = "dark";
        }
    
        document.cookie = "theme=" + theme + ";path=/";

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/app/user/profile/settings',
            data: {'theme': theme},
            success: function(data) {
            },
            error: function(data) {        
            }
        }).done(function(data) {})

        location.reload();
    });


    $(function(){

        var ua =navigator.userAgent;
        if(ua.indexOf('iPhone') > -1 || ua.indexOf('iPad') > -1 || ua.indexOf('iPod')  > -1){
            var start = "touchstart";
            var move  = "touchmove";
            var end   = "touchend";
        } else{
            var start = "mousedown";
            var move  = "mousemove";
            var end   = "mouseup";
        }
        var ink, d, x, y;
        $(".ripple").on(start, function(e){
        
            if($(this).find(".ink").length === 0){
            $(this).prepend("<span class='ink'></span>");
        }
            
        ink = $(this).find(".ink");
        ink.removeClass("animate");
        
        if(!ink.height() && !ink.width()){
            d = Math.max($(this).outerWidth(), $(this).outerHeight());
            ink.css({height: d, width: d});
        }
        
        x = e.originalEvent.pageX - $(this).offset().left - ink.width()/2;
        y = e.originalEvent.pageY - $(this).offset().top - ink.height()/2;
        
        ink.css({top: y+'px', left: x+'px'}).addClass("animate");

        });

    });
   
</script>

<!-- Live Chat -->
@if (config('settings.live_chat') == 'on')
    <script type="text/javascript">
        let link = "{{ config('settings.live_chat_link') }}";
        let embed_link = link.replace('https://tawk.to/chat/', 'https://embed.tawk.to/');

        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src=embed_link;
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
@endif