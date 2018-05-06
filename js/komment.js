$(document).ready(function() {    
    load();             
});

function load() {
    $.ajax({
        url: 'ajax.php?action=kommentek',
        type: 'get',
        async: false,
        dataType: 'json'
    })
    .done(function(result) {
       
        if(result.kommentek.length !== 0) {
                var html = '<table  >';                
                result.kommentek.forEach(function(item) {
                    html += '<tr>';
                    html += '<td><strong> Küldte: </strong>' + item.mh_fnev +'</td>';
                    html += '<td style="width:200px;">'+ item.mh_date+'</td>';
                    html += '</tr>';
                    html += '<tr>';
                    html += '<td> <strong> Kommment: </strong><br>' + item.mh_hozzaszol + '<br><br></td>';                    
                    html += '</tr>';                 
                });
                $('#lista').html(html);
            }
    });
}