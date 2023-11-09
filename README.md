##ENDPOINTS GET:

    **- 'api/libros':**

        Devuelve todos los libros registrados.

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


    **- 'api/libros/:ID':**

        Devuelve un libro específico.

        Ej:

        {
            "id": "1",
            "titulo": "...",
            "genero": "...",
            "id_autor": "2",
            "descripcion": "...",
            "precio": "999"
        }


    **- 'api/libros/:ID/:subrecurso':**

        Devuelve un recurso específico de un libro específico.

        Ej:

        "Titulo: ..."


##ENDPOINTS DELETE:

    **- 'api/libros/:ID':**

        Elimina un libro específico.

        Si el libro existe:

        /api/libros/2  =>  "El libro con el id 2 fue eliminado"

        Si el libro no existe:
        /api/libros/999  =>  "El libro con el id 999 no existe"


##ENDPOINTS POST:

    **- 'api/libros':**

        Agrega un libro.

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


##ENDPOINTS PUT

    **- 'api/libros/:ID':**

        Modifica un libro específico.

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