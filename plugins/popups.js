;
(function($) {
    $(function() {
        $('#txtMapa').on("change", function() {
            $('#lMapa').val('0');
        });

        $('#imagen').on("change", function() {
            $('#lImagen').val('0');
        });

        $('#pdf').on("change", function() {
            $('#lPdf').val('0');
        });

        $('#btnAgregarUsuario').bind('click', function(e) {
            e.preventDefault();
            $('#popupUsuarios').bPopup({
                easing: 'easeOutBack',
                speed: 500,
                transition: 'slideIn',
                transitionClose: 'slideBack',
                onOpen: function() {},
                onClose: function() {
                    $("#txtNombre").val("");
                    $("#txtApellidos").val("");
                    $("#txtUsuario").val("");
                    $("#txtPass").val("");
                }
            });
        });

        $('#btnEditarUsuario').bind('click', function(e) {
            e.preventDefault();
            $('#popupEditaUsuario').bPopup({
                easing: 'easeOutBack',
                speed: 500,
                transition: 'slideIn',
                transitionClose: 'slideBack',
                onOpen: function() {},
                onClose: function() {}
            });
        });

        //Se agrega función nueva, para las alertas de seguimiento. LVC 11-Octubre-2017
        $(window).on('load', function(e) {
            e.preventDefault();
            $('#popupMuestraSeg').bPopup({
                easing: 'easeInCubic',
                speed: 1000,
                transition: 'slideUp',
                transitionClose: 'slideUp',
                position: [950, 149],
                autoClose: 7000,
                onOpen: function() {},
                onClose: function() {}
            });
        });

        $("#pBtnCancConsSeg").click(function() {
            $('#popupMuestraSeg').bPopup().close();
        });
        //Termina código nuevo.									

        $('#verMapa').bind('click', function(e) {
            var id = $("#commmons").val();
            if (id == "") {
                alert("No hay puntos que mostrar");
                return false;
            }

            e.preventDefault();
            $('#popupMapa').bPopup({
                easing: 'easeOutBack',
                speed: 500,
                transition: 'slideDown',
                transitionClose: 'slideUp',
                onOpen: function() {
                    //alert(id);
                    Enviar("listado_comunicados.php?idsMap=" + id, "capaMapa");
                    setTimeout(function() {
                        $("#mapaM").show();
                    }, 500);
                },
                onClose: function() {
                    $("#mapaM").hide();
                }
            });
        });

        $('#verMapaG').bind('click', function(e) {
            var id = $("#commmons").val();
            if (id == "") {
                alert("No hay puntos que mostrar");
                return false;
            }

            window.open('http://sinavef.senasica.gob.mx/mapaAlertas/mapaAlertas.aspx?id=' + id, '_blank');
        });

        $('#btnAgregarLoc').bind('click', function(e) {
            e.preventDefault();
            $('#popupLocalizacion').bPopup({
                easing: 'easeOutBack',
                speed: 500,
                transition: 'slideDown',
                transitionClose: 'slideUp',
                onOpen: function() {},
                onClose: function() {
                    $("#txtOtraReg").val("");
                    $("#txtLatitud").val("");
                    $("#txtLongitud").val("");
                }
            });
        });

        $('#btnAgregarEnlace').bind('click', function(e) {
            e.preventDefault();
            $('#popupEnlaces').bPopup({
                easing: 'easeOutBack',
                speed: 500,
                transition: 'slideIn',
                transitionClose: 'slideBack',
                onOpen: function() {
                    //Código que se ejecuta cuando el dialogo abre
                },
                onClose: function() {
                    //Código que se ejecuta cuando el dialogo cierra
                    $("#txtEnlaces").val("");
                }
            });
        });

        $("#pBtnCancelarCatalogo").click(function() {
            $('#popupCatalogos').bPopup().close();
        });

        $("#pBtnCancelarLoc").click(function() {
            $('#popupLocalizacion').bPopup().close();
        });

        $("#pBtnCancelarEnlace").click(function() {
            $('#popupEnlaces').bPopup().close();
        });

        $("#pBtnAgregarEnlace").click(function() {
            var Enlace = $("#txtEnlaces").val();
            if (Enlace != "") {
                var indice = $("#contaEnlaces").val();
                $('#cmbEnlaces').append('<option value="' + (indice) + '">' + Enlace + '</option>');
                $('#popupEnlaces').bPopup().close();
                var nValor = parseInt(indice) + 1;
                $("#contaEnlaces").val("" + (nValor));
            } else {
                var error = "¡Debe escribir un enlace!";
                $("#errorEnl").html(error);
                $("#errorEnl").slideDown("slow");
                $("#errorEnl").delay(2000).hide(600);
                return false;
            }
        });

        $("#btnQuitarEnlace").click(function() {
            if (contarValoresSel("cmbEnlaces") > 0) {
                var values = $("#cmbEnlaces option:selected").val();
                $("#cmbEnlaces").find("option[value='" + values + "']").remove();
            }
        });

        $("#pBtnAgregarLoc").click(function() {
            var OtraReg = $("#txtOtraReg").val();
            var Lat = $("#txtLatitud").val();
            var Lon = $("#txtLongitud").val();
            var Pais = $("#cmb_paises option:selected").html();
            var Estado = $("#cmb_estados option:selected").html();
            var Municipio = $("#cmb_municipios option:selected").html();
            var error = "";

            if (OtraReg != "" && Lat != "" && Lon != "") {
                if ((Lat >= -90 && Lat <= 90) && (Lon >= -180 && Lon <= 180)) {
                    var indice = $("#contaLocs").val();
                    var idPais = $("#cmb_paises option:selected").val();
                    if (idPais == 132) {
                        $('#cmbLocsOculto').append('<option value="' + (indice) + '">' + armarValuesLocMex(OtraReg, Lat, Lon) + '</option>');
                        $('#cmbLocs').append('<option value="' + (indice) + '">' + OtraReg + ', ' + Municipio + ', ' + Estado + ', ' + Pais + '. (' + Lat + ',' + Lon + ')</option>');
                    } else {
                        $('#cmbLocsOculto').append('<option value="' + (indice) + '">' + armarValuesLoc(OtraReg, Lat, Lon) + '</option>');
                        $('#cmbLocs').append('<option value="' + (indice) + '">' + OtraReg + ', ' + Pais + '. (' + Lat + ',' + Lon + ')</option>');
                    }

                    $('#popupLocalizacion').bPopup().close();
                    var nValor = parseInt(indice) + 1;
                    $("#contaLocs").val("" + (nValor));
                } else {
                    error = "¡El valor de las coordenadas geográficas no es válido!";
                }
            } else {
                if (OtraReg == "")
                    error = "¡Debe especificar una localidad!";
                else if (Lat == "")
                    error = "¡Debe especificar el valor de la Latitud!";
                else if (Lon == "")
                    error = "¡Debe especificar el valor de la Longitud!";

                if (error != "") {
                    $("#errorLoc").html(error);
                    $("#errorLoc").slideDown("slow");
                    $("#errorLoc").delay(2000).hide(600);
                    return false;
                }
            }
        });

        $("#btnQuitarLoc").click(function() {
            if (contarValoresSel("cmbLocs") > 0) {
                var values = $("#cmbLocs option:selected").val();
                $("#cmbLocsOculto").find("option[value='" + values + "']").remove();
                $("#cmbLocs").find("option[value='" + values + "']").remove();
            }
        });

        $("#pBtnCancelarUser").click(function() {
            $('#popupUsuarios').bPopup().close();
        });

        $("#pBtnCancelarEditUser").click(function() {
            $('#popupEditaUsuario').bPopup().close();
        });

        //Se modifica función para activar o desactivar elementos del catálogo. LVC 14-Mayo-2018																						
        $("#pBtnAgregarCatalogo").click(function() {
            var nombre = $("#txtNombre").val();
            var nombreCientifico = "";
            var elemento = $("#elemento").val();
            var capa = $("#capa").val();
            var area = $("#prueba_a").val();
            var estatusR = $("input[type='radio'][name='rdEstatus']:checked").val();

            var error = "";
            if (nombre == "")
                error = "¡Debe escribir un nombre!";

            if (error != "") {
                $("#errorCatalogo").html(error);
                $("#errorCatalogo").slideDown("slow");
                $("#errorCatalogo").delay(2000).hide(600);
                return false;
            } else {
                var envio = "";
                if (elemento == 3) {
                    nombreCientifico = $("#txtNcientifico").val();
                    envio = "gestionCatalogos.php?nombre=" + nombre + "&cat=" + elemento + "&ncient=" + nombreCientifico + "&area=" + area;
                } else {
                    envio = "gestionCatalogos.php?nombre=" + nombre + "&cat=" + elemento + "&area=" + area;
                }

                var a = document.getElementById("udpId");
                if (a.value > 0) {
                    envio += "&id=" + a.value;
                }

                if (estatusR != "undefined") {
                    envio += "&estReg=" + estatusR;
                }

                Enviar(envio, capa);
                $('#popupCatalogos').bPopup().close();

                return false;
            }
            return false;
        });

        $("#pBtnAgregarUser").click(function() {
            var nombre = $("#txtNombre").val();
            var apellidos = $("#txtApellidos").val();
            var usuario = $("#txtUsuario").val();
            var contra = $("#txtPass").val();

            var error = "";

            if (nombre == "")
                error = "¡Debe escribir un nombre!";
            else if (apellidos == "")
                error = "¡Debe escribir un apellido!";
            else if (usuario == "")
                error = "¡Debe escribir un nombre de usuario!";
            else if (contra == "")
                error = "¡Debe especificar una contraseña!";

            if (error != "") {
                $("#errorUsuario").html(error);
                $("#errorUsuario").slideDown("slow");
                $("#errorUsuario").delay(2000).hide(600);
                return false;
            } else {
                var rol = $("#prueba_b").val();
                var area = $("#prueba_a").val();
                var iarea = $("#cmbArea option:selected").val();
                var irol = $("#cmbRol option:selected").val();
                var inivel = $("#cmbNivel option:selected").val();

                Enviar("consultaUsuarios.php?rol=" + rol + "&area=" + area + "&irol=" + irol + "&iarea=" + iarea + "&inivel=" + inivel + "&inombre=" + nombre + "&iapellidos=" + apellidos + "&iusuario=" + usuario + "&contra=" + contra, "tablaUsuarios");
                $('#popupUsuarios').bPopup().close();

                return false;
            }
            return false;
        });

        $("#pBtnEditUser").click(function() {
            var nombre = $("#txtNombre").val();
            var apellidos = $("#txtApellidos").val();
            var usuario = $("#txtUsuario").val();
            var contra = $("#txtPass").val();
            var contraR = $("#txtPass1").val();
            var dependencia = $("#txtDependencia").val();

            var error = "";

            if (nombre == "")
                error = "¡Debe escribir un nombre!";
            else if (apellidos == "")
                error = "¡Debe escribir un apellido!";
            else if (usuario == "")
                error = "¡Debe escribir un nombre de usuario!";

            if (contraR == null)
                contraR = "";

            if (contra != contraR)
                error = "¡Las contraseñas no coinciden!";

            if (error != "") {
                $("#errorUsuario").html(error);
                $("#errorUsuario").slideDown("slow");
                $("#errorUsuario").delay(2000).hide(600);
                return false;
            } else {
                var sexo = $("#rdiSexo:checked").val();
                var fechaNac = $("#dateFecha").val();
                var estado = $("#cmbEstado option:selected").val();
                var municipio = $("#cmbMunicipio option:selected").val();

                Enviar("editaUsuario.php?iusuario=" + usuario + "&contra=" + contra + "&isexo=" + sexo + "&fechaNac=" + fechaNac + "&iestado=" + estado + "&imunicipio=" + municipio + "&idependencia=" + dependencia, "popupEditaUsuario");
                //$('#popupEditaUsuario').bPopup().close();
                return false;
            }
            return false;
        });

        //AJAX
        function contarValoresSel(idSelect) {
            var oSelectedOptions = $("#" + idSelect + " option:selected");
            var result = oSelectedOptions.length;
            return result;
        }

        function contarValores(idSelect) {
            var len = document.getElementById(idSelect).length;
            var result = len;
            return result;
        }

        function armarValuesLocMex(otrLoc, la, lo) {
            var idPais = $("#cmb_paises option:selected").val();
            var idEstado = $("#cmb_estados option:selected").val();
            var idMunicipio = $("#cmb_municipios option:selected").val();
            var result = idPais + "|" + idEstado + "|" + idMunicipio + "|" + otrLoc + "|" + la + "|" + lo;
            return result;
        }

        function armarValuesLoc(otrLoc, la, lo) {
            var idPais = $("#cmb_paises option:selected").val();
            var result = idPais + "|" + otrLoc + "|" + la + "|" + lo;
            return result;
        }

        $('#cmb_paises').change(function() {
            var idx = this.value;
            //alert(idx);
            if (idx == 132) {
                //alert('Mostrando');
                $('.edos').show("easeInBounce");
            } else {
                //alert('Ocultando');
                $('.edos').hide("easeInBounce");
            }
        });

        $('#cmb_estados').change(function() {
            var idx = this.value;
            Enviar("gestionCatalogos.php?edo=" + idx, "divMpio");
        });
    });
})(jQuery);

