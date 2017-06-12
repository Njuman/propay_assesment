var working = false;

$('.login').on('submit', function(e) {
    e.preventDefault();

    var url = '/login',
        data = {identifier:$('#username-btn').val(), password:$('#pass-btn').val()};
    
    if (working)  {
        return;
    }

    working = true;

    var $this = $(this),
        $state = $this.find('button > .state');
        $spinner = $('.spinner');
    
    $spinner.show();

    $this.addClass('loading');
    $state.html('Authenticating');

    setTimeout(function() {
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            async: false,
            success : function(data){
                if(data.success){
                    $this.addClass('ok');
                    $state.html('Welcome back!');
                    
                    setTimeout(function() {
                        window.location = '/';
                    }, 1000);
                } else {
                    $state.html(data.flash);
                    
                    setTimeout(function() {
                        $state.html('Log in');
                        $this.removeClass('ok loading');
                        $spinner.hide();
                        working = false;
                    }, 2000);
                }
            }
        });
    }, 3000);
});