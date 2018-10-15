const Elemento = function ({ id, titulo, img, tipo, tipoNombre, abonadoFecha, regadoFecha, transplantadoFecha, pulverizadoFecha, abonadoRepuesta }) {
    var olmoEspecifico = parseInt(tipo) === Bonsai.Olmo ? `<button class="btnAccion" bonsai-id="${id}" accion="pulverizar">Pulverizar</button><span bonsai-id="${id}" class="pulverizar">${pulverizadoFecha}</span><br />` : '';
    return `
    <div class="list-group-item">
      <div class="image">
        <img src="imgs/${img}" />
      </div>
      <p class="list-group-item-text">${titulo} ${tipoNombre}</p>
      <button class="btnAccion" bonsai-id="${id}" accion="regar">Regar</button><span bonsai-id="${id}" class="regar">${regadoFecha}</span><br />
      <button class="btnAccion" bonsai-id="${id}" accion="abonar">Abonar</button><span bonsai-id="${id}" class="abonar">${abonadoFecha}</span><span id="respuesta-abonar-${id}"></span><br />
      <button class="btnAccion" bonsai-id="${id}" accion="transplantar">Transplantar</button><span bonsai-id="${id}" class="transplantar">${transplantadoFecha}</span><br />
      ${olmoEspecifico}
    </div>
  `;
};

const VideoYoutube = function (item) {
    var img = item.snippet.thumbnails.default.url;
    return `
    <div class="list-group-item">
      <div class="image">
        <img src="${img}" />
      </div>
      <p class="list-group-item-text"><a href="https://www.youtube.com/watch?v=${item.id.videoId}">${item.snippet.title}</a></p>
      <p class="list-group-item-text">${item.snippet.description}</p>
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
    data[index]['regadoFecha'] = item.regado == '' ? "" : item.regado;
    data[index]['transplantadoFecha'] = item.transplantado == '' ? "" : item.transplantado;
    if (parseInt(item.tipo) === Bonsai.Olmo) {
        data[index]['pulverizadoFecha'] = item.pulverizado == '' ? "" : item.pulverizado;
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
        $.getJSON(
            "https://www.googleapis.com/youtube/v3/search?q=bonsai&part=snippet&key=token&maxResults=10",
            null,
            function (data, textStatus, jqXHR) {
                $('#youtube').html(data.items.map(VideoYoutube).join(''));
            }
        )
        $('body').on('accion', function (evt, id, accion) {
            $fechaSpanAntes = $('span.'+ accion +'[bonsai-id="'+ id +'"]').text();
            $.ajax({
                url: "http://localhost:8000/bonsai/" + accion + "/" + id + "/" + $('#fechaHoy').val(),
                jsonp: "callback",
                dataType: "jsonp",
                data: null,
                success: function( response ) {
                    if (accion == 'abonar') {
                        if (!!response) {
                            $('span.'+ accion +'[bonsai-id="'+ id +'"]').text($('#fechaHoy').val());
                        }
                        $('#respuesta-abonar-'+id).text(" " + response);
                    } else {
                        $('span.'+ accion +'[bonsai-id="'+ id +'"]').text(response);
                    }
                },

            });
        });
    });
}