function recogerTextos(selec, capa) {
    var resulta = "";
    if (document.getElementById(selec).length < 1)
        return resulta;
    //return selec;

    ;
    (function($) {
        $(function() {
            $("#" + selec + " option").each(function() {
                resulta += $(this).text() + "°"
                    //alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'))
            });
        });
    })(jQuery);

    $("#" + capa).val(resulta);
    return resulta;
}

function mostrarError(error, capa) {
    if (error != "") {
        $("#" + capa).html("¡" + error + "!");
        $("#" + capa).slideDown("slow");
        $("#" + capa).delay(2000).hide(600);
    }
}

function validarFormulario() {
    var area = $("#ar").val();
    var error = "";

    var existeImagenOc = false;
    if ($('#lImagen').length)
        var existeImagenOc = true;

    if ($("#txtTituloComunicado").val() == "")
        error = "Debe escribir un Título para el comunicado";
    else if ($("#txt_contenido").val() == "")
        error = "Debe escribir un contenido para el comunicado";
    else if ($("#date").val() == "")
        error = "Debe escribir una Fecha para el comunicado";
    else if (!existeImagenOc && $("#imagen").val() == "")
        error = "Debe seleccionar una Imagen para el comunicado";
    else if ($("#cmb_agentes :selected").length < 1)
        error = "Debe seleccionar al menos un Problema/Agente Causal";
    else if ($("#cmb_productos :selected").length < 1)
        error = "Debe seleccionar al menos un Hospedero/Producto";
    else if (document.getElementById("cmbLocsOculto").length < 1)
        error = "Debe agregar al menos una Localización";
    else if ($("#cmb_med_implementadas :selected").length < 1)
        error = "Debe seleccionar al menos una Medida Implementada";
    else if ($("#cmb_med_aimplementar :selected").length < 1)
        error = "Debe seleccionar al menos una Medida a Implementar";
    else if (area != 3 && $("#cmb_motivos :selected").length < 1)
        error = "Debe seleccionar al menos un Motivo de Notificación";
    else if (area == 3 && $("#cmb_contaminacion :selected").length < 1)
        error = "Debe seleccionar al menos un tipo de Contaminación";
    else if ($("#cmb_riesgo :selected").length < 1)
        error = "Debe seleccionar al menos una Categoría del Riesgo";
    else if ($("#cmb_reglamentacion :selected").length < 1)
        error = "Debe seleccionar al menos una Reglamentación";
    else if ($("#cmb_resolucion :selected").length < 1)
        error = "Debe seleccionar al menos una Resolución";
    //Se agrega validación para áreas de adscripción. LVC. 7-Junio-2017
    else if ($("#cmb_area_adscripcion :selected").length < 1)
        error = "Debe seleccionar al menos un Área de Adscripción";
    //Termina código nuevo.

    return error;
}

