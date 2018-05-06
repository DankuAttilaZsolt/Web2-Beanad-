$(document).ready(function() {    
    load();             
});

function load() {
    $.ajax({
        url: 'ajax.php?action=felhasznalok',
        type: 'get',
        async: false,
        dataType: 'json'
    })
    .done(function(result) {
       
        if(result.felhasznalok.length !== 0) {
                var html = '<table >';
                 html += '<tr>';
                    html += '<th style="width:150px;"><strong>Felhasználó név: </strong></th>';
                    html += '<th style="width:150px;"><strong> Teljes név: </strong></th>';
                    html += '<th><strong> Email cim: </strong></th>';
                    html += '</tr>';
                result.felhasznalok.forEach(function(item) {
                    html += '<tr>';
                    html += '<td>' + item.fh_fnev +'</td>';
                    html += '<td>'+ item.fh_tnev+'</td>';
                    html += '<td>'+ item.fh_email+'</td>';
                    html += '</tr>';                                   
                });
                $('#lista').html(html);
            } else {
                $('#lista').html('Nincsenek kommentek!');
            }
        });
}