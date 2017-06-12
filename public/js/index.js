
$(".openLeftSidebar, .sidebar-overlay").click(function(){
    $(".sidebar-overlay").toggleClass("active");
    $(".sidebar").toggleClass("active");
});

$(".sidebar .logo-brand i").click(function(){
    $(".sidebar-overlay").toggleClass("active");
    $(".sidebar").toggleClass("active");
});

$(".dropdown").click(function(e){
    $(this).children(".drop-menu").first().toggleClass("active-drop");
    $(this).find("a .caret").first().toggleClass("caret-reverse");
    e.stopPropagation();
});

$("#checkAll").click(function(){
    $(this).toggleClass("checkAll");
    $("#dataTable").children("tbody").find("tr").find("td input.checkRow").each(function(){

        //console.log($(this));
        if($("#checkAll").hasClass("checkAll")){
            $(this).prop('checked', true);
        }else{
            $(this).prop('checked', false);
        }
    });
});

$("#update-btn").click(function() {
    document.getElementById("edit-form").submit();
});

$("#save-btn").click(function() {
    document.getElementById("add-form").submit();
});

$("#cancel").click(function() {
    window.location = '/';
});

$("#delete").click(function() {
    var names = [],
        url = '/delete';

    $('.checkRow:checked').each(function() {
        names.push($(this).val());
    });

    if (name.length > 0) {
        name = JSON.stringify(names);

        $.ajax({
            url: url,
            type: 'POST',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Content-Type', 'application/json');
            },
            data: JSON.stringify(names),
            async: false,
            rawData: true,
            success : function(data){
                if(data.success){
                    alert(data.messages);
                    window.location = '/';
                } 
            }
        });
    }
})

$("#add-btn").click(function(e) {
    window.location = '/add';
});