function consultarGraficos() {
    var url = "graficos.php"; // El script a dónde se realizará la petición.
    $.ajax({
        type: "POST",
        url: url,
        data: $("#filtros").serialize(), // Adjuntar los campos del formulario enviado.
        success: function(data) {
            $("#graficas").html(data); // Mostrar la respuestas del script PHP.
        }
    });
}

function EnviarFormulario() {
    //return validarFormulario();
    var error = validarFormulario()
    mostrarError(error, "errorAlerta");

    if (error != "")
        return false;
    //return false;
    recogerTextos("cmbLocsOculto", "resultLocs");
    recogerTextos("cmbEnlaces", "resultEnlaces");

    document.formVegetal.action = "agregarComunicado.php";
    document.forms['formVegetal'].submit();
    document.formVegetal.action = 'listado.php'
    return true;
}

function actualizaEstatusComunicado(idaux) {
    var id = idaux;
    var estatus = $("#id" + idaux).attr('checked');
    //		alert(id);
    //		alert (estatus);

    if (estatus == "checked") {
        estatus = "2";
    } else {
        estatus = "1";
    }

    var ajax;

    ajax = ajaxFunction();
    ajax.open("POST", "actualizarComunicados.php?id=" + id + "&estatus_comunicado=" + estatus, true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    ajax.send(null);
    //	    alert(id + estatus);	
}

function filtrarFecha(mod, action) {;
    (function($) {
        $(function() {
            var id = $("#tab_select").val();
            var d1 = $("#date0").val();
            var d2 = $("#date1").val();
            var rol = $("#rol").val();
            var update = $("#update").val();

            //alert(id+" "+d1+" "+d2);
            //return false;

            var cadEnviar = "listado_comunicados.php?tipo=" + id + "&mod=" + mod + "&da1=" + d1 + "&da2=" + d2 + "&rol=" + rol;

            if (update == 1) {
                cadEnviar += "&update=" + update;
            }

            if (action > -1)
                cadEnviar = cadEnviar + "&emitir=" + action;

            Enviar(cadEnviar, "tabla_comunicados");
        });
    })(jQuery);
}

/* Se crean funciones para buscador por palabras clave. Una función valida el texto ingresado, y la otra realiza la búsqueda
// Basado en búsqueda por fecha.
// LVC 27-Abril-2018
// Inicia código nuevo.*/
function validaTxtBPC(mod, action) {;
    (function($) {
        $(function() {
            var cadBusqueda = $("#txtBusPalClave").val();
            busquedaPalabrasClave(mod, action);
        });
    })(jQuery);
}

function busquedaPalabrasClave(mod, action) {;
    (function($) {
        $(function() {
            var pc = $("#txtBusPalClave").val();
            var id = $("#tab_select").val();
            var d1 = $("#date0").val();
            var d2 = $("#date1").val();
            var rol = $("#rol").val();
            var update = $("#update").val();

            pc = pc.trim();
            var cadEnviar = "listado_comunicados1.php?tipo=" + id + "&mod=" + mod + "&da1=" + d1 + "&da2=" + d2 + "&rol=" + rol + "&palClave=" + pc;

            if (update == 1) {
                cadEnviar += "&update=" + update;
            }

            if (action > -1)
                cadEnviar = cadEnviar + "&emitir=" + action;

            if (pc.length > 2) {
                Enviar(cadEnviar, "tabla_comunicados");
            } else {
                Enviar("listado_comunicados.php?tipo=" + id + "&mod=" + mod + "&da1=" + d1 + "&da2=" + d2 + "&rol=" + rol, "tabla_comunicados");
            }
        });
    })(jQuery);
}
// Termina código nuevo.

function mover(id, mod, action) {
    $("#tab_select").val(id);;
    (function($) {
        $(function() {
            var d1 = $("#date0").val();
            var d2 = $("#date1").val();

            var cadEnviar = "listado_comunicados.php?tipo=" + id + "&mod=" + mod + "&da1=" + d1 + "&da2=" + d2;

            if (action > -1)
                cadEnviar = cadEnviar + "&emitir=" + action;

            Enviar(cadEnviar, "tabla_comunicados");

            if (id == 0)
                $("#seleccionador").css({ 'margin-left': "225px" });
            else if (id == 1)
                $("#seleccionador").css({ 'margin-left': "305px" });
            else if (id == 2)
                $("#seleccionador").css({ 'margin-left': "390px" });
            else if (id == 3)
                $("#seleccionador").css({ 'margin-left': "470px" });
            else if (id == 4)
                $("#seleccionador").css({ 'margin-left': "550px" });
            else if (id == 5)
                $("#seleccionador").css({ 'margin-left': "635px" });
            else if (id == 6)
                $("#seleccionador").css({ 'margin-left': "715px" });

            //$('#seleccionador').show().animate({ 'left': 350 }, 300);
            //$("#seleccionador").stop().animate({left: ++c%2*100 }, 'fast');
        });
    })(jQuery);
}

function actualizar(id) {;
    (function($) {
        $(function() {
            var i = $("#ar_select").val();
            location.href = "form.php?mod=" + i + "&comunicado=" + id;
        });
    })(jQuery);
    //alert('Actualizando!!!');
}

//Se crea una función para validar si se desea cambiar el estatus de público a privado. LVC 28-Mayo-2018
function cambioPublicoPrivado(id, publicar, action) {
    if (confirm("Está a punto de cambiar el estatus del comunicado. ¿Está seguro de que desea aplicar el cambio?")) {
        mostrarDetalle(id, publicar, action);
    } else {
        alert("No se ha realizado cambio.");
    }
}

function mostrarDetalle(id, publicar, action) {;
    (function($) {
        $(function() {
            if (publicar) {
                document.getElementById("privado").style.cursor = "wait";
                $("#privado").prop("onclick", false);
                var modo = "edit"

                var cadEnviar = "listado_comunicados.php?idAlert=" + id + "&modo=" + modo;

                //alert(cadEnviar);

                if (action > -1)
                    cadEnviar = cadEnviar + "&emitir=" + action;
                //alert('Oli');	
                Enviar(cadEnviar, "info_alerta_" + id);
            } else {
                var prev_fila = $("#info_row").val();

                if (id != prev_fila) {
                    $(".info_alerta").html("");
                    $(".row_detalle").slideUp();
                    var modo = ""
                    if ($("#update").length)
                        modo = "&modo=mod";
                    //alert(modo);
                    var cadEnviar = "listado_comunicados.php?idAlert=" + id + modo;

                    if (action > -1)
                        cadEnviar = cadEnviar + "&emitir=" + action;

                    Enviar(cadEnviar, "info_alerta_" + id, true);
                    $("#row_" + id).slideDown();

                    $("#info_row").val(id);
                } else {
                    $(".info_alerta").html("");
                    $(".row_detalle").slideUp();
                    $("#info_row").val(0);
                }
            }
        });
    })(jQuery);
}

//Se modifica función para modificar el estatus de los registros del catálogo. LVC 14-Mayo-2018
function LanzarPopUp(tabla, nTabla) {
    var act = false;;
    (function($) {
        $(function() {
            var a = document.getElementById("elemento");
            a.value = tabla;

            var valSel = contarValoresSel("cmb_" + nTabla);

            if (nTabla) {
                //if(contarValoresSel("cmb_"+nTabla)<1)
                if (valSel < 1)
                    return false;
                act = true;
            }
            //$("#tbl").val(tabla);
            vestir();
            //alert(tabla)
            $('#popupCatalogos').bPopup({
                easing: 'easeOutBack',
                speed: 500,
                transition: 'slideDown',
                transitionClose: 'slideUp',
                onOpen: function() {
                    if (act) {
                        var a = document.getElementById("udpId");
                        a.value = $("#cmb_" + nTabla + " option:selected").val();
                        $("#txtNombre").val($("#cmb_" + nTabla + " option:selected").html());
                    } else
                        $("#nota").slideDown();
                },
                onClose: function() {
                    $("#txtNombre").val("");
                    $("#txtNcientifico").val("");
                    var a = document.getElementById("udpId");
                    a.value = "0";
                    $("#nota").slideUp();
                }
            });

            function contarValoresSel(idSelect) {
                var oSelectedOptions = $("#" + idSelect + " option:selected");
                var result = oSelectedOptions.length;
                return result;
            }

            function vestir() {
                var a = document.getElementById("elemento");
                var ide = parseInt(a.value);
                var etiqueta = "";
                var vCapa = "";
                switch (ide) {
                    case 1:
                        etiqueta = "Productos";
                        vCapa = "Productos";
                        break;
                    case 2:
                        etiqueta = "Oisas";
                        vCapa = "Oisas";
                        break;
                    case 3:
                        etiqueta = "Agentes";
                        vCapa = "Agentes";
                        break;
                    case 4:
                        etiqueta = "PVISs";
                        vCapa = "PVISss";
                        break;
                    case 5:
                        etiqueta = "PVIFSs";
                        vCapa = "PVIFSs";
                        break;
                    case 6:
                        etiqueta = "Fracción";
                        vCapa = "Fraccion";
                        break;
                    case 7:
                        etiqueta = "Medidas implementadas";
                        vCapa = "Mimplementadas";
                        break;
                    case 8:
                        etiqueta = "Medidas a implementar";
                        vCapa = "Mimplementar";
                        break;
                    case 9:
                        etiqueta = "Motivos";
                        vCapa = "Motivos";
                        break;
                    case 10:
                        etiqueta = "Riesgos";
                        vCapa = "Riesgos";
                        break;
                    case 11:
                        etiqueta = "Reglamentación";
                        vCapa = "Reglamentacion";
                        break;
                    case 12:
                        etiqueta = "Reglamentación Internacional";
                        vCapa = "Rinternacionals";
                        break;
                    case 13:
                        etiqueta = "Resolución";
                        vCapa = "Resolucion";
                        break;
                    case 14:
                        etiqueta = "Estatus";
                        vCapa = "Estatus";
                        break;
                    case 15:
                        etiqueta = "Nivel de riesgo";
                        vCapa = "N_Riesgo";
                        break;
                    case 16:
                        etiqueta = "Nivel de alerta";
                        vCapa = "N_Alerta";
                        break;
                    case 17:
                        etiqueta = "Comunicados";
                        vCapa = "Comunicados";
                        break;
                    case 18:
                        etiqueta = "Contaminación";
                        vCapa = "Contaminacion";
                        break;
                }

                var b = document.getElementById("capa");
                b.value = vCapa;

                if (ide > 90)
                    $('#ncientifico').show();
                else
                    $('#ncientifico').hide();

                $("#titulo_catalogo").html(">> " + etiqueta);

                //Si cumple la condición, muestra los estatus disponibles para el miembro del catálogo. LVC 14-Mayo-2018
                if (valSel > 0) {
                    $("#estatusRegistro").html("<tr><td colspan=\"3\" align=\"right\">Estatus: <input type=\"radio\" name=\"rdEstatus\" id=\"rdEstatus\" value=\"0\"> Inactivo	<input type=\"radio\" name=\"rdEstatus\" id=\"rdEstatus\" value=\"1\"> Activo<br> </td></tr>");
                } else {
                    $("#estatusRegistro").html("");
                }
                //Termina código nuevo.
            }
        });
    })(jQuery);
}

function ajaxFunction() {
    var xmlHttp;
    try {
        xmlHttp = new XMLHttpRequest();
        return xmlHttp;
    } catch (e) {
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
            return xmlHttp;
        } catch (e) {
            try {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                return xmlHttp;
            } catch (e) {
                alert("Tu navegador no soporta AJAX!");
                return false;
            }
        }
    }
}

