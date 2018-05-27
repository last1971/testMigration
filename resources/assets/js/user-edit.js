$(function(){
    $('[name=user-save]').click(function () {
       var params = {};
        $('[name=user-edit] input, [name=user-edit] select').each(function(){
            params[$(this).attr('name')] = $(this).val();
        }).promise().done(function(){
            $.post($('[name=user-edit]').attr('action'),params,function(data){

            },'json');
        });
    });
});