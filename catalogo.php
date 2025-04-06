<?php
session_start(); // Asegurar que la sesión está iniciada
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/logo.png" type="image/png">
    <title>Catálogo | Torre de Babel</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>

<nav class="navbar">
    <div class="logo"> 
        <a href="index.php"><img src="assets/images/logo.png" alt="Logo"></a>
        <a href="index.php" class="logo-text">Torre de Babel</a>
    </div>
    <ul class="nav-links">
        <li><a href="catalogo.php">Catálogo</a></li>
        <li><a href="servicios.php">Mi Biblioteca</a></li>
        <div class="auth-buttons">
            <?php if (isset($_SESSION["usuario_id"])): ?>
                <!-- Verificar si el usuario es admin y mostrar el enlace a admin.php -->
                <?php if ($_SESSION["es_admin"] == 1): ?>
                    <a href="admin.php">Administrar Usuarios</a>
                <?php endif; ?>
                <a href="php/logout.php">Cerrar Sesión</a>
            <?php else: ?>
                <a href="inicio_registro.php">Inicio - Registro</a>
            <?php endif; ?>
        </div>
    </ul>
    <div class="menu-icon" onclick="toggleMenu()">☰</div>
</nav>



    <div class="separador"></div>
    
    <main>
        <h1>CATÁLOGO</h1>
        
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Buscar libros..." />
            <button onclick="searchBooks()">Buscar</button>
        </div>

        <div class="catalog" id="book-list"></div>
    </main>

    <div class="separador"></div>
    <footer>
        <p>&copy; 2025 Plataforma de Libros. Todos los derechos reservados a Mohamed Iachi Ahmed.</p>
    </footer>

    <script>
        function toggleMenu() {
            document.querySelector('.nav-links').classList.toggle('show');
        }

        const apiKey = "AIzaSyC7-tpmOVlmpa9T5fpyKXroEN9FPo9Zk60";
        let query = "";
        const maxResults = 20;
        const user_id = <?php echo isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 'null'; ?>;

        function fetchBooks() {
            if (!query) {
                document.getElementById("book-list").innerHTML = "Por favor, ingresa un término de búsqueda.";
                return;
            }

            fetch(`https://www.googleapis.com/books/v1/volumes?q=${query}&maxResults=${maxResults}&key=${apiKey}`)
                .then(response => response.json())
                .then(data => {
                    let books = data.items;
                    let output = "";
                    if (books) {
                        books.forEach(book => {
                            let title = book.volumeInfo.title;
                            let authors = book.volumeInfo.authors ? book.volumeInfo.authors.join(", ") : "Desconocido";
                            let image = book.volumeInfo.imageLinks?.thumbnail || "https://via.placeholder.com/150";

                            output += `
                                <div class="book">
                                    <img src="${image}" alt="${title}">
                                    <h3>${title}</h3>
                                    <p><strong>Autor(es):</strong> ${authors}</p>
                                    <button onclick="agregarLibro('${title}', '${authors}', '${image}')">Agregar a Mi Biblioteca</button>
                                </div>
                            `;
                        });
                        document.getElementById("book-list").innerHTML = output;
                    } else {
                        document.getElementById("book-list").innerHTML = "No se encontraron resultados.";
                    }
                })
                .catch(error => {
                    console.error("Error al obtener los libros:", error);
                    document.getElementById("book-list").innerHTML = "Hubo un error al cargar los libros.";
                });
        }

        function searchBooks() {
            query = document.getElementById("search-input").value.trim();
            fetchBooks();
        }

        document.getElementById("search-input").addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
                searchBooks();
            }
        });

        function agregarLibro(title, authors, image) {
    if (user_id === null) {
        alert("Debes iniciar sesión para agregar libros.");
        return;
    }

    fetch('php/agregar_libro.php', {
        method: 'POST',
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
            'title': title,
            'authors': authors,
            'image': image
        })
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => {
        console.error("Error al agregar el libro:", error);
    });
}

    </script>
</body>
</html>