//Funcion para invocar páginas php
function Enviar(_pagina, capa, b) {
    var ajax;
    ajax = ajaxFunction();
    ajax.open("POST", _pagina, true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 1) {
            document.getElementById(capa).innerHTML = "Rari está cargando, sea paciente por favor...";
            delay(2000);
        }
        if (ajax.readyState == 4) {
            if (b) {
                setTimeout(function() {
                    document.getElementById(capa).innerHTML = ajax.responseText;
                }, 300);
            } else {
                document.getElementById(capa).innerHTML = ajax.responseText;
            }
            //$("#"+capa).show(1000);
        }
    }
    ajax.send(null);
}

function descargarBitacora() {
    var valor = document.getElementById("totalRows").value;
    if (valor > 0) {;
        (function($) {
            $(function() {
                var idArea = $("#ar_select").val();
                var idUsuario = $("#us_select").val();
                var F1 = $("#date0").val();
                var F2 = $("#date1").val();
                var rol = $("#rol").val();

                location.href = 'bitacora.php?ar=' + idArea + "&us=" + idUsuario + "&fa1=" + F1 + "&fa2=" + F2 + "&rol=" + rol;
            });
        })(jQuery);
    }
}

function vistaPrevia(mod) {
    var error = validarFormulario()
    mostrarError(error, "errorAlerta");

    if (error != "")
        return false;

    recogerTextos("cmbLocsOculto", "resultLocs");
    recogerTextos("cmbEnlaces", "resultEnlaces");

    ventanaPrevisualizar = window.open('', 'ventanaPrevisualizar', 'width=960,height=700,scrollbars=yes, location=yes')
    document.formVegetal.target = 'ventanaPrevisualizar'
    document.formVegetal.action = 'previa.php?mod=' + mod
    document.formVegetal.submit()
}

