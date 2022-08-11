

$(function () {
    function customRange(input) {
        if (input.id == 'checkout') {
            var minDate = new Date($('#checkin').val());
            minDate.setDate(minDate.getDate() + 1);

            return {minDate: minDate};
        }
    }
function updateDest(){
    
}
    $(".datepicker").datepicker({beforeShow: customRange, dateFormat: "yy-mm-dd"});

    $('#search').autocomplete({
        source: function (request, response) {            
            $.ajax({
                url: "search.php",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function (data) {
                    //console.log(data);
                    return response(data);
                }
            });
        },
        select:function(event, ui){
            event.preventDefault();
            
            $('#dest').val(ui.item.value);
            //$('#search').val(ui.item.label);
            this.value = ui.item.label;
            
            console.log(this.value);
        }
    });
});