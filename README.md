# Atzicay Backend

Atzicay Backend es una aplicación desarrollada en PHP utilizando el framework Laravel. Este proyecto implementa una arquitectura limpia y modular, con un enfoque en la separación de responsabilidades y el uso de patrones de diseño como repositorios, casos de uso y mapeadores.

## Estructura del Proyecto

El proyecto está organizado en las siguientes capas principales:

### 1. **Domain**
Contiene las entidades, enumeraciones y repositorios que definen el núcleo del dominio de la aplicación.

- **Entities**: Representan los modelos principales del dominio, como `User`, `Country`, `GameInstances`, y `Assessment`.
- **Enums**: Enumeraciones que definen valores constantes, como `Gender`, `Difficulty`, `Mode`, `Orientation`, `Presentation`, y `Visibility`.
- **Repositories**: Interfaces que definen los contratos para interactuar con las entidades del dominio, como `AssessmentRepository` y `CountryRepository`.

### 2. **Application**
Implementa la lógica de negocio a través de casos de uso y mapeadores.

- **Use Cases**: Casos de uso como `CreateAssessmentUseCase`, `GetAllCountriesUseCase`, y `UpdateAssessmentUseCase`, que encapsulan la lógica de negocio.
- **Mappers**: Clases como `CountryMapper` y `AssessmentMapper`, que convierten entre entidades, DTOs y arrays.

### 3. **Infrastructure**
Proporciona implementaciones concretas para los repositorios y adaptadores necesarios para interactuar con la base de datos.

- **Adapters**: Implementaciones como `EloquentAssessmentRepository`, que utiliza Eloquent para interactuar con la base de datos.
- **Http\Requests**: Clases como `StoreUserRequest` y `StoreCountryRequest`, que validan las solicitudes HTTP entrantes.

## Instalación

1. Clona este repositorio:
   ```bash
   git clone https://github.com/IngSystemCix/atzicay_backend.git
   cd atzicay-backend
   ```
2. Instala las dependencias de PHP:
    ```bash
    composer install
    ```
3. Configura el archivo .env con los detalles de tu base de datos y otras configuraciones necesarias.

4. Ejecuta las migraciones para crear las tablas en la base de datos:
    ```bash
    php artisan migrate
    ```
5. Inicia el servidor de desarrollo:
    ```bash
    php artisan serve
    ```
**Documentación de la API:**

El proyecto utiliza L5 Swagger para documentar la API. Puedes acceder a la documentación generada en la ruta `api/atizicay/v1/doc` después de iniciar el servidor.

**Esquemas Principales:**

- **User:** Representa un usuario con propiedades como Email, Name, Gender, y Birthdate.
- **Country:** Representa un país con propiedades como Name.
- **GameInstances:** Representa una instancia de juego con propiedades como Name, Description, y Difficulty.
- **Assessment:** Representa una evaluación con propiedades como Value y Comments.

**Enumeraciones:**

- **Gender:** M (Male), F (Female), O (Other).
- **Difficulty:** E (Easy), M (Medium), H (Hard).
- **Visibility:** P (Public), R (Private).
- **Mode:** II (Image to Image), ID (Image to Description).
- **Orientation:** Define orientaciones como HORIZONTAL_LEFT, VERTICAL_UP, etc.
- **Presentation:** A (Aleatory), F (Fixed).