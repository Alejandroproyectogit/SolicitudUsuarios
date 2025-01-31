<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Recuperar Contraseña</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="assets/plugins/pace/pace.css" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="assets/css/main.min.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icono-logo.webp" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icono-logo.webp" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container" id="formularioCorreo">
            <div class="logo">
                <a href="index.html">Recuperar Contraseña</a>
            </div>

            <div class="divider"></div>

            <!-- Formulario Para Recibir El Correo Del Usuario -->

            <form id="formRecuContra">
                <div class="auth-credentials m-b-xxl">
                    <label for="signInEmail" class="form-label">Correo Electronico</label>
                    <input type="Email" class="form-control m-b-md" id="correo" name="correo" aria-describedby="signInEmail" placeholder="Ingresa tu correo" required>

                </div>

                <div class="auth-submit">

                    <!-- Envia Formulario Y Se Activa El Script -->
                    <button type="submit" class="btn btn-primary">Enviar</button>

                    <!-- Link para ir al inicio de sesión -->
                    <a href="index.php" class="auth-forgot-password float-end">Iniciar Sesión</a>
                </div>
            </form>
            <div class="divider"></div>

        </div>
    </div>

    <!-- Javascripts -->
    <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        $(document).ready(function() {

            /* Codigo que se activa cuando se envia el formulario #formRecuContra */
            $(document).on("submit", "#formRecuContra", function(e) {
                e.preventDefault();

                // Recibimos el valor del id #correo
                var correo = $("#correo").val();

                // Hacemos una peticion AJAX para enviar el correo al backend
                $.ajax({
                    //Enviamos la variable "correo" por post a user/procesoRecuperacion.php en formato JSON
                    url: 'user/procesoRecuperacion.php',
                    type: 'POST',
                    data: {
                        correo: correo
                    },
                    dataType: 'json',
                    //recibimos la respuesta
                    success: function(response) {
                        if (response.status == "success") {
                            // Se respondera una variable "status" del archivo user/procesoRecuperacion.php, y si su valor es igual a "success" se mostrara la alerta de exito

                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "success",
                                title: "Se Envio Un Codigo A Tu Correo"
                            });
                            // Luego se cambia el formulario que tiene el input del correo al formulario en donde se pide el codigo de recuperación de contraseña
                            document.getElementById("formularioCorreo").innerHTML = `
                                <div class="logo">
                                    <a href="index.html">Recuperar Contraseña</a>
                                </div>
                                
                                <div class="divider"></div>

                                <form id="formRecuContra2">
                                    <div class="auth-credentials m-b-xxl">
                                    <label for="signInEmail" class="form-label">Codigo: </label>
                                    <input type="password" class="form-control m-b-md" id="codigo" name="codigo" aria-describedby="signInEmail" placeholder="Ingresa tu codigo" maxlength="5" required>

                                    </div>

                                    <div class="auth-submit">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                        <a href="index.php" class="auth-forgot-password float-end">Iniciar Sesión</a>
                                    </div>
                                </form>
                                <div class="divider"></div>
                            `;
                        
                        } else if (response.status == "error"){
                            //Si el archivo user/procesoRecuperacion.php responde que la variable status es igual a error, saldra la alerta de error
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: response.message
                            });
                        }
                    }
                });
            });

            //Este codigo se ejecuta cuando se envia el formulario #formRecuContra2, este formulario se encuentra en el innerHTML de arriba
            $(document).on("submit", "#formRecuContra2", function(evento) {
                evento.preventDefault();

                //Se obtiene el valor del input codigo
                var codigo = $("#codigo").val();
                
                //Se hace una peticion AJAX para validar el codigo del usuario
                $.ajax({
                    //Se envia la variable "codigo" por post a user/validarCodigo.php en formato JSON
                    url: 'user/validarCodigo.php',
                    type: 'POST',
                    data: {
                        codigo: codigo
                    },
                    dataType: 'json',
                    //Se recibe la respuesta
                    success: function(response) {
                        if (response.status == "success") {
                            // Se respondera una variable "status" del archivo user/validarCodigo.php, y si su valor es igual a "success" se cambiara el formulario formRecuContra2 al formulario formRecuContra3.
                            //En este formulario se pide la nueva contraseña y se confirma la misma
                            document.getElementById("formularioCorreo").innerHTML = `
                                <div class="logo">
                                    <a href="index.html">Recuperar Contraseña</a>
                                </div>
                                
                                <div class="divider"></div>

                                <form id="formRecuContra3">
                                    <div class="auth-credentials m-b-xxl">
                                        <label for="signInPassword" class="form-label">Nueva Contraseña: </label>
                                        <input type="password" class="form-control" id="nuevaPass" aria-describedby="signInPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                                        <label for="signInPassword" class="form-label">Confirmar Nueva Contraseña: </label>
                                        <input type="password" class="form-control" id="confirmPass" aria-describedby="signInPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;" required>
                                        <div id="avisoError" class="avisoError badge badge-style-light badge-danger"></div>
                                    </div>

                                    <div class="auth-submit">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                        <a href="index.php" class="auth-forgot-password float-end">Iniciar Sesión</a>
                                    </div>
                                </form>
                                <div class="divider"></div>
                            `;
                        } else if (response.status == "error") {
                            // Si el archivo user/validarCodigo.php responde que la variable status es igual a error, se mostrara la alerta de error
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 5000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: response.message
                            });
                        } else if (response.status == "errorCodigo") {
                            // Si el archivo user/validarCodigo.php responde que la variable status es igual a errorCodigo, es porque venció el codigo, se mostrara la alerta de error.
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                }
                            });
                            Toast.fire({
                                icon: "error",
                                title: response.message
                            }).then(() => {
                                //Despues se enviara nuevamente al apartado de recuperar contraseña para que genere otro codigo
                                window.location.href = 'recuperarContrasena.php';
                            });
                        }
                    }
                });
            });

            //Este codigo se ejecuta cuando se envia el formulario #formRecuContra3, este formulario se encuentra en el innerHTML de arriba
            $(document).on("submit", "#formRecuContra3", function(event) {
                event.preventDefault();

                //Se obtienen los valores de la contraseña nueva y de la confirmación
                var nuevaPass = $("#nuevaPass").val();
                var confirmPass = $("#confirmPass").val();

                //Se envian las variables por AJAX al archivo user/actualizarContrasena.php por post en formato JSON

                $.ajax({
                    url: 'user/actualizarContrasena.php',
                    type: 'POST',
                    data: {
                        nuevaPass: nuevaPass,
                        confirmPass: confirmPass
                    },
                    dataType: 'json',
                    //Se recibe la respuesta
                    success: function(response) {
                        //Si el archivo user/actualizarContrasena.php responde que la variable status es igual a success, se mostrara la alerta de exito y redireccionara al inicio de sesion
                        if (response.status == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Contraseña Actualizada',
                                text: response.message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'index.php';
                                }
                            });
                        
                        } else if (response.status == "error") {
                            //Si el archivo user/actualizarContrasena.php responde que la variable status es igual a error, se mostrara la alerta de error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    }
                });
            });


        });
    </script>
</body>

</html>