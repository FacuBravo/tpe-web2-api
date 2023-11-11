# API Libreria

## ENDPOINTS GET:

### LIBROS

+ api/libros:

    **Devuelve todos los libros registrados**

        Ej:

        [
            {
                "id": "1",
                "titulo": "...",
                "genero": "...",
                "id_autor": "2",
                "descripcion": "...",
                "precio": "999"
            },
            {
                "id": "2",
                "titulo": "...",
                "genero": "...",
                "id_autor": "1",
                "descripcion": "...",
                "precio": "999"
            }
        ]

        Los resultados se pueden ordenar según un apartado:

        api/libros/?sort=titulo&order=desc

        =>

        (Devuelve los libros ordenados descendentemente por el título)

+ api/libros/:ID:

  **Devuelve un libro específico.**

        Ej:
  
        api/libros/1
  
        {
            "id": "1",
            "titulo": "...",
            "genero": "...",
            "id_autor": "2",
            "descripcion": "...",
            "precio": "999"
        }


+ api/libros/:ID/:subrecurso:

  **Devuelve un recurso específico de un libro específico.**

        Ej:
            api/libros/1/titulo  =>  "Titulo: ..."


+ api/libros/filtro?filterBy=?&value=?

    **Obtiene los resultados segun el filtro especificado**

        Ej:
            api/libros/filtro?filterBy=genero&value=drama

            También se pueden ordenar los resultados según un apartado:

            api/libros/filtro?filterBy=genero&value=drama&sort=titulo&order=desc

            =>

            (Devuelve los libros cuyo género contenga la palabra "drama" y los ordena descendentemente por el título)


### AUTORES

+ api/autores:

    **Devuelve todos los autores registrados**

        Ej:

        [
            {
                "id": "1",
                "nombre": "...",
                "descripcion": "..."
            },
            {
                "id": "2",
                "nombre": "...,
                "descripcion": "..."
            }
        ]

+ api/autores/:ID:

  **Devuelve un autor específico.**

        Ej:
  
        api/autores/4
  
        {
            "id": "4",
            "nombre": "Julio Cortazar",
            "descripcion": "Escritor argentino"
        }


+ api/autores/:ID/:subrecurso:

  **Devuelve un recurso específico de un autor específico.**

        Ej:
          api/libros/1/nombre  =>  "Nombre: ..."

## ENDPOINTS DELETE:

### LIBROS

+ api/libros/:ID:

  **Elimina un libro específico.**

        Si el libro existe:

        /api/libros/2  =>  "El libro con el id 2 fue eliminado"

        Si el libro no existe:

        /api/libros/999  =>  "El libro con el id 999 no existe"

### AUTORES

+ api/autores/:ID:

  **Elimina un autor específico.**

        Si el autor existe:

        /api/autores/2  =>  "El autor con el id 2 fue eliminado"

        Si el autor no existe:

        /api/autores/999  =>  "El autor con el id 999 no existe"

## ENDPOINTS POST:

### LIBROS

+ api/libros:

  **Agrega un libro.**

        Body:

        {
            "titulo": "...",
            "genero": "...",
            "id_autor": "1",
            "descripcion": "...",
            "precio": "999"
        }

        Si se agregó:

        "Libro agregado con el id #"

### AUTORES

+ api/autores:

  **Agrega un autor.**

        Body:

        {
            "nombre": "...",
            "descripcion": "...",
        }

        Si se agregó:

        "Autor agregado con el id #"

## ENDPOINTS PUT

### LIBROS

+ api/libros/:ID:

  **Modifica un libro específico.**

        Body:

        {
            "titulo": "...",
            "genero": "...",
            "id_autor": "1",
            "descripcion": "...",
            "precio": "999"
        }

        Si el libro existe:

        /api/libros/3  =>  "El libro con el id 3 se actualizó correctamente"

        Si el libro no existe:

        /api/libros/999  =>  "El libro con el id 999 no existe"

### AUTORES

+ api/autores/:ID:

  **Modifica un autor específico.**

        Body:

        {
            "nombre": "...",
            "descripcion": "...",
        }

        Si el autor existe:

        /api/autores/3  =>  "El autor con el id 3 se actualizó correctamente"

        Si el autor no existe:

        /api/autores/999  =>  "El autor con el id 999 no existe"