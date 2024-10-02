<h1>Tareas Programadas</h1>

<p>Tareas Programadas es un proyecto para el portafolio, donde los usuarios podran gestionar sus proyectos, tareas, trabajos, etc que tengan. Ofrece una interfaz intuitiva que permite al usuario navegar por los distintos endpoints de la aplicación.<br>Entre las funcionalidades que ofrece tenemos, apartado de gestion de proyectos y gestion del perfil.</p>

<h2>Gestion de Usuario</h2>
<p>El usuario al ingresar en la aplicación tiene varias opciones:</p>

<ul>
<li><strong>Ingresar como Usuario con Correo y Contraseña:</strong> Un login tradicional que permite al usuario logearse con sus credenciales previamente registradas en el sistema.</li>
<li><strong>Registrarse si es nuevo Usuario:</strong> Un formulario de registro donde el usuario puede ingresar los datos solicitados y registrase como nuevo usuario de la plataforma, con validacion por correo electronico donde el usuario a traves de un link enviado a su correo electronico debera ingresar y confirmar su cuenta con las intrucciones indicadas, para verificar que el usuario es una persona que esta ingresando en la plataforma.</li>
<li><strong>Reestablecer Contraseña en caso de olvido:</strong> El usuario debera ingresar el correo registrado, de esta manera nos aseguramos que es el usuario el que esta intentando cambiar la contraseña, despues de enviar al correo las intrucciones para el cambio de contraseña, la persona debera ingresar la nueva contraseña con la que se logeara.</li>
</ul>

<p>Además de todas estas funcionalidades la aplicacion ofrece otras a modo de seguridad como, el <strong>Hasheo</strong> de la contraseña, <strong>un solo</strong> correo puede estar registrado por usuario, verificacion de login por <strong>Sessiones</strong> para evitar que un usuario externo pueda ingresar a la plataforma y <strong>validacion</strong> en el dashboard que veremos más adelante.</p>

<h2>Gestion de Usuario</h2>
<p>El usuario al ingresar en el dashboard de la aplicacion tiene varias opciones:</p>

<ul>
<li><strong>Panel de Proyectos:</strong> Un panel donde el usuario podra visualizar los proyectos que ha creado así como añadir mas a su stock. Si da click en un proyecto visualizara las tareas que ese proyecto tiene asignado, vale aclarar que cada tarea es unica de cada proyecto así como cada proyecto es unico de cada usuario (diagrama de clases). Dentro del apartado de tareas, el usuario podra, <strong>Crear</strong> una nueva tarea, <strong>Eliminar</strong> el proyecto seleccionado, <strong>Modificar</strong> el estado de la tara seleccionada, <strong>Elimnar</strong> la tarea seleccionada.</li>
<li><strong>Panel de Gestion de Perfil:</strong> Un panel donde el usuario podra gestionar la informacion de su cuenta, todos los datos ingresados anteriormente en el registro de su cuenta y cambiar la contraseña</li>
</ul>

<p>Además de todas la funcionalidades antes descritas cada panel ofrece su validacion unica en caso de errores de <strong>capa 5, 6 o 7</strong> </p>

<h2>Herramientas Utilizadas</h2>
<p>Las herramientas utilizadas en este proyecto son las siguientes:</p>

<ul>
<li>HTML, CSS, SASS</li>
<li>JavaScript</li>
<li>PHP</li>
<li>MySql</li>
</ul>
<p>Todas estas herramientas fueron utilizadas, asi como aplicar el paradigma de programacion orientada a objetos <strong>POO</strong> con el Model View Controller <strong>MVC</strong> en PHP para el <strong>BackEnd</strong>. API como Fetch para la peticion al servidor y JavaScript para el manejo del DOM, así como el preprocesador SASS y HTML para el <strong>FrontEnd</strong>. Junto con diagramas de clases para la base de datos que permitieron desarrollar el proyecto.</p>

<p>Para el despliegue del proyecto, descargue el repositorio, instale las dependencias tanto en <strong>Npm</strong> como en <strong>Composer</strong> y lanze el proyecto desde la carpeta <strong>Public</strong></p>
