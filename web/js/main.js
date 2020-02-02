/**
 * Created by clbs on 11/10/2019.
 */
$(function(){
    $('#modalButton').click(function(){
$('#modal').modal('show').find('#modalContent').load($(this).attr('value'));
    });
});