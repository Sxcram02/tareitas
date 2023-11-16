# Tareitas
> Una vez terminada la tercera unidad, ya tenemos los conocimientos necesarios para
> resolver problemas que además de una lógica compleja, el uso de estructuras de control,
> funciones y tipos de datos compuestos, requieran de la utilización de formularios web,
> buenas prácticas de programación, así como el uso de características avanzadas de PHP.
>
> A lo largo de está tarea, vamos a implementar una aplicación web completa a partir de su
> especificación de requisitos software y algunos bocetos de baja fidelidad que se
>realizarán en la pizarra de clase.
>
> La aplicación se llamará Tareitas y reciclará la idea del ejercicio 2 de la anterior práctica,
> eso sí, dándole una mayor funcionalidad e interacción con el usuario mediante el uso de
> una interfaz web.

# La Especificación de Requisitos Software (ERS) mínima es la siguiente:
## Requisitos Funcionales:

<hr />

* RF-1. Gestión de listas de tareas
  * RF-1.1. Crear una lista de tareas
  * RF-1.2. Editar el nombre de una lista
  * RF-1.3. Acceder a una lista de tareas
  * RF-1.4. Borrar una lista
* RF-2. Gestión de tareas
  * RF-2.1. Crear una tarea
    * RF-2.2. Editar una tarea
    * RF-2.2.1. Editar descripción
    * RF-2.2.2. Cambiar prioridad
    * RF-2.2.2. Cambiar fecha límite
  * RF-2.3. Marcar una tarea como realizada
    * RF-2.3.1 Desmarcar una tarea no realizada
  * RF-2.4. Borrar una tarea
* RF-3. Gestión de notas
  * RF-3.1. Crear una nota
  * RF-3.2. Editar una nota
    * RF-3.2.1. Editar título
    * RF-3.2.2. Editar contenido
    * RF-3.2.3. Cambiar color
  * RF-3.3. Asociar a una lista (opcional)
  * RF-3.4. Borrar una nota
  
## Requisitos No funcionales:

<hr />

### RNF-1 Usabilidad
1. RNF-1.1. La aplicación debe ser fácil de usar.
2. RNF-1.2. Se contará con mensajes de ayuda y avisos de error.
3. RNF-1.3. La interfaz de usuario debe ser intuitiva.
4. RNF-1.4. La interfaz de usuario debe ser responsive. (opcional)

### RNF-2 Funcionalidad
1. RNF-2.1. Las tareas podrán estar o no asociadas a una lista, esto se
decidirá al momento de crearla.
2. RNF-2.2. Cada lista podrá tener notas asociadas o ninguna. (opcional)
3. RNF-2.3. Al eliminar una lista se deben borrar todas las tareas (y notas)
asociadas.

### RNF-3 Interfaz e interacción
1. RNF-3.1. Tendremos al menos tres páginas: una principal donde se mostrarán todas las tareas pendientes, otra para ver las listas de tareas existentes y acceder a ellas, así como una para ver las todas las notas.
2. RNF-3.2. Cuando accedamos a una lista se cargarán todas sus tareas (y las notas que tenga), además nos permitirá crear nuevas tareas (y notas) asociadas a la lista.
3. RNF-3.3. Existirá un botón para marcar todas las tareas de una lista como realizadas y otro para borrar todas las tareas. En ambos casos se debe avisar al usuario con una confirmación tipo alert.
4. RNF-3.4. Podremos añadir tareas desde la pantalla principal, es decir dónde aparecen todas las tareas. En este caso nos dará la opción de seleccionar entre una de nuestras listas o no asociarla a ninguna.
5. RNF-3.5. Podremos añadir notas desde el tablón, es decir dónde aparecen todas las tareas. En este caso nos dará la opción de seleccionar entre una de nuestras listas o no asociarla a ninguna.

### Requisitos de Información:
* RI-1. Lista de tareas
  * Nombre
  * Tareas
  * Notas
* RI-2. Tarea
  * Descripción
  * Prioridad
  * Fecha límite
  * Estado
* RI-3. Nota
  * Título
  * Contenido