function mostrarPDF() {
    document.filtros.target = '_blank'
    document.filtros.action = 'pdfGen.php'
    document.filtros.submit()
}

function genPDFimpresion(id) {
    window.open('pdfGen.php?id=' + id, 'ventanaPrevisualizar', 'width=960,height=700,scrollbars=yes, location=yes')
}

function verMas(id, mod) {
    window.open('previa.php?mod=' + mod + "&idAlerta=" + id, 'ventanaPrevisualizar', 'width=960,height=700,scrollbars=yes, location=yes')
}

//Se agrega función para actualizar los municipios 
function actualizaMunicipio(idEstado) {
    var xmlhttp;

    if (window.XMLHttpRequest) { // Codigo para IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // Codigo para versiones anteriores de IE, como IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("cmbMunicipio").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("POST", "actMunicipio.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("q=" + idEstado);
}

//Se agrega función para mostrar confirmación de contraseña
function cargaConfContra(cadena) {
    var xmlhttp;

    if (window.XMLHttpRequest) { // Codigo para IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // Codigo para versiones anteriores de IE, como IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("myDiv").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("POST", "muestraConfirmacion.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("q=" + cadena);
}

//Se agrega función para validar actualización de seguimientos. LVC 17-Octubre--2017
function EnviarFormularioSeg() {
    var error = validarFormulario()
    mostrarError(error, "errorAlerta");

    if (error != "")
        return false;
    recogerTextos("cmbLocsOculto", "resultLocs");
    recogerTextos("cmbEnlaces", "resultEnlaces");

    document.formVegetal.action = "actualizaSeguimiento.php"
    document.forms['formVegetal'].submit();
    document.formVegetal.action = 'bienvenido.php'
}

//Función para actualizar dinámicamente los elementos de una lista (formulario). LVC 15-Mayo-2018
function actListaPC(palabra, catalogo, modulo, comunicado, lista) {
    var contenedor = "#listado" + lista;

    if (palabra.length < 1) {
        palabra = "";
    };

    $.post("filtrarCatalogo.php", { valorP: palabra, valorC: catalogo, valorM: modulo, valorD: comunicado }, function(mensaje) {
        $(contenedor).html(mensaje);
    });
};