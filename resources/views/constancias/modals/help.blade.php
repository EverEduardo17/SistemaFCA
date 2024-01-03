<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-header bg-info">
                <h2 class="modal-title text-white" id="exampleModalLabel">Ayuda</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <h3>Manual de Usuario: Generación de Constancias</h3>
    
                <p>Este manual proporciona instrucciones sobre cómo generar constancias utilizando el sistema basado en plantillas.</p>

                <h5>Formato y palabras clave:</h5>
                
                <ol>
                    <li>Las plantillas de constancias deben estar en formato <code>.docx</code>.</li>
                    <li>Utiliza palabras clave especiales con un "$" y encerradas entre llaves <code>${}</code>, estas serán reemplazadas con valores específicos.</li>
                </ol>

                <h5>Lista de palabras clave:</h5>
                <div style="margin-left: 20px;">
                    <p>
                        Los valores de las palabras clave en la plantilla serán extraídos de los participantes agregados a la constancia.
                        A continuación se muestra el listado de las palabras clave que pueden ser utilizados en la plantilla:
                    </p>
                    
                    <ul>
                        <li><code>${nombre_participante}</code>: Nombre completo del participante, empezando por apellidos.</li>
                        <li><code>${matricula}</code>: La matrícula del participante.</li>
                        <li><code>${programa_educativo}</code>: Nombre del programa educativo del participante.</li>
                        <li><code>${nombre_constancia}</code>: Nombre de la constancia.</li>
                        <li><code>${el/la}</code>: Pronombre "el" si el participante es hombre, o "la" si el participante es mujer.</li>
                        <li><code>${o/a}</code>: Letra "o" si el participante es hombre, o letra "a" si el participante es mujer. Se utiliza para personalizar el género en las palabras requeridas.</li>
                        <li><code>${vigencia}</code>: La fecha limite en la que la constancia es vigente. El formato de la fecha es: <strong>día/mes/año</strong>. Si la constancia no tiene una vigencia establecida, este campo se reemplazará con la palabra <strong>Indefinida</strong>.</li>
                        <br>
                        <li><code>${nombre_direccion}</code>: El nombre del director/a</li>
                        <li><code>${img_firma}</code>: La firma de la dirección, en caso de requerirla para las constancias aprobadas.</li>
                        <li><code>${codigo_qr}</code>: Este campo será reemplazado con un código QR que dirige a la página de detalles del participante en cuestión.</li>
                    </ul>

                    <p><strong>Estos campos son opcionales y si no los considera necesarios, pueden ser omitidos.</strong></p>
                </div>

                <p>Una vez personalizada la plantilla, los datos de los participantes se generaran de manera automatica en sus respectivas constancias.</p>
                <p>Puede facilitar este proceso utilizando la <a href="{{ route('constancias.downloadGenerica') }}">plantilla génerica</a> ofrecida.</p>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>