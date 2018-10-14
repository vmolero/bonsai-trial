const Elemento = function ({ id, titulo, img, tipo, tipoNombre, abonadoFecha, regadoFecha, transplantadoFecha, pulverizadoFecha }) {
    var olmoEspecifico = parseInt(tipo) === Bonsai.Olmo ? `<button class="btnAccion" bonsai-id="${id}" accion="pulverizar">Pulverizar</button><span>${pulverizadoFecha}</span><br />` : '';
    return `
    <div class="list-group-item">
      <div class="image">
        <img src="imgs/${img}" />
      </div>
      <p class="list-group-item-text">${titulo} ${tipoNombre}</p><span class="respuesta" bonsai-id="${id}"></span>
      <button class="btnAccion" bonsai-id="${id}" accion="regar">Regar</button><span>${regadoFecha}</span><br />
      <button class="btnAccion" bonsai-id="${id}" accion="abonar">Abonar</button><span>${abonadoFecha}</span><br />
      <button class="btnAccion" bonsai-id="${id}" accion="transplantar">Transplantar</button><span>${transplantadoFecha}</span><br />
      ${olmoEspecifico}
    </div>
  `;
};

var Bonsai = {
    Ficus: 1,
    Manzano: 2,
    Olmo: 3,
    Olivo: 4
};

function parseNombre(data, item, index) {
    if (item.tipo == Bonsai.Ficus) {
        data[index]['tipoNombre'] = "Ficus";
    }
    if (item.tipo == Bonsai.Manzano) {
        data[index]['tipoNombre'] = "Manzano";
    }
    if (item.tipo == Bonsai.Olmo) {
        data[index]['tipoNombre'] = "Olmo";
    }
    if (item.tipo == Bonsai.Olivo) {
        data[index]['tipoNombre'] = "Olivo";
    }
}

function parseNecesidades(data, item, index) {
    data[index]['abonadoFecha'] = item.abonado == '' ? "Nunca" : item.abonado;
    data[index]['regadoFecha'] = item.regado == '' ? "Nunca" : item.regado;
    data[index]['transplantadoFecha'] = item.transplantado == '' ? "Nunca" : item.transplantado;
    if (parseInt(item.tipo) === Bonsai.Olmo) {
        data[index]['pulverizadoFecha'] = item.pulverizado == '' ? "Nunca" : item.pulverizado;
    }
}

function today() {
    var d = new Date();
    var month = d.getMonth()+1;
    var day = d.getDate();

    return d.getFullYear() + '-' +
    (month<10 ? '0' : '') + month + '-' +
    (day<10 ? '0' : '') + day;
}

window.onload = function() {
    $(function () {
        $('#fechaHoy').attr('value', today());
        $.getJSON("http://localhost:8000/bonsai/all", null,
            function (data, textStatus, jqXHR) {
                $.each(data, function(index, item) {
                    parseNombre(data, item, index);
                    parseNecesidades(data, item, index);
                });
                $('.listado').html(data.map(Elemento).join(''));
                $('.btnAccion').click(function(evt) {
                    $('body').trigger('accion', [$(this).attr('bonsai-id'), $(this).attr('accion')]);
                });
            }
        );
        $('body').on('accion', function (evt, id, accion) {
            /*$.getJSON("http://localhost:8000/bonsai/"+accion+"/"+id+"/"+$('#fechaHoy').value, null,
                function (data, textStatus, jqXHR) {
                    console.log(data);
                }
            );*/
            $.ajax({
                url: "http://localhost:8000/bonsai/" + accion + "/" + id + "/" + $('#fechaHoy').val(),
             
                // The name of the callback parameter, as specified by the YQL service
                jsonp: "callback",
             
                // Tell jQuery we're expecting JSONP
                dataType: "jsonp",
             
                // Tell YQL what we want and that we want JSON
                data: null,
             
                // Work with the response
                success: function( response ) {
                    console.log( response ); // server response
                }
            });
        });
    });
}